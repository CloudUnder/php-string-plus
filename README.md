php-string-plus
===============

More string helpers for PHP (and Laravel).

[![Build Status](https://travis-ci.org/CloudUnder/php-string-plus.svg)](https://travis-ci.org/CloudUnder/php-string-plus)
[![Latest Stable Version](https://poser.pugx.org/spiegeleye/php-string-plus/v/stable.svg)](https://packagist.org/packages/spiegeleye/php-string-plus)
[![Latest Unstable Version](https://poser.pugx.org/spiegeleye/php-string-plus/v/unstable.svg)](https://packagist.org/packages/spiegeleye/php-string-plus)
[![License](https://poser.pugx.org/spiegeleye/php-string-plus/license.svg)](https://packagist.org/packages/spiegeleye/php-string-plus)
[![Total Downloads](https://poser.pugx.org/spiegeleye/php-string-plus/downloads.svg)](https://packagist.org/packages/spiegeleye/php-string-plus)

## Usage

Require the package in your `composer.json` file:

`"spiegeleye/php-string-plus": "1.3.*"`

In your PHP file add `use StrPlus\StrPlus;` for convenience.

## Helpers

`StrPlus::replace_control_chars($replace, $string)`

Replaces non-printable control characters in `$string` with `$replace`.

`StrPlus::single_line($string)`

Converts a multi-line text to a text without line breaks or other non-printable characters. Multiple successive spaces are reduced to one sinle space.

`StrPlus::function html_to_single_line_text($string)`

Converts a HTML formatted block to a plain text one-line string without non-printable characters.

`StrPlus::multi_line_text_to_html($string)`

Converts a multi-line plain text string to a multi-line HTML string where line breaks become `<br>` tags.

`StrPlus::limit($string, $limit, $end = null, $preserve_words = true)`

Limit string to a number of characters and preserve words where possible (optional; default is true). If `$end` is not set or `null` the default character `…` will be used.
