<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller for LMS Rumah Bahasa Arab
 */
class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	/**
	 * Login page and form processing
	 */
	public function login()
	{
		$this->requireGuest();

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array(
			'required'    => 'Alamat email wajib diisi.',
			'valid_email' => 'Format email tidak valid.'
		));
		$this->form_validation->set_rules('password', 'Kata Sandi', 'required', array(
			'required'    => 'Kata sandi wajib diisi.'
		));

		if ($this->form_validation->run() === TRUE) {
			$email = $this->input->post('email', TRUE);
			$password = $this->input->post('password');

			// Simple rate limiting: max 5 failed attempts per 5 minutes
			$rateLimitKey = 'login_' . $email;
			if (!$this->checkRateLimit($rateLimitKey, 5, 300)) {
				$this->session->set_flashdata('error', 'Terlalu banyak percobaan gagal. Silakan tunggu 5 menit sebelum mencoba kembali.');
				redirect('auth/login');
				return;
			}

			$user = $this->User_model->verifyCredentials($email, $password);

			if ($user) {
				// Clear rate limit on success
				$this->clearRateLimit($rateLimitKey);

				// Set user session
				$sessionData = array(
					'user_id' => $user->id,
					'name'    => $user->name,
					'email'   => $user->email,
					'role'    => $user->role
				);
				$this->session->set_userdata($sessionData);

				$this->session->set_flashdata('success', 'Selamat datang kembali, ' . html_escape($user->name) . '!');

				// Handle return URL if any
				$returnUrl = $this->session->userdata('return_url');
				if ($returnUrl) {
					$this->session->unset_userdata('return_url');
					redirect($returnUrl);
					return;
				}

				if ($user->role === 'admin') {
					redirect('admin');
				} else {
					redirect('my-courses');
				}
				return;
			} else {
				// Record failed attempt
				$this->recordRateLimitAttempt($rateLimitKey);
				$this->session->set_flashdata('error', 'Email atau kata sandi yang Anda masukkan salah.');
				redirect('auth/login');
				return;
			}
		}

		$data = array(
			'title' => 'Masuk ke Akun'
		);
		$this->renderView('auth/login', $data, 'public');
	}

	/**
	 * Register page and form processing
	 */
	public function register()
	{
		$this->requireGuest();

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]', array(
			'required'   => 'Nama lengkap wajib diisi.',
			'min_length' => 'Nama minimal terdiri dari 3 karakter.'
		));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array(
			'required'    => 'Alamat email wajib diisi.',
			'valid_email' => 'Format email tidak valid.',
			'is_unique'   => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain atau masuk.'
		));
		$this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[6]', array(
			'required'   => 'Kata sandi wajib diisi.',
			'min_length' => 'Kata sandi minimal 6 karakter.'
		));
		$this->form_validation->set_rules('password_confirm', 'Konfirmasi Kata Sandi', 'required|matches[password]', array(
			'required' => 'Konfirmasi kata sandi wajib diisi.',
			'matches'  => 'Konfirmasi kata sandi tidak cocok dengan kata sandi.'
		));

		if ($this->form_validation->run() === TRUE) {
			$userData = array(
				'name'     => $this->input->post('name', TRUE),
				'email'    => $this->input->post('email', TRUE),
				'password' => $this->input->post('password'),
				'role'     => 'student'
			);

			$userId = $this->User_model->createUser($userData);

			if ($userId) {
				// Auto login new student
				$sessionData = array(
					'user_id' => $userId,
					'name'    => $userData['name'],
					'email'   => $userData['email'],
					'role'    => 'student'
				);
				$this->session->set_userdata($sessionData);

				$this->session->set_flashdata('success', 'Pendaftaran berhasil! Selamat datang di Rumah Bahasa Arab.');
				
				$returnUrl = $this->session->userdata('return_url');
				if ($returnUrl) {
					$this->session->unset_userdata('return_url');
					redirect($returnUrl);
					return;
				}

				redirect('courses');
				return;
			} else {
				$this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi.');
				redirect('auth/register');
				return;
			}
		}

		$data = array(
			'title' => 'Pendaftaran Siswa Baru'
		);
		$this->renderView('auth/register', $data, 'public');
	}

	/**
	 * Destroy session and logout
	 */
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}
