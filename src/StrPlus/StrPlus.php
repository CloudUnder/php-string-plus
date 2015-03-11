<?php

namespace StrPlus;

class StrPlus {

	/**
	 * Remove invalid UTF-8 bytes.
	 *
	 * @param string
	 * @return string
	 */
	public static function sanitize_utf8($string) {
		echo "\nBEFORE: " . bin2hex($string);
		$string = iconv('UTF-8', 'UTF-8//IGNORE', $string);
		echo "\nAFTER:  " . bin2hex($string) . "\n";
		return $string;
	}

	/**
	 * Replaces non-printable control characters.
	 * Note: Invalid UTF-8 characters will be removed, not replaced!
	 *
	 * @param string
	 * @return string
	 */
	public static function replace_control_chars($replace, $string) {
		$string = self::sanitize_utf8($string);
		return preg_replace('/[\x{0000}-\x{001f}\x{007f}-\x{009f}]/u', $replace, $string);
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

	/**
	 * Limit string to a number of characters and preserve words where possible.
	 *
	 * @param  string  $value
	 * @param  int     $limit
	 * @param  string  $end
	 * @param  boolean $preserve_words
	 * @return string
	 */
	public static function limit($value, $limit, $end = '…', $preserve_words = true) {
		if (mb_strlen($value) <= $limit) return $value;
		if ($preserve_words) {
			$cut_area = mb_substr($value, $limit - 1, 2, 'UTF-8');
			if (strpos($cut_area, ' ') === false) {
				$value = mb_substr($value, 0, $limit, 'UTF-8');
				$space_pos = strrpos($value, ' ');
				if ($space_pos !== false) {
					return rtrim(mb_substr($value, 0, $space_pos, 'UTF-8')) . $end;
				}
			}
		}
		return rtrim(mb_substr($value, 0, $limit, 'UTF-8')).$end;
	}

}