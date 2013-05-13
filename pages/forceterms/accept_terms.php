<?php

gatekeeper();

$title = elgg_echo('forceterms:accept_terms');

$info = elgg_echo('forceterms:info');

$terms = elgg_view('output/longtext', array(
	'value' => forceterms_get_terms()
));

$form = elgg_view_form('forceterms/accept', array('class' => 'mvl'), array());

$content = $info . $terms . $form;

$params = array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
