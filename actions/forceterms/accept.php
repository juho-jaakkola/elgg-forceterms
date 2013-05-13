<?php

$user = elgg_get_logged_in_user_entity();

$accepted = (boolean) get_input('terms');

if ($accepted) {
	$user->terms_accepted = time();
	system_message(elgg_echo('forceterms:accepted'));
	forward($_SESSION['last_forward_from']);
} else {
	register_error(elgg_echo('forceterms:rejected'));
	logout();
	forward();
}
