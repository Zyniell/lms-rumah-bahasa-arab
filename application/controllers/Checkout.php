<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Checkout Controller for LMS Rumah Bahasa Arab
 */
class Checkout extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Course_model');
		$this->load->model('Transaction_model');
		$this->load->model('Enrollment_model');
		$this->load->library('upload');
	}

	/**
	 * Checkout order summary and payment instructions
	 *
	 * @param int $courseId
	 */
	public function index($courseId)
	{
		$this->requireLogin(site_url('checkout/' . $courseId));

		$course = $this->Course_model->getById($courseId);
		if (!$course || $course->status !== 'published') {
			show_404();
			return;
		}

		if ($course->type !== 'paid') {
			$this->session->set_flashdata('info', 'Kelas ini gratis, Anda dapat langsung mengikutinya.');
			redirect('course/enroll-free/' . $course->id);
			return;
		}

		$userId = $this->currentUser['id'];

		// If student is already enrolled, forward to classroom
		if ($this->Enrollment_model->isEnrolled($userId, $course->id)) {
			$this->session->set_flashdata('info', 'Anda sudah memiliki akses aktif ke kelas ini.');
			redirect('learn/' . $course->id);
			return;
		}

		// Create or retrieve active pending transaction
		$transaction = $this->Transaction_model->createTransaction($userId, $course->id, $course->price);

		$data = array(
			'title'       => 'Checkout & Pembayaran Kelas',
			'course'      => $course,
			'transaction' => $transaction
		);

		$this->renderView('checkout/index', $data, 'public');
	}

	/**
	 * Process payment proof upload
	 *
	 * @param string $transactionCode
	 */
	public function submitPayment($transactionCode)
	{
		$this->requireLogin();

		$transaction = $this->Transaction_model->getByCode($transactionCode);
		if (!$transaction || $transaction->user_id != $this->currentUser['id']) {
			show_404();
			return;
		}

		// Configure file upload
		$uploadConfig = array(
			'upload_path'   => './uploads/payments/',
			'allowed_types' => 'jpg|jpeg|png|webp|pdf',
			'max_size'      => 2048, // 2MB
			'encrypt_name'  => TRUE
		);

		$this->upload->initialize($uploadConfig);

		if (!$this->upload->do_upload('payment_proof')) {
			$this->session->set_flashdata('error', 'Gagal mengunggah bukti: ' . $this->upload->display_errors('', ''));
			redirect('checkout/' . $transaction->course_id);
			return;
		}

		$uploadData = $this->upload->data();
		$fileName = $uploadData['file_name'];
		$notes = $this->input->post('payment_notes', TRUE);

		$this->Transaction_model->updatePaymentProof($transactionCode, $fileName, $notes);

		$this->session->set_flashdata('success', 'Bukti pembayaran berhasil diunggah! Pengelola akan segera memverifikasi pesanan Anda untuk membuka akses kelas.');
		redirect('my-transactions');
	}
}
