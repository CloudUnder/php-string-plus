php-string-plus
===============

More string helpers for PHP

## Usage

Require the package in your `composer.json` file:

`"spiegeleye/php-string-plus": "1.1.*"`

In your PHP file add `use StrPlus\StrPlus;` for convenience.

## Helpers

`StrPlus::replace_control_chars($replace, $string)`

Replaces non-printable control characters.

`StrPlus::single_line($string)`

Converts a multi-line text to a text without line breaks or other non-printable characters. Multi-spaces are reduces to one space.

`StrPlus::function html_to_single_line_text($string)`

Converts a HTML formatted block to a plain text one-line string without non-printable characters.

`StrPlus::multi_line_text_to_html($string)`

Converts a multi-line plain text string to a multi-line HTML string where line breaks become `<br>` tags.
