<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * YouTube Helper for Rumah Bahasa Arab LMS
 */

if (!function_exists('extract_youtube_id')) {
	/**
	 * Extract YouTube 11-char Video ID from various URL formats
	 *
	 * @param string $url
	 * @return string|null
	 */
	function extract_youtube_id($url)
	{
		$url = trim((string)$url);
		if (empty($url)) {
			return null;
		}

		// If user already passed a direct 11-character video ID
		if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
			return $url;
		}

		// Match standard watch, embed, short links, mobile links
		$pattern = '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([\w-]{11})/';
		if (preg_match($pattern, $url, $matches)) {
			return $matches[1];
		}

		return null;
	}
}

if (!function_exists('youtube_embed_url')) {
	/**
	 * Generate standard YouTube embed iframe URL
	 *
	 * @param string $videoId
	 * @return string
	 */
	function youtube_embed_url($videoId)
	{
		return 'https://www.youtube.com/embed/' . rawurlencode($videoId) . '?rel=0&modestbranding=1&enablejsapi=1';
	}
}

if (!function_exists('youtube_thumbnail_url')) {
	/**
	 * Generate YouTube thumbnail image URL
	 *
	 * @param string $videoId
	 * @param string $quality (default, hqdefault, mqdefault, sddefault, maxresdefault)
	 * @return string
	 */
	function youtube_thumbnail_url($videoId, $quality = 'hqdefault')
	{
		return 'https://img.youtube.com/vi/' . rawurlencode($videoId) . '/' . $quality . '.jpg';
	}
}

if (!function_exists('format_rupiah')) {
	/**
	 * Helper to format IDR currency
	 *
	 * @param float|int $amount
	 * @return string
	 */
	function format_rupiah($amount)
	{
		if ((float)$amount <= 0) {
			return 'Gratis';
		}
		return 'Rp ' . number_format((float)$amount, 0, ',', '.');
	}
}
