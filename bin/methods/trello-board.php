<?php
function trello_board($argv) {
	if ( empty($argv) ) {
		\cli\err('Method trello-board requires an argument of the board ID.');
		return 0;
	}

	$board = array_shift($argv);
	$trello = new \Trello\Trello(API_KEY, null, API_TOKEN);

	echo serialize($trello->boards->get($board));
	return 1;
}
