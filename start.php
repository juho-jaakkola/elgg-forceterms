<?php

elgg_register_event_handler('init', 'system', 'forceterms_init');

/**
 * Initialize the plugin
 */
function forceterms_init () {
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'forceterms_public_pages');

	$site = elgg_get_site_entity();
	$url = current_page_url();

	if (elgg_is_logged_in() && !elgg_is_admin_logged_in() && (!$site->isPublicPage() || $site->url == $url)) {
		forceterms_check();
	}

	$actions_path = elgg_get_plugins_path() . 'forceterms/actions/forceterms/';
	elgg_register_action('forceterms/accept', $actions_path . 'accept.php');

	elgg_register_page_handler('accept_terms', 'forceterms_page_handler');

	elgg_register_plugin_hook_handler('action', 'register', 'forceterms_check_registration');
	elgg_register_plugin_hook_handler('register', 'user', 'forceterms_registration_handler');

	elgg_extend_view('register/extend', 'forceterms/register');
	elgg_extend_view('css/elgg', 'forceterms/css');
}

/**
 * Check if the logged in user has accepted latest terms.
 */
function forceterms_check () {
	$terms_updated = (int) elgg_get_plugin_setting('terms_updated', 'forceterms');

	$user = elgg_get_logged_in_user_entity();

	if (empty($user->terms_accepted) || $user->terms_accepted < $terms_updated) {
		forward('accept_terms');
	}
}

/**
 * Define pages that do not require having terms accepted.
 * 
 * @param  string $hook
 * @param  string $type
 * @param  array  $return
 * @param  array  $params
 * @return array  $return
 */
function forceterms_public_pages ($hook, $type, $return, $params) {
	$return[] = 'accept_terms.*';
	$return[] = 'action/logout';
	$return[] = 'action/forceterms/accept';
	$return[] = 'groupicon/.*';
	$return[] = 'admin.*';
	return $return;
}

/**
 * Handle requests to accept_terms
 * 
 * @param  array   $page
 * @return boolean
 */
function forceterms_page_handler ($page) {
	switch ($page[0]) {
		case 'read':
			//echo elgg_view('forceterms/read');
			include_once('pages/forceterms/read.php');
			break;
		default:
			include_once('pages/forceterms/accept_terms.php');
			break;
	}

	return true;
}

/**
 * Return terms page from external pages 
 * 
 * @return boolean|string The terms or false
 */
function forceterms_get_terms () {
	$result = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'terms',
		'limit' => 1,
	));

	if (isset($result[0])) {
		return $result[0]->description;
	}

	return false;
}

/**
 * Check that user has accepted terms when attempting registration.
 */
function forceterms_check_registration () {
	// Prevent missing value from clearing the registration form
	elgg_make_sticky_form('register');

	$value = get_input('terms');
	if (empty($value)) {
		register_error(elgg_echo('forceterms:missing'));
		forward(REFERER);
	}

	return $return;
}

/**
 * Save the time when user accepted the terms of use.
 * 
 * @param  string $hook
 * @param  string $type
 * @param  array  $return
 * @param  array  $params
 * @return array  $return
 */
function forceterms_registration_handler ($hook, $type, $return, $params) {
	$user = $params['user'];

	if (elgg_instanceof($user, 'user')) {
		// The value is already validated so just insert it
		$user->terms_accepted = time();

		// User is not yet logged in so we need to ignore the access level
		$ia = elgg_set_ignore_access(true);
		$user->save();
		elgg_set_ignore_access($ia);
	}

	return $return;
}