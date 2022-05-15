<?php

function getConfig($key)
{
	global $input, $config;
	
	return isset($config[$input->group_id][$key]) ? $config[$input->group_id][$key] : null;
}

function getVk($tokenType = 'user')
{
	static $vk;
	
	if (! isset($vk[$tokenType]))
	{
		$types = [
			'group' => getConfig('group_token'),
			'user' => getConfig('user_token'),
		];
		
		$vk[$tokenType] = new Vk();
		$vk[$tokenType]->set_access_token($types[$tokenType]);
	}
	
	return $vk[$tokenType];
}

function removeConversationMessage($messageId, $peer_id)
{
	return getVk()->api('messages.delete', [
		'conversation_message_ids' => $messageId,
		'peer_id' => $peer_id,
		'delete_for_all' => 1,
	]);
}

function getStopWords() {
	static $words;
	
	if (! isset($words)) {
		$words = explode("\n", file_get_contents(__DIR__ . '/stop_words.txt'));
		$words = array_map('trim', $words);
		$words = array_filter($words);
		$words = array_map('mb_strtolower', $words);
	}
	
	return $words;
}