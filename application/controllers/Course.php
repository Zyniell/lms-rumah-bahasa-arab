<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Course Controller for LMS Rumah Bahasa Arab
 */
class Course extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Course_model');
		$this->load->model('Lesson_model');
		$this->load->model('Enrollment_model');
		$this->load->model('Transaction_model');
	}

	/**
	 * Course catalog with free/paid filters
	 */
	public function index()
	{
		$filterType = $this->input->get('type', TRUE);
		if (!in_array($filterType, array('free', 'paid'))) {
			$filterType = null;
		}

		$courses = $this->Course_model->getAll($filterType, 'published');

		$data = array(
			'title'       => 'Katalog Kelas Bahasa Arab',
			'courses'     => $courses,
			'currentType' => $filterType
		);

		$this->renderView('courses/index', $data, 'public');
	}

	/**
	 * Course detail and syllabus outline
	 *
	 * @param string $slug
	 */
	public function detail($slug)
	{
		$course = $this->Course_model->getBySlug($slug, 'published');
		if (!$course) {
			// Try by ID in case an ID was passed
			if (is_numeric($slug)) {
				$course = $this->Course_model->getById($slug);
			}
		}

		if (!$course) {
			show_404();
			return;
		}

		$lessons = $this->Lesson_model->getByCourse($course->id);

		$isEnrolled = false;
		$pendingTransaction = null;

		if ($this->isLoggedIn()) {
			$userId = $this->currentUser['id'];
			$isEnrolled = $this->Enrollment_model->isEnrolled($userId, $course->id);

			if (!$isEnrolled && $course->type === 'paid') {
				// Check for pending transaction
				$this->db->where('user_id', $userId);
				$this->db->where('course_id', $course->id);
				$this->db->where('status', 'pending');
				$pendingTransaction = $this->db->get('transactions')->row();
			}
		}

		$data = array(
			'title'              => $course->title,
			'course'             => $course,
			'lessons'            => $lessons,
			'isEnrolled'         => $isEnrolled,
			'pendingTransaction' => $pendingTransaction
		);

		$this->renderView('courses/detail', $data, 'public');
	}

	/**
	 * Direct enrollment for free courses
	 *
	 * @param int $courseId
	 */
	public function enrollFree($courseId)
	{
		$course = $this->Course_model->getById($courseId);
		if (!$course || $course->status !== 'published') {
			show_404();
			return;
		}

		// Enforce login
		if (!$this->isLoggedIn()) {
			$this->session->set_userdata('return_url', site_url('course/enroll-free/' . $course->id));
			$this->session->set_flashdata('warning', 'Silakan masuk atau buat akun terlebih dahulu untuk mengikuti kelas gratis ini.');
			redirect('auth/login');
			return;
		}

		if ($course->type !== 'free') {
			$this->session->set_flashdata('error', 'Kelas ini adalah kelas berbayar. Silakan lakukan proses pembelian.');
			redirect('checkout/' . $course->id);
			return;
		}

		$userId = $this->currentUser['id'];
		$this->Enrollment_model->enroll($userId, $course->id);

		$this->session->set_flashdata('success', 'Selamat! Anda berhasil terdaftar di kelas "' . html_escape($course->title) . '". Selamat belajar!');
		redirect('learn/' . $course->id);
	}
}
