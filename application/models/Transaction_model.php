<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Transaction Model for LMS Rumah Bahasa Arab
 */
class Transaction_model extends CI_Model {

	protected $table = 'transactions';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Enrollment_model');
	}

	/**
	 * Create a new pending transaction for a paid course
	 *
	 * @param int $userId
	 * @param int $courseId
	 * @param float $amount
	 * @return object The created transaction record
	 */
	public function createTransaction($userId, $courseId, $amount)
	{
		// Check if user already has a pending transaction for this course
		$this->db->where('user_id', (int)$userId);
		$this->db->where('course_id', (int)$courseId);
		$this->db->where('status', 'pending');
		$existing = $this->db->get($this->table)->row();

		if ($existing) {
			return $existing;
		}

		// Generate unique transaction code: TRX-YYYYMMDD-RANDOM
		$transactionCode = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

		$data = array(
			'transaction_code' => $transactionCode,
			'user_id'          => (int)$userId,
			'course_id'        => (int)$courseId,
			'amount'           => (float)$amount,
			'status'           => 'pending',
			'created_at'       => date('Y-m-d H:i:s')
		);

		$this->db->insert($this->table, $data);
		$insertId = $this->db->insert_id();

		return $this->getById($insertId);
	}

	/**
	 * Get transaction by transaction code
	 *
	 * @param string $code
	 * @return object|null
	 */
	public function getByCode($code)
	{
		$this->db->select('transactions.*, users.name AS user_name, users.email AS user_email, courses.title AS course_title, courses.slug AS course_slug, courses.thumbnail AS course_thumbnail');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = transactions.user_id');
		$this->db->join('courses', 'courses.id = transactions.course_id');
		$this->db->where('transactions.transaction_code', trim($code));
		return $this->db->get()->row();
	}

	/**
	 * Get transaction by primary ID
	 *
	 * @param int $id
	 * @return object|null
	 */
	public function getById($id)
	{
		$this->db->select('transactions.*, users.name AS user_name, users.email AS user_email, courses.title AS course_title, courses.slug AS course_slug, courses.thumbnail AS course_thumbnail');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = transactions.user_id');
		$this->db->join('courses', 'courses.id = transactions.course_id');
		$this->db->where('transactions.id', (int)$id);
		return $this->db->get()->row();
	}

	/**
	 * Get user transactions
	 *
	 * @param int $userId
	 * @return array
	 */
	public function getUserTransactions($userId)
	{
		$this->db->select('transactions.*, courses.title AS course_title, courses.slug AS course_slug, courses.thumbnail AS course_thumbnail');
		$this->db->from($this->table);
		$this->db->join('courses', 'courses.id = transactions.course_id');
		$this->db->where('transactions.user_id', (int)$userId);
		$this->db->order_by('transactions.id', 'DESC');
		return $this->db->get()->result();
	}

	/**
	 * Get all transactions (for Admin) with optional status filter
	 *
	 * @param string|null $status ('pending', 'approved', 'rejected')
	 * @return array
	 */
	public function getAllTransactions($status = null)
	{
		$this->db->select('transactions.*, users.name AS user_name, users.email AS user_email, courses.title AS course_title');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = transactions.user_id');
		$this->db->join('courses', 'courses.id = transactions.course_id');

		if ($status !== null && in_array($status, array('pending', 'approved', 'rejected'))) {
			$this->db->where('transactions.status', $status);
		}

		$this->db->order_by('transactions.id', 'DESC');
		return $this->db->get()->result();
	}

	/**
	 * Update payment proof and buyer notes
	 *
	 * @param string $code
	 * @param string $proofFileName
	 * @param string|null $notes
	 * @return bool
	 */
	public function updatePaymentProof($code, $proofFileName, $notes = null)
	{
		$updateData = array(
			'payment_proof' => $proofFileName,
			'payment_notes' => !empty($notes) ? trim($notes) : null,
			'status'        => 'pending',
			'updated_at'    => date('Y-m-d H:i:s')
		);

		$this->db->where('transaction_code', trim($code));
		return $this->db->update($this->table, $updateData);
	}

	/**
	 * Approve a transaction and automatically activate course enrollment for student
	 *
	 * @param int $id
	 * @return bool
	 */
	public function approveTransaction($id)
	{
		$trx = $this->getById($id);
		if (!$trx) {
			return false;
		}

		$updateData = array(
			'status'      => 'approved',
			'approved_at' => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		);

		$this->db->where('id', (int)$id);
		$success = $this->db->update($this->table, $updateData);

		if ($success) {
			// Activate enrollment immediately
			$this->Enrollment_model->enroll($trx->user_id, $trx->course_id);
		}

		return $success;
	}

	/**
	 * Reject a transaction with optional admin reason
	 *
	 * @param int $id
	 * @param string|null $adminNotes
	 * @return bool
	 */
	public function rejectTransaction($id, $adminNotes = null)
	{
		$updateData = array(
			'status'      => 'rejected',
			'admin_notes' => !empty($adminNotes) ? trim($adminNotes) : null,
			'updated_at'  => date('Y-m-d H:i:s')
		);

		$this->db->where('id', (int)$id);
		return $this->db->update($this->table, $updateData);
	}

	/**
	 * Count pending transactions (for admin dashboard badge)
	 *
	 * @return int
	 */
	public function countPending()
	{
		$this->db->where('status', 'pending');
		return $this->db->count_all_results($this->table);
	}
}
