<?php
namespace startpage\doku;

function getPage($page, $trimHeader=true) {
	if ( !defined('STARTPAGE_DOKU_ROOT') ) return null;

	$fullPath = STARTPAGE_DOKU_ROOT.'data/pages/'.$page.'.txt';

	if ( !file_exists($fullPath) ) return null;

	!defined('DOKU_INC')  && define('DOKU_INC', STARTPAGE_DOKU_ROOT);
	!defined('NOSESSION') && define('NOSESSION', 1);
	require_once(DOKU_INC.'inc/init.php');
	require_once(DOKU_INC.'inc/common.php');

	$array = array();
	$return = p_render('xhtml', p_get_instructions(file_get_contents($fullPath)), $array);

	if ( $trimHeader ) {
		// Remove the first h1 - Usually the header
		$return = substr($return, strpos($return, '</h1>'));
	}

	return $return;
}