<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Enrollment Model for LMS Rumah Bahasa Arab
 */
class Enrollment_model extends CI_Model {

	protected $table = 'enrollments';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Check if a user is currently enrolled in a course with active status
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @return bool
	 */
	public function isEnrolled($userId, $courseId)
	{
		$this->db->where('user_id', (int)$userId);
		$this->db->where('course_id', (int)$courseId);
		$this->db->where('status', 'active');
		return $this->db->count_all_results($this->table) > 0;
	}

	/**
	 * Enroll a user into a course (insert or update status to active)
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @return bool
	 */
	public function enroll($userId, $courseId)
	{
		// Check if record already exists
		$existing = $this->db->get_where($this->table, array(
			'user_id'   => (int)$userId,
			'course_id' => (int)$courseId
		))->row();

		if ($existing) {
			$this->db->where('id', $existing->id);
			return $this->db->update($this->table, array(
				'status'      => 'active',
				'enrolled_at' => date('Y-m-d H:i:s')
			));
		}

		return $this->db->insert($this->table, array(
			'user_id'     => (int)$userId,
			'course_id'   => (int)$courseId,
			'enrolled_at' => date('Y-m-d H:i:s'),
			'status'      => 'active'
		));
	}

	/**
	 * Get all active courses enrolled by a user, including progress calculations
	 *
	 * @param int $userId
	 * @return array
	 */
	public function getUserEnrolledCourses($userId)
	{
		$this->db->select('courses.*, enrollments.enrolled_at, COUNT(DISTINCT lessons.id) AS total_lessons');
		$this->db->from($this->table);
		$this->db->join('courses', 'courses.id = enrollments.course_id');
		$this->db->join('lessons', 'lessons.course_id = courses.id', 'left');
		$this->db->where('enrollments.user_id', (int)$userId);
		$this->db->where('enrollments.status', 'active');
		$this->db->group_by('courses.id');
		$this->db->order_by('enrollments.enrolled_at', 'DESC');
		$courses = $this->db->get()->result();

		// Calculate completed lessons & percentage for each course
		foreach ($courses as $c) {
			$this->db->where('user_id', (int)$userId);
			$this->db->where('course_id', (int)$c->id);
			$c->completed_lessons = $this->db->count_all_results('lesson_progress');

			if ((int)$c->total_lessons > 0) {
				$c->progress_percent = (int)round(($c->completed_lessons / $c->total_lessons) * 100);
			} else {
				$c->progress_percent = 0;
			}
		}

		return $courses;
	}

	/**
	 * Get list of students enrolled in a specific course
	 *
	 * @param int $courseId
	 * @return array
	 */
	public function getCourseStudents($courseId)
	{
		$this->db->select('users.id AS user_id, users.name, users.email, enrollments.enrolled_at, enrollments.status');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = enrollments.user_id');
		$this->db->where('enrollments.course_id', (int)$courseId);
		$this->db->order_by('enrollments.enrolled_at', 'DESC');
		return $this->db->get()->result();
	}

	/**
	 * Get total active enrollments count
	 *
	 * @return int
	 */
	public function countTotalEnrollments()
	{
		$this->db->where('status', 'active');
		return $this->db->count_all_results($this->table);
	}
}
