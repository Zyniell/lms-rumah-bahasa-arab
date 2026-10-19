<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classroom Controller for LMS Rumah Bahasa Arab
 * Handles YouTube video playback, playlist navigation, and progress tracking.
 */
class Classroom extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireLogin();
		$this->load->model('Course_model');
		$this->load->model('Lesson_model');
		$this->load->model('Enrollment_model');
		$this->load->model('Progress_model');
	}

	/**
	 * Learning room with YouTube player and playlist
	 *
	 * @param int $courseId
	 * @param int|null $lessonId
	 */
	public function learn($courseId, $lessonId = null)
	{
		$course = $this->Course_model->getById($courseId);
		if (!$course) {
			show_404();
			return;
		}

		$userId = $this->currentUser['id'];

		// Enforce enrollment check (Admins can preview any course)
		if ($this->currentUser['role'] !== 'admin' && !$this->Enrollment_model->isEnrolled($userId, $course->id)) {
			$this->session->set_flashdata('error', 'Akses ditolak. Anda belum terdaftar di kelas ini.');
			redirect('course/' . $course->slug);
			return;
		}

		$lessons = $this->Lesson_model->getByCourse($course->id);
		if (empty($lessons)) {
			$this->session->set_flashdata('warning', 'Kelas ini belum memiliki materi video.');
			redirect('course/' . $course->slug);
			return;
		}

		// Identify active lesson
		$currentLesson = null;
		if ($lessonId !== null) {
			foreach ($lessons as $l) {
				if ((int)$l->id === (int)$lessonId) {
					$currentLesson = $l;
					break;
				}
			}
		}

		// Fallback to first lesson if not found or not specified
		if (!$currentLesson) {
			$currentLesson = $lessons[0];
		}

		// Fetch completed lesson IDs
		$completedIds = $this->Progress_model->getCompletedLessonIds($userId, $course->id);
		$isCurrentLessonCompleted = in_array((int)$currentLesson->id, $completedIds);

		// Calculate overall progress percentage
		$progressPercent = $this->Progress_model->getCourseProgressPercentage($userId, $course->id);

		// Get prev & next lessons
		$adjacent = $this->Lesson_model->getAdjacentLessons($course->id, $currentLesson->order_num);

		$data = array(
			'title'                    => $currentLesson->title . ' - ' . $course->title,
			'course'                   => $course,
			'lessons'                  => $lessons,
			'currentLesson'            => $currentLesson,
			'completedIds'             => $completedIds,
			'isCurrentLessonCompleted' => $isCurrentLessonCompleted,
			'progressPercent'          => $progressPercent,
			'prevLesson'               => $adjacent['prev'],
			'nextLesson'               => $adjacent['next']
		);

		$this->renderView('classroom/learn', $data, 'classroom');
	}

	/**
	 * Toggle completed state for a lesson
	 *
	 * @param int $courseId
	 * @param int $lessonId
	 */
	public function toggleProgress($courseId, $lessonId)
	{
		$userId = $this->currentUser['id'];

		// Verify enrollment
		if ($this->currentUser['role'] !== 'admin' && !$this->Enrollment_model->isEnrolled($userId, $courseId)) {
			if ($this->input->is_ajax_request()) {
				echo json_encode(array('success' => false, 'message' => 'Unauthorized'));
				return;
			}
			redirect('courses');
			return;
		}

		$isCompleted = $this->Progress_model->toggleProgress($userId, $courseId, $lessonId);
		$newPercentage = $this->Progress_model->getCourseProgressPercentage($userId, $courseId);

		if ($this->input->is_ajax_request()) {
			echo json_encode(array(
				'success'          => true,
				'is_completed'     => $isCompleted,
				'progress_percent' => $newPercentage,
				'csrf_token'       => $this->security->get_csrf_hash()
			));
			return;
		}

		$statusMessage = $isCompleted ? 'Materi berhasil ditandai selesai!' : 'Tanda selesai dibatalkan.';
		$this->session->set_flashdata('success', $statusMessage);
		redirect('learn/' . $courseId . '/' . $lessonId);
	}
}
