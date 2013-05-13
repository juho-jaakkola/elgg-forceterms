<?php


$terms_label = elgg_echo('forceterms:register:label', array(elgg_echo('forceterms:register:link')));
$terms_input = elgg_view('input/checkbox', array(
	'name' => 'terms',
	'value' => 1,
));

$submit_input = elgg_view('input/submit');

echo <<<HTML
	<div>
		$terms_input
		<label>$terms_label </label>
	</div>
	<div>
		<label>$submit_input</label>
	</div>
HTML;
