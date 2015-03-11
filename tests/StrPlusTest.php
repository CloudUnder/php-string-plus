<?php

class StrPlusTest extends PHPUnit_Framework_TestCase {

	public function testSanitizeUTF8() {
		$result = StrPlus\StrPlus::sanitize_utf8("a\x80b");
		$expect = '';
		$this->assertEquals($expect, $result);

		$result = StrPlus\StrPlus::sanitize_utf8("\xC3\x2E");
		$expect = '';
		$this->assertEquals($expect, $result);

		$result = StrPlus\StrPlus::sanitize_utf8("\x00Å");
		$expect = "\x00Å";
		$this->assertEquals($expect, $result);
	}

	public function testReplaceControlChars() {
		// Replace low-end control characters and make sure the replacement is actually used
		$result = StrPlus\StrPlus::replace_control_chars('-*-', "a\x00b c");
		$expect = 'a-*-b c';
		$this->assertEquals($expect, $result);

		// Ensure invalid UTF-8 sequences don't slip through.
		// Note 1: ASCII character 0x80 is 0xC2, 0x80 in UTF-8.
		//         0x80 on its own is invalid UTF-8.
		// Note 2: If string contains an invalid UTF-8 sequence the
		//         entire string will be cleared.
		$result = StrPlus\StrPlus::replace_control_chars('-', "a\x80b");
		$expect = '';
		$this->assertEquals($expect, $result);

		$result = StrPlus\StrPlus::replace_control_chars('-', "a\x7fb\xC2\x80c");
		$expect = 'a-b-c';
		$this->assertEquals($expect, $result);

		// Replace both low-end and high-end control characters
		$result = StrPlus\StrPlus::replace_control_chars('-', "a\x7Fb\x00c\xC2\x80d\xC2\x80e\xC2\x9Ff\r\n\tg");
		$expect = 'a-b-c-d-e-f---g';
		$this->assertEquals($expect, $result);

		// Make sure normal, valid UTF-8 non-ASCII chracters are not replaced
		$result = StrPlus\StrPlus::replace_control_chars('', "\xC3\x96l.~\xc2\xa1£€Σ");
		$expect = 'Öl.~¡£€Σ';
		$this->assertEquals($expect, $result);

		// Cyrillic, Arabic, Miao
		$expect = 'Ж ݖ ' . "\xf0\x96\xbc\x86";
		$result = StrPlus\StrPlus::replace_control_chars('', $expect);
		$this->assertEquals($expect, $result);
	}

	public function testSingleLine() {
		$result = StrPlus\StrPlus::single_line("\na\rb\n\rc\r\nd\n\ne\n\n\n\n\nf\r\n\r\n\r\n\r\n\r\ng\n");
		$expect = 'a b c d e f g';
		$this->assertEquals($expect, $result);
	}

	public function testHtmlToSingleLineText() {
		$result = StrPlus\StrPlus::html_to_single_line_text(
			' <h1>Line 1</h1>' .
			'<p class="x">' . "\n" .
			"\t" . '<b>Line</b> 2' .
			'</p>' . "\n" .
			'<br>Line' . "\n\t\t\t" . '3' . 
			'<h2 class="head line"><span data-x=true>Line<br />' . "\t" . '4</h2>' . "\n" .
			'Line&nbsp;5' . "\n"
		);
		$expect = 'Line 1 Line 2 Line 3 Line 4 Line 5';
		$this->assertEquals($expect, $result);
	}

}