<?php

namespace StrPlus;

class StrPlus {

	/**
	 * Clear invalid UTF-8 strings.
	 * The initial idea was to only remove invalid UTF-8 sequences.
	 * My best shot so far was:
	 *   iconv('UTF-8', 'UTF-8//IGNORE', $string);
	 * Unfortunately the behaviour of iconv is not consistent over
	 * various systems. Sometimes it only removes invalid sequences
	 * as expected, sometimes it clears the entire string.
	 * To have consistency we always clear the string if it contains
	 * invalid UTF-8.
	 *
	 * @param string
	 * @return string
	 */
	public static function sanitize_utf8($string) {
		$sanitized = @iconv('UTF-8', 'UTF-8//IGNORE', $string);
		if (strlen($string) !== strlen($sanitized)) {
			$sanitized = '';
		}
		return $sanitized;
	}

	/**
	 * Replaces non-printable control characters.
	 * Note: If string is not valid UTF-8, the entire string will
	 * be returned empty.
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
		$string = str_replace("\xC2\xA0", ' ', $string); // Replce UTF-8 version of &nbsp; (C2 A0) with normal space
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
		return str_replace(["\n", "\r"], '', nl2br(htmlspecialchars($string), false));
	}

	/**
	 * Limit string to a number of characters and (optionally)
	 * preserve words where possible.
	 *
	 * @param  string      $string
	 * @param  int         $limit
	 * @param  string|null $end (default '…', if null)
	 * @param  boolean     $preserve_words
	 * @return string
	 */
	public static function limit($string, $limit, $end = null, $preserve_words = true) {
		if (is_null($end)) {
			$end = '…';
		}
		if (mb_strlen($string) <= $limit) return $string;
		if ($preserve_words) {
			$cut_area = mb_substr($string, $limit - 1, 2, 'UTF-8');
			if (strpos($cut_area, ' ') === false) {
				$string = mb_substr($string, 0, $limit, 'UTF-8');
				$space_pos = strrpos($string, ' ');
				if ($space_pos !== false) {
					return rtrim(mb_substr($string, 0, $space_pos, 'UTF-8')) . $end;
				}
			}
		}
		return rtrim(mb_substr($string, 0, $limit, 'UTF-8')) . $end;
	}

}