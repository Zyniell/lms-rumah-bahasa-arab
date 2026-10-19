<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Student Controller for LMS Rumah Bahasa Arab
 */
class Student extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireLogin();
		$this->load->model('Enrollment_model');
		$this->load->model('Transaction_model');
	}

	/**
	 * Student Dashboard: My enrolled courses
	 */
	public function myCourses()
	{
		$userId = $this->currentUser['id'];
		$courses = $this->Enrollment_model->getUserEnrolledCourses($userId);

		$data = array(
			'title'   => 'Kelas Saya',
			'courses' => $courses
		);

		$this->renderView('student/my_courses', $data, 'public');
	}

	/**
	 * Student: Transaction history and payment status
	 */
	public function transactions()
	{
		$userId = $this->currentUser['id'];
		$transactions = $this->Transaction_model->getUserTransactions($userId);

		$data = array(
			'title'        => 'Riwayat Transaksi',
			'transactions' => $transactions
		);

		$this->renderView('student/transactions', $data, 'public');
	}
}
