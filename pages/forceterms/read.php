<?php

$title = elgg_echo('forceterms:accept_terms');
$terms = forceterms_get_terms();

echo <<<HTML
	<div class="forceterms-wrapper">
		<h2>$title</h2>
		<div class="mtl">$terms</div>
	<div>
HTML;
