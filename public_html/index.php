<?php
// access key to unlock everything
$accessKey = 'INSERT_ACCESS_KEY_HERE';

// links
$links = array(
	'social' => array(
		array('reddit', 'http://www.reddit.com/'),
		array('hacker news', 'https://news.ycombinator.com/'),
	),
	'coding' => array(
		array('github', 'https://github.com'),
		array('bitbucket', 'https://bitbucket.org/'),
	),
	'services' => array(
		array('gmail', 'http://gmail.com'),
		array('twitter', 'https://twitter.com/'),
		array('ebay', 'http://www.ebay.com')
	),
	'internal apps' => array(
		array('wiki', 'https://your-doku-wiki-here'),
	),
	'_todo' => array(
		array('homework', 'https://trello.com/b/BOARDID/homework'),
		array('personal', 'https://trello.com/b/BOARDID/personal'),
		array('work', 'https://trello.com/b/BOARDID/work'),
	),
);

// greetings
$greetings = array(
	'Hello, James',
	'Ni hao, James',
	'Welcome James!',
	'How are you doing James?',
	'How may I help you, James?'
);

// ======================================
// STOP EDITING HERE
// ======================================

// Get our greeting
$greeting = $greetings[array_rand($greetings)];

// Output da template
include 'template.php';
