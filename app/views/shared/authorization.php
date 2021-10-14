<?php
$auths = $settings->getAuthorizations();
if(count($auths) > 0) {
	$authorized = false;
	foreach($auths as $auth) {
		if(isset($_SESSION[$auth])) $authorized = true;
	}
	if(!$authorized) {
		header("Location: /login");
	}
}