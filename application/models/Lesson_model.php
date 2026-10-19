<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Lesson Model for LMS Rumah Bahasa Arab
 */
class Lesson_model extends CI_Model {

	protected $table = 'lessons';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get all lessons for a given course
	 *
	 * @param int $courseId
	 * @return array
	 */
	public function getByCourse($courseId)
	{
		$this->db->where('course_id', (int)$courseId);
		$this->db->order_by('order_num', 'ASC');
		$this->db->order_by('id', 'ASC');
		return $this->db->get($this->table)->result();
	}

	/**
	 * Get lesson by ID
	 *
	 * @param int $id
	 * @return object|null
	 */
	public function getById($id)
	{
		return $this->db->get_where($this->table, array('id' => (int)$id))->row();
	}

	/**
	 * Create a new lesson
	 *
	 * @param array $data
	 * @return int Inserted ID
	 */
	public function create($data)
	{
		$videoId = extract_youtube_id($data['youtube_url']);
		if (!$videoId) {
			$videoId = isset($data['youtube_video_id']) ? $data['youtube_video_id'] : '';
		}

		// Calculate order number if not supplied
		$orderNum = isset($data['order_num']) && (int)$data['order_num'] > 0 
			? (int)$data['order_num'] 
			: $this->getNextOrderNum($data['course_id']);

		$insertData = array(
			'course_id'        => (int)$data['course_id'],
			'title'            => trim($data['title']),
			'youtube_url'      => trim($data['youtube_url']),
			'youtube_video_id' => $videoId,
			'order_num'        => $orderNum,
			'description'      => isset($data['description']) ? trim($data['description']) : null,
			'created_at'       => date('Y-m-d H:i:s')
		);

		$this->db->insert($this->table, $insertData);
		return $this->db->insert_id();
	}

	/**
	 * Update an existing lesson
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

		if (isset($data['youtube_url'])) {
			$updateData['youtube_url'] = trim($data['youtube_url']);
			$videoId = extract_youtube_id($data['youtube_url']);
			if ($videoId) {
				$updateData['youtube_video_id'] = $videoId;
			}
		}

		if (isset($data['order_num'])) {
			$updateData['order_num'] = (int)$data['order_num'];
		}

		if (isset($data['description'])) {
			$updateData['description'] = trim($data['description']);
		}

		$updateData['updated_at'] = date('Y-m-d H:i:s');

		$this->db->where('id', (int)$id);
		return $this->db->update($this->table, $updateData);
	}

	/**
	 * Delete a lesson
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
	 * Get the next order number for a course
	 *
	 * @param int $courseId
	 * @return int
	 */
	public function getNextOrderNum($courseId)
	{
		$this->db->select_max('order_num');
		$this->db->where('course_id', (int)$courseId);
		$row = $this->db->get($this->table)->row();
		return ($row && $row->order_num) ? ((int)$row->order_num + 1) : 1;
	}

	/**
	 * Get the first lesson of a course
	 *
	 * @param int $courseId
	 * @return object|null
	 */
	public function getFirstLesson($courseId)
	{
		$this->db->where('course_id', (int)$courseId);
		$this->db->order_by('order_num', 'ASC');
		$this->db->order_by('id', 'ASC');
		$this->db->limit(1);
		return $this->db->get($this->table)->row();
	}

	/**
	 * Get neighboring lessons (prev and next)
	 *
	 * @param int $courseId
	 * @param int $orderNum
	 * @return array ('prev' => object|null, 'next' => object|null)
	 */
	public function getAdjacentLessons($courseId, $orderNum)
	{
		// Previous lesson
		$this->db->where('course_id', (int)$courseId);
		$this->db->where('order_num <', (int)$orderNum);
		$this->db->order_by('order_num', 'DESC');
		$this->db->limit(1);
		$prev = $this->db->get($this->table)->row();

		// Next lesson
		$this->db->where('course_id', (int)$courseId);
		$this->db->where('order_num >', (int)$orderNum);
		$this->db->order_by('order_num', 'ASC');
		$this->db->limit(1);
		$next = $this->db->get($this->table)->row();

		return array('prev' => $prev, 'next' => $next);
	}
}
