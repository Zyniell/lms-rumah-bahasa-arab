<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Progress Model for LMS Rumah Bahasa Arab
 */
class Progress_model extends CI_Model {

	protected $table = 'lesson_progress';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get array of completed lesson IDs for a specific user and course
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @return array
	 */
	public function getCompletedLessonIds($userId, $courseId)
	{
		$this->db->select('lesson_id');
		$this->db->where('user_id', (int)$userId);
		$this->db->where('course_id', (int)$courseId);
		$results = $this->db->get($this->table)->result();

		$ids = array();
		foreach ($results as $row) {
			$ids[] = (int)$row->lesson_id;
		}
		return $ids;
	}

	/**
	 * Check if a specific lesson is completed by user
	 *
	 * @param int $userId
	 * @param int $lessonId
	 * @return bool
	 */
	public function isCompleted($userId, $lessonId)
	{
		$this->db->where('user_id', (int)$userId);
		$this->db->where('lesson_id', (int)$lessonId);
		return $this->db->count_all_results($this->table) > 0;
	}

	/**
	 * Toggle lesson completion state (mark / unmark)
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @param int $lessonId
	 * @return bool Returns true if now completed, false if unmarked
	 */
	public function toggleProgress($userId, $courseId, $lessonId)
	{
		if ($this->isCompleted($userId, $lessonId)) {
			// Unmark: remove from database
			$this->db->where('user_id', (int)$userId);
			$this->db->where('lesson_id', (int)$lessonId);
			$this->db->delete($this->table);
			return false;
		} else {
			// Mark as completed
			$this->db->insert($this->table, array(
				'user_id'      => (int)$userId,
				'course_id'    => (int)$courseId,
				'lesson_id'    => (int)$lessonId,
				'completed_at' => date('Y-m-d H:i:s')
			));
			return true;
		}
	}

	/**
	 * Calculate course progress percentage for a student
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @return int 0 to 100
	 */
	public function getCourseProgressPercentage($userId, $courseId)
	{
		// Count total lessons
		$this->db->where('course_id', (int)$courseId);
		$totalLessons = $this->db->count_all_results('lessons');

		if ($totalLessons === 0) {
			return 0;
		}

		// Count completed lessons
		$this->db->where('user_id', (int)$userId);
		$this->db->where('course_id', (int)$courseId);
		$completedLessons = $this->db->count_all_results($this->table);

		return (int)round(($completedLessons / $totalLessons) * 100);
	}
}
