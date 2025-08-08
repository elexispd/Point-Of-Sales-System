<?php


class Input
{


	static function post($variable)
	{
		if (isset($_POST[$variable])) {
			return	validate::cee_sanitize_html($_POST[$variable]);
		} else {
			return "";
		}
	}

	static function _raw_post($variable)
	{
		if (isset($_POST[$variable])) {
			return	 $_POST[$variable];
		} else {
			return "";
		}
	}

	static function Re_scrap($rtg)
	{
		if (isset($_REQUEST[$rtg])) {

			$RTG = $_REQUEST[$rtg];
			$RTG = str_replace(" ", "", $RTG);
			$RTG = str_replace("'", "", $RTG);
			$RTG = str_replace(">", "", $RTG);
			$RTG = str_replace("<", "", $RTG);
			$RTG = str_replace("&", "", $RTG);
			$RTG = str_replace("?", "", $RTG);

			return	validate::cee_sanitize_html($RTG);
		} else {
			return "";
		}
	}

	static function get($variable)
	{

		if (isset($_GET[$variable])) {
			return	validate::cee_sanitize_html($_GET[$variable]);
		} else {
			return "";
		}
	}

	static function _raw_get($variable)
	{
		if (isset($_GET[$variable])) {
			return	 $_GET[$variable];
		} else {
			return "";
		}
	}
}
