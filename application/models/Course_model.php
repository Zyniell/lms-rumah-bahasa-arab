<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Course Model for LMS Rumah Bahasa Arab
 */
class Course_model extends CI_Model {

	protected $table = 'courses';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get courses with optional type and status filter
	 *
	 * @param string|null $type ('free', 'paid', or null)
	 * @param string|null $status ('published', 'draft', or null for all)
	 * @return array
	 */
	public function getAll($type = null, $status = 'published')
	{
		$this->db->select('courses.*, COUNT(DISTINCT lessons.id) AS total_lessons, COUNT(DISTINCT enrollments.id) AS total_students');
		$this->db->from($this->table);
		$this->db->join('lessons', 'lessons.course_id = courses.id', 'left');
		$this->db->join('enrollments', 'enrollments.course_id = courses.id AND enrollments.status = "active"', 'left');

		if ($type !== null && in_array($type, array('free', 'paid'))) {
			$this->db->where('courses.type', $type);
		}

		if ($status !== null) {
			$this->db->where('courses.status', $status);
		}

		$this->db->group_by('courses.id');
		$this->db->order_by('courses.id', 'DESC');
		return $this->db->get()->result();
	}

	/**
	 * Get course by ID with lesson and student counts
	 *
	 * @param int $id
	 * @return object|null
	 */
	public function getById($id)
	{
		$this->db->select('courses.*, COUNT(DISTINCT lessons.id) AS total_lessons, COUNT(DISTINCT enrollments.id) AS total_students');
		$this->db->from($this->table);
		$this->db->join('lessons', 'lessons.course_id = courses.id', 'left');
		$this->db->join('enrollments', 'enrollments.course_id = courses.id AND enrollments.status = "active"', 'left');
		$this->db->where('courses.id', (int)$id);
		$this->db->group_by('courses.id');
		return $this->db->get()->row();
	}

	/**
	 * Get course by URL slug
	 *
	 * @param string $slug
	 * @param string|null $status
	 * @return object|null
	 */
	public function getBySlug($slug, $status = 'published')
	{
		$this->db->select('courses.*, COUNT(DISTINCT lessons.id) AS total_lessons, COUNT(DISTINCT enrollments.id) AS total_students');
		$this->db->from($this->table);
		$this->db->join('lessons', 'lessons.course_id = courses.id', 'left');
		$this->db->join('enrollments', 'enrollments.course_id = courses.id AND enrollments.status = "active"', 'left');
		$this->db->where('courses.slug', trim($slug));

		if ($status !== null) {
			$this->db->where('courses.status', $status);
		}

		$this->db->group_by('courses.id');
		return $this->db->get()->row();
	}

	/**
	 * Create new course
	 *
	 * @param array $data
	 * @return int Inserted ID
	 */
	public function create($data)
	{
		$slug = isset($data['slug']) && !empty($data['slug']) 
			? $this->generateSlug($data['slug']) 
			: $this->generateSlug($data['title']);

		$insertData = array(
			'title'       => trim($data['title']),
			'slug'        => $slug,
			'description' => isset($data['description']) ? trim($data['description']) : null,
			'thumbnail'   => isset($data['thumbnail']) ? trim($data['thumbnail']) : null,
			'type'        => $data['type'] === 'paid' ? 'paid' : 'free',
			'price'       => $data['type'] === 'paid' ? (float)$data['price'] : 0.00,
			'status'      => isset($data['status']) && $data['status'] === 'draft' ? 'draft' : 'published',
			'created_at'  => date('Y-m-d H:i:s')
		);

		$this->db->insert($this->table, $insertData);
		return $this->db->insert_id();
	}

	/**
	 * Update existing course
	 *
	 * @param int $id
	 * @param array $data
	 * @return bool
	 */
	public function update($id, $data)
	{
		$updateData = array();

		if (isset($data['title'])) {
			$updateData['title'] = trim($data['title']);
		}

		if (isset($data['slug'])) {
			$updateData['slug'] = $this->generateSlug($data['slug'], $id);
		} elseif (isset($data['title'])) {
			$updateData['slug'] = $this->generateSlug($data['title'], $id);
		}

		if (isset($data['description'])) {
			$updateData['description'] = trim($data['description']);
		}

		if (isset($data['thumbnail']) && !empty($data['thumbnail'])) {
			$updateData['thumbnail'] = trim($data['thumbnail']);
		}

		if (isset($data['type'])) {
			$updateData['type'] = $data['type'] === 'paid' ? 'paid' : 'free';
			$updateData['price'] = $data['type'] === 'paid' && isset($data['price']) ? (float)$data['price'] : 0.00;
		}

		if (isset($data['status'])) {
			$updateData['status'] = $data['status'] === 'draft' ? 'draft' : 'published';
		}

		$updateData['updated_at'] = date('Y-m-d H:i:s');

		$this->db->where('id', (int)$id);
		return $this->db->update($this->table, $updateData);
	}

	/**
	 * Delete a course
	 *
	 * @param int $id
	 * @return bool
	 */
	public function delete($id)
	{
		$this->db->where('id', (int)$id);
		return $this->db->delete($this->table);
	}

	/**
	 * Generate unique URL slug
	 *
	 * @param string $string
	 * @param int|null $excludeId
	 * @return string
	 */
	public function generateSlug($string, $excludeId = null)
	{
		$slug = url_title($string, 'dash', TRUE);
		if (empty($slug)) {
			$slug = 'kelas-' . time();
		}

		$originalSlug = $slug;
		$counter = 1;

		while ($this->isSlugExists($slug, $excludeId)) {
			$slug = $originalSlug . '-' . $counter;
			$counter++;
		}

		return $slug;
	}

	/**
	 * Check if slug exists in DB
	 *
	 * @param string $slug
	 * @param int|null $excludeId
	 * @return bool
	 */
	protected function isSlugExists($slug, $excludeId = null)
	{
		$this->db->where('slug', $slug);
		if ($excludeId !== null) {
			$this->db->where('id !=', (int)$excludeId);
		}
		return $this->db->count_all_results($this->table) > 0;
	}

	/**
	 * Count total courses
	 *
	 * @param string|null $status
	 * @return int
	 */
	public function countCourses($status = null)
	{
		if ($status !== null) {
			$this->db->where('status', $status);
		}
		return $this->db->count_all_results($this->table);
	}
}
