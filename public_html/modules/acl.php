<?php
function acl_enable($accessKey, $links) {
	$access = false;
	if ( isset($_GET['k']) && $_GET['k'] == $accessKey ) {
		$access = true;
	}

	foreach ( $links AS $cat => $linkarr ) {
		if ( substr($cat, 0, 1) == '_' ) {
			if ( $access ) {
				$links = acl_rename_array($links, $cat);
			} else {
				unset($links[$cat]);
			}
		} else {
			foreach ( $linkarr AS $i => $l ) {
				if ( substr($l[0], 0, 1) == '_' ) {
					if ( $access ) {
						//$links[$cat][$i][0] = substr($l[0], 1);
					} else {
						unset($links[$cat][$i]);
					}
				}
			}
		}
	}

	return $links;
}

function acl_rename_array($links, $oldKey) {
	foreach ( $links AS $key => $value ) {
		if ( $key != $oldKey ) continue;
		
		$links[substr($key, 1)] = $value;
		unset($links[$key]);
	}

	return $links;
}
