<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller for LMS Rumah Bahasa Arab
 * Manages courses, YouTube video lessons, transactions verification, and students.
 */
class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAdmin();
		$this->load->model('Course_model');
		$this->load->model('Lesson_model');
		$this->load->model('Transaction_model');
		$this->load->model('Enrollment_model');
		$this->load->model('User_model');
		$this->load->library('upload');
	}

	/**
	 * Admin Dashboard Overview
	 */
	public function index()
	{
		$totalCourses = $this->Course_model->countCourses();
		$totalStudents = $this->User_model->countUsers('student');
		$pendingTransactions = $this->Transaction_model->countPending();
		$totalEnrollments = $this->Enrollment_model->countTotalEnrollments();

		// Recent pending transactions needing review
		$recentPending = $this->Transaction_model->getAllTransactions('pending');

		$data = array(
			'title'               => 'Panel Pengelola - Dashboard',
			'totalCourses'        => $totalCourses,
			'totalStudents'       => $totalStudents,
			'pendingTransactions' => $pendingTransactions,
			'totalEnrollments'    => $totalEnrollments,
			'recentPending'       => $recentPending
		);

		$this->renderView('admin/dashboard', $data, 'admin');
	}

	/**
	 * List all courses
	 */
	public function courses()
	{
		$courses = $this->Course_model->getAll(null, null); // all statuses

		$data = array(
			'title'   => 'Kelola Kelas Bahasa Arab',
			'courses' => $courses
		);

		$this->renderView('admin/courses/index', $data, 'admin');
	}

	/**
	 * Create new course
	 */
	public function courseCreate()
	{
		$this->form_validation->set_rules('title', 'Judul Kelas', 'trim|required|min_length[3]|max_length[200]', array(
			'required' => 'Judul kelas wajib diisi.'
		));
		$this->form_validation->set_rules('type', 'Tipe Kelas', 'required|in_list[free,paid]');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[published,draft]');

		if ($this->input->post('type') === 'paid') {
			$this->form_validation->set_rules('price', 'Harga Kelas', 'required|numeric|greater_than[0]', array(
				'required'     => 'Harga wajib diisi untuk kelas berbayar.',
				'greater_than' => 'Harga kelas berbayar harus lebih besar dari 0.'
			));
		}

		if ($this->form_validation->run() === TRUE) {
			$courseData = array(
				'title'       => $this->input->post('title', TRUE),
				'description' => $this->input->post('description', TRUE),
				'type'        => $this->input->post('type', TRUE),
				'price'       => $this->input->post('type') === 'paid' ? (float)$this->input->post('price') : 0.00,
				'status'      => $this->input->post('status', TRUE),
			);

			// Handle thumbnail upload if provided
			if (!empty($_FILES['thumbnail']['name'])) {
				$uploadConfig = array(
					'upload_path'   => './uploads/courses/',
					'allowed_types' => 'jpg|jpeg|png|webp',
					'max_size'      => 2048,
					'encrypt_name'  => TRUE
				);
				$this->upload->initialize($uploadConfig);
				if ($this->upload->do_upload('thumbnail')) {
					$uploadData = $this->upload->data();
					$courseData['thumbnail'] = $uploadData['file_name'];
				}
			}

			$courseId = $this->Course_model->create($courseData);

			$this->session->set_flashdata('success', 'Kelas baru berhasil ditambahkan! Silakan tambahkan materi video untuk kelas ini.');
			redirect('admin/courses/' . $courseId . '/lessons');
			return;
		}

		$data = array(
			'title' => 'Tambah Kelas Baru'
		);

		$this->renderView('admin/courses/create', $data, 'admin');
	}

	/**
	 * Edit existing course
	 *
	 * @param int $id
	 */
	public function courseEdit($id)
	{
		$course = $this->Course_model->getById($id);
		if (!$course) {
			show_404();
			return;
		}

		$this->form_validation->set_rules('title', 'Judul Kelas', 'trim|required|min_length[3]|max_length[200]', array(
			'required' => 'Judul kelas wajib diisi.'
		));
		$this->form_validation->set_rules('type', 'Tipe Kelas', 'required|in_list[free,paid]');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[published,draft]');

		if ($this->input->post('type') === 'paid') {
			$this->form_validation->set_rules('price', 'Harga Kelas', 'required|numeric|greater_than[0]', array(
				'required'     => 'Harga wajib diisi untuk kelas berbayar.',
				'greater_than' => 'Harga kelas berbayar harus lebih besar dari 0.'
			));
		}

		if ($this->form_validation->run() === TRUE) {
			$courseData = array(
				'title'       => $this->input->post('title', TRUE),
				'description' => $this->input->post('description', TRUE),
				'type'        => $this->input->post('type', TRUE),
				'price'       => $this->input->post('type') === 'paid' ? (float)$this->input->post('price') : 0.00,
				'status'      => $this->input->post('status', TRUE),
			);

			// Handle thumbnail upload if provided
			if (!empty($_FILES['thumbnail']['name'])) {
				$uploadConfig = array(
					'upload_path'   => './uploads/courses/',
					'allowed_types' => 'jpg|jpeg|png|webp',
					'max_size'      => 2048,
					'encrypt_name'  => TRUE
				);
				$this->upload->initialize($uploadConfig);
				if ($this->upload->do_upload('thumbnail')) {
					$uploadData = $this->upload->data();
					$courseData['thumbnail'] = $uploadData['file_name'];
				}
			}

			$this->Course_model->update($id, $courseData);

			$this->session->set_flashdata('success', 'Data kelas berhasil diperbarui.');
			redirect('admin/courses');
			return;
		}

		$data = array(
			'title'  => 'Ubah Kelas: ' . $course->title,
			'course' => $course
		);

		$this->renderView('admin/courses/edit', $data, 'admin');
	}

	/**
	 * Delete a course
	 *
	 * @param int $id
	 */
	public function courseDelete($id)
	{
		$course = $this->Course_model->getById($id);
		if (!$course) {
			show_404();
			return;
		}

		$this->Course_model->delete($id);
		$this->session->set_flashdata('success', 'Kelas "' . html_escape($course->title) . '" beserta seluruh materinya berhasil dihapus.');
		redirect('admin/courses');
	}

	/**
	 * Manage lessons for a specific course
	 *
	 * @param int $courseId
	 */
	public function lessons($courseId)
	{
		$course = $this->Course_model->getById($courseId);
		if (!$course) {
			show_404();
			return;
		}

		$lessons = $this->Lesson_model->getByCourse($courseId);
		$nextOrderNum = $this->Lesson_model->getNextOrderNum($courseId);

		$data = array(
			'title'        => 'Kelola Video Materi: ' . $course->title,
			'course'       => $course,
			'lessons'      => $lessons,
			'nextOrderNum' => $nextOrderNum
		);

		$this->renderView('admin/lessons/index', $data, 'admin');
	}

	/**
	 * Create a new YouTube lesson in course
	 *
	 * @param int $courseId
	 */
	public function lessonCreate($courseId)
	{
		$course = $this->Course_model->getById($courseId);
		if (!$course) {
			show_404();
			return;
		}

		$this->form_validation->set_rules('title', 'Judul Materi', 'trim|required|min_length[3]|max_length[200]', array(
			'required' => 'Judul materi wajib diisi.'
		));
		$this->form_validation->set_rules('youtube_url', 'URL / Link YouTube', 'trim|required', array(
			'required' => 'URL video YouTube wajib diisi.'
		));
		$this->form_validation->set_rules('order_num', 'Urutan Materi', 'required|is_natural_no_zero', array(
			'required' => 'Nomor urut materi wajib diisi.'
		));

		if ($this->form_validation->run() === TRUE) {
			$youtubeUrl = $this->input->post('youtube_url', TRUE);
			$videoId = extract_youtube_id($youtubeUrl);

			if (!$videoId) {
				$this->session->set_flashdata('error', 'URL YouTube yang dimasukkan tidak valid. Harap masukkan link YouTube standar (misal: https://www.youtube.com/watch?v=...) atau Video ID 11 karakter.');
				redirect('admin/courses/' . $courseId . '/lessons');
				return;
			}

			$lessonData = array(
				'course_id'        => $courseId,
				'title'            => $this->input->post('title', TRUE),
				'youtube_url'      => $youtubeUrl,
				'youtube_video_id' => $videoId,
				'order_num'        => (int)$this->input->post('order_num'),
				'description'      => $this->input->post('description', TRUE)
			);

			$this->Lesson_model->create($lessonData);

			$this->session->set_flashdata('success', 'Video materi YouTube berhasil ditambahkan ke kelas.');
			redirect('admin/courses/' . $courseId . '/lessons');
			return;
		}

		$this->session->set_flashdata('error', validation_errors());
		redirect('admin/courses/' . $courseId . '/lessons');
	}

	/**
	 * Edit a lesson
	 *
	 * @param int $id
	 */
	public function lessonEdit($id)
	{
		$lesson = $this->Lesson_model->getById($id);
		if (!$lesson) {
			show_404();
			return;
		}

		$this->form_validation->set_rules('title', 'Judul Materi', 'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('youtube_url', 'URL / Link YouTube', 'trim|required');
		$this->form_validation->set_rules('order_num', 'Urutan Materi', 'required|is_natural_no_zero');

		if ($this->form_validation->run() === TRUE) {
			$youtubeUrl = $this->input->post('youtube_url', TRUE);
			$videoId = extract_youtube_id($youtubeUrl);

			if (!$videoId) {
				$this->session->set_flashdata('error', 'URL YouTube tidak valid.');
				redirect('admin/courses/' . $lesson->course_id . '/lessons');
				return;
			}

			$lessonData = array(
				'title'            => $this->input->post('title', TRUE),
				'youtube_url'      => $youtubeUrl,
				'youtube_video_id' => $videoId,
				'order_num'        => (int)$this->input->post('order_num'),
				'description'      => $this->input->post('description', TRUE)
			);

			$this->Lesson_model->update($id, $lessonData);

			$this->session->set_flashdata('success', 'Materi video berhasil diperbarui.');
			redirect('admin/courses/' . $lesson->course_id . '/lessons');
			return;
		}

		$this->session->set_flashdata('error', validation_errors());
		redirect('admin/courses/' . $lesson->course_id . '/lessons');
	}

	/**
	 * Delete a lesson
	 *
	 * @param int $id
	 */
	public function lessonDelete($id)
	{
		$lesson = $this->Lesson_model->getById($id);
		if (!$lesson) {
			show_404();
			return;
		}

		$courseId = $lesson->course_id;
		$this->Lesson_model->delete($id);

		$this->session->set_flashdata('success', 'Materi video berhasil dihapus.');
		redirect('admin/courses/' . $courseId . '/lessons');
	}

	/**
	 * Manage Transactions & Payment Verification
	 */
	public function transactions()
	{
		$statusFilter = $this->input->get('status', TRUE);
		if (!in_array($statusFilter, array('pending', 'approved', 'rejected'))) {
			$statusFilter = null;
		}

		$transactions = $this->Transaction_model->getAllTransactions($statusFilter);

		$data = array(
			'title'        => 'Verifikasi Transaksi Pembayaran',
			'transactions' => $transactions,
			'statusFilter' => $statusFilter
		);

		$this->renderView('admin/transactions/index', $data, 'admin');
	}

	/**
	 * Approve transaction and auto-activate course access
	 *
	 * @param int $id
	 */
	public function transactionApprove($id)
	{
		$transaction = $this->Transaction_model->getById($id);
		if (!$transaction) {
			show_404();
			return;
		}

		$success = $this->Transaction_model->approveTransaction($id);

		if ($success) {
			$this->session->set_flashdata('success', 'Pembayaran transaksi ' . html_escape($transaction->transaction_code) . ' disetujui! Akses kelas ' . html_escape($transaction->course_title) . ' untuk santri ' . html_escape($transaction->user_name) . ' telah otomatis aktif.');
		} else {
			$this->session->set_flashdata('error', 'Gagal memproses verifikasi transaksi.');
		}

		redirect('admin/transactions');
	}

	/**
	 * Reject transaction with optional notes
	 *
	 * @param int $id
	 */
	public function transactionReject($id)
	{
		$transaction = $this->Transaction_model->getById($id);
		if (!$transaction) {
			show_404();
			return;
		}

		$reason = $this->input->post('admin_notes', TRUE);
		$this->Transaction_model->rejectTransaction($id, $reason);

		$this->session->set_flashdata('success', 'Transaksi ' . html_escape($transaction->transaction_code) . ' telah ditolak.');
		redirect('admin/transactions');
	}

	/**
	 * View Students List and their enrollments
	 */
	public function students()
	{
		$courseFilter = $this->input->get('course_id', TRUE);
		$courses = $this->Course_model->getAll(null, null);

		if (!empty($courseFilter)) {
			$students = $this->Enrollment_model->getCourseStudents((int)$courseFilter);
			$selectedCourse = $this->Course_model->getById((int)$courseFilter);
		} else {
			// All students with total enrolled courses
			$this->db->select('users.id, users.name, users.email, users.created_at, COUNT(DISTINCT enrollments.course_id) AS total_enrolled');
			$this->db->from('users');
			$this->db->join('enrollments', 'enrollments.user_id = users.id AND enrollments.status = "active"', 'left');
			$this->db->where('users.role', 'student');
			$this->db->group_by('users.id');
			$this->db->order_by('users.id', 'DESC');
			$students = $this->db->get()->result();
			$selectedCourse = null;
		}

		$data = array(
			'title'          => 'Daftar Peserta & Santri',
			'students'       => $students,
			'courses'        => $courses,
			'selectedCourse' => $selectedCourse
		);

		$this->renderView('admin/students/index', $data, 'admin');
	}
}
