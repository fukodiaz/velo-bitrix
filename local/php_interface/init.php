<?php
	const DEFAULT_TEMPLATE_PATH = '/local/templates/.default';

	function debug($data) {
		echo "<pre>" . print_r($data, 1) . "</pre>";
	} 

	function cutStr($str, $length=50, $postfix='...') {
		if (strlen($str) <= $length) {
			return $str;
		}

		$temp= substr($str, 0, $length);
		return substr($temp, 0, strrpos($temp, ' ')) . $postfix;
	}