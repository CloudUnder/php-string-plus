<?php

class StrPlusTest extends PHPUnit_Framework_TestCase {

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