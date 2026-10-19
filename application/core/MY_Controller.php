<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Application Controller
 * Handles common authentication, access control, rate limiting, and layout rendering.
 */
class MY_Controller extends CI_Controller {

	/**
	 * @var array|null
	 */
	protected $currentUser = null;

	public function __construct()
	{
		parent::__construct();

		// Populate currentUser from session if authenticated
		if ($this->session->userdata('user_id')) {
			$this->currentUser = array(
				'id'    => (int)$this->session->userdata('user_id'),
				'name'  => (string)$this->session->userdata('name'),
				'email' => (string)$this->session->userdata('email'),
				'role'  => (string)$this->session->userdata('role')
			);
		}
	}

	/**
	 * Check whether visitor is logged in
	 *
	 * @return bool
	 */
	protected function isLoggedIn()
	{
		return !empty($this->currentUser);
	}

	/**
	 * Enforce login requirement
	 *
	 * @param string|null $returnUrl
	 * @return void
	 */
	protected function requireLogin($returnUrl = null)
	{
		if (!$this->isLoggedIn()) {
			if ($returnUrl) {
				$this->session->set_userdata('return_url', $returnUrl);
			}
			$this->session->set_flashdata('error', 'Silakan masuk ke akun Anda terlebih dahulu.');
			redirect('auth/login');
			exit;
		}
	}

	/**
	 * Enforce Admin role requirement
	 *
	 * @return void
	 */
	protected function requireAdmin()
	{
		$this->requireLogin();

		if ($this->currentUser['role'] !== 'admin') {
			$this->session->set_flashdata('error', 'Akses ditolak. Anda tidak memiliki izin mengakses area pengelola.');
			redirect('/');
			exit;
		}
	}

	/**
	 * Enforce Guest requirement (e.g. for login/register pages)
	 *
	 * @return void
	 */
	protected function requireGuest()
	{
		if ($this->isLoggedIn()) {
			if ($this->currentUser['role'] === 'admin') {
				redirect('admin');
			} else {
				redirect('my-courses');
			}
			exit;
		}
	}

	/**
	 * Simple session-based rate limiter for sensitive actions (e.g. login)
	 *
	 * @param string $actionKey
	 * @param int $maxAttempts
	 * @param int $lockoutSeconds
	 * @return bool True if allowed, False if throttled
	 */
	protected function checkRateLimit($actionKey, $maxAttempts = 5, $lockoutSeconds = 300)
	{
		$sessionKey = 'throttle_' . md5($actionKey);
		$throttleData = $this->session->userdata($sessionKey);

		if ($throttleData && is_array($throttleData)) {
			$attempts = $throttleData['attempts'];
			$firstAttemptTime = $throttleData['time'];

			// Check if lockout period has expired
			if ((time() - $firstAttemptTime) > $lockoutSeconds) {
				// Reset window
				$this->session->unset_userdata($sessionKey);
				return true;
			}

			if ($attempts >= $maxAttempts) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Record an attempt for rate limiting
	 *
	 * @param string $actionKey
	 * @return void
	 */
	protected function recordRateLimitAttempt($actionKey)
	{
		$sessionKey = 'throttle_' . md5($actionKey);
		$throttleData = $this->session->userdata($sessionKey);

		if ($throttleData && is_array($throttleData)) {
			$throttleData['attempts']++;
		} else {
			$throttleData = array(
				'attempts' => 1,
				'time' => time()
			);
		}

		$this->session->set_userdata($sessionKey, $throttleData);
	}

	/**
	 * Clear rate limit for an action
	 *
	 * @param string $actionKey
	 * @return void
	 */
	protected function clearRateLimit($actionKey)
	{
		$sessionKey = 'throttle_' . md5($actionKey);
		$this->session->unset_userdata($sessionKey);
	}

	/**
	 * Modular layout rendering helper
	 *
	 * @param string $view
	 * @param array $data
	 * @param string $layoutType 'public', 'admin', 'classroom', or 'blank'
	 * @return void
	 */
	protected function renderView($view, $data = array(), $layoutType = 'public')
	{
		$data['currentUser'] = $this->currentUser;
		$data['title'] = isset($data['title']) ? $data['title'] : 'Rumah Bahasa Arab LMS';

		if ($layoutType === 'public') {
			$this->load->view('layouts/header', $data);
			$this->load->view('layouts/navbar', $data);
			$this->load->view('layouts/alerts', $data);
			$this->load->view($view, $data);
			$this->load->view('layouts/footer', $data);
		} elseif ($layoutType === 'admin') {
			$this->load->view('layouts/admin_header', $data);
			$this->load->view('layouts/alerts', $data);
			$this->load->view($view, $data);
			$this->load->view('layouts/footer', $data);
		} elseif ($layoutType === 'classroom') {
			$this->load->view('layouts/header', $data);
			$this->load->view($view, $data);
			$this->load->view('layouts/footer', $data);
		} else {
			// Blank / raw layout
			$this->load->view($view, $data);
		}
	}
}
