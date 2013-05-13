<?php

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$terms_link = elgg_view('output/url', array(
	'href' => 'accept_terms/read',
	'text' => elgg_echo('forceterms:register:link'),
	'class' => 'elgg-lightbox',
));

$terms_label = elgg_echo('forceterms:register:label', array($terms_link));

$options = array(
	'name' => 'terms',
	'value' => 1,
);

if (!empty($vars['terms'])) {
	$options['checked'] = '';
}

$terms_input = elgg_view('input/checkbox', $options);

echo <<<HTML
	<div>
		$terms_input
		<label>$terms_label </label>
	</div>
HTML;
