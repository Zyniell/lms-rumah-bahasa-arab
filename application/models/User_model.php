<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model for LMS Rumah Bahasa Arab
 */
class User_model extends CI_Model {

	protected $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get user by primary ID
	 *
	 * @param int $id
	 * @return object|null
	 */
	public function getById($id)
	{
		return $this->db->get_where($this->table, array('id' => (int)$id))->row();
	}

	/**
	 * Get user by email address
	 *
	 * @param string $email
	 * @return object|null
	 */
	public function getByEmail($email)
	{
		return $this->db->get_where($this->table, array('email' => strtolower(trim($email))))->row();
	}

	/**
	 * Create a new user record
	 *
	 * @param array $data ('name', 'email', 'password', 'role')
	 * @return int Inserted ID
	 */
	public function createUser($data)
	{
		$insertData = array(
			'name'       => trim($data['name']),
			'email'      => strtolower(trim($data['email'])),
			'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
			'role'       => isset($data['role']) ? $data['role'] : 'student',
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->db->insert($this->table, $insertData);
		return $this->db->insert_id();
	}

	/**
	 * Verify login credentials
	 *
	 * @param string $email
	 * @param string $password
	 * @return object|false User object if valid, false otherwise
	 */
	public function verifyCredentials($email, $password)
	{
		$user = $this->getByEmail($email);
		if (!$user) {
			return false;
		}

		if (password_verify($password, $user->password)) {
			return $user;
		}

		return false;
	}

	/**
	 * Count total users by role
	 *
	 * @param string|null $role
	 * @return int
	 */
	public function countUsers($role = null)
	{
		if ($role !== null) {
			$this->db->where('role', $role);
		}
		return $this->db->count_all_results($this->table);
	}
}
