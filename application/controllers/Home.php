<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller for LMS Rumah Bahasa Arab
 */
class Home extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Course_model');
	}

	/**
	 * Landing page & featured courses
	 */
	public function index()
	{
		$filterType = $this->input->get('type', TRUE);
		if (!in_array($filterType, array('free', 'paid'))) {
			$filterType = null;
		}

		$courses = $this->Course_model->getAll($filterType, 'published');

		$data = array(
			'title'       => 'Rumah Bahasa Arab - Platform Belajar Bahasa Arab Terstruktur',
			'courses'     => $courses,
			'currentType' => $filterType
		);

		$this->renderView('home/index', $data, 'public');
	}
}
