<?php

if (! defined('TOP_FILE')) die('error');

if (empty($input->object->post_type)) {
	file_put_contents(__FILE__ . '.log', 'incorrect input data (empty $input->object->post_type)');
}

if ($input->object->post_type === 'suggest' and !empty($input->object->text)) {
	$text = mb_strtolower($input->object->text);
	$words = getStopWords();
	
	$spamText = false;
	foreach ($words as $word) {
		if (strpos($text, $word) !== false) {
			$spamText = true;
		}
	}
	
	if (! $spamText) {
		$res = getVk()->api('wall.post', [
			'owner_id' => $input->object->owner_id,
			'post_id' => $input->object->id,
		]);
		
		if (! empty($res->error->error_msg)) {
			file_put_contents(__FILE__ . '.log', print_r($res, true));
		}
	}
}
