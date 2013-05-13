<?php

$terms_updated_label = elgg_echo('forceterms:terms_updated:label');

$terms_updated_input = elgg_view('input/date', array(
	'name' => 'params[terms_updated]',
	'value' => $vars['entity']->terms_updated,
	'timestamp' => true,
));

echo <<<HTML
	<div>
		<label>$terms_updated_label</label>
		$terms_updated_input
	</div>
HTML;
