<?php

namespace StrPlus;

class StrPlus {

	/**
	 * Replaces non-printable control characters.
	 *
	 * @param string
	 * @return string
	 */
	public static function replace_control_chars($replace, $string) {
		return preg_replace('/[\x00-\x1F\x80-\x9F]/u', $replace, $string);
	}

	/**
	 * Converts a multi-line text to a text without line breaks or other
	 * non-printable characters. Multi-spaces are reduces to one space.
	 *
	 * @param string
	 * @return string
	 */
	public static function single_line($string) {
		$string = self::replace_control_chars(' ', $string);
		while (strpos($string, '  ') !== false) {
			$string = str_replace('  ', ' ', $string);
		}
		return trim($string);
	}

	/**
	 * Converts a HTML formatted block to a plain text one-line string
	 * without non-printable characters.
	 *
	 * @param string
	 * @return string
	 */
	public static function html_to_single_line_text($string) {
		$string = str_replace('>', '> ', $string); // Create space between tags
		$string = strip_tags($string);
		$string = html_entity_decode($string);
		$string = str_replace("\xc2\xa0", ' ', $string); // Replce UTF-8 version of &nbsp; (C2 A0) with normal space
		return self::single_line($string);
	}

	/**
	 * Converts a multi-line plain text string to a multi-line HTML string
	 * where line breaks become <br> tags.
	 *
	 * @param string
	 * @return string
	 */
	public static function multi_line_text_to_html($string) {
		return nl2br(htmlspecialchars($string), false);
	}

}