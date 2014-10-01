<?php
namespace startpage\trello;
use \Exception;
use \RuntimeException;
use \InvalidArgumentException;

function getFullData($boardID) {
	if ( !defined('STARTPAGE_TRELLO_DATA') )
		throw new RuntimeException('Please define "STARTPAGE_TRELLO_DATA" with the path to your trello data directory.');

	$fullPathBoard = STARTPAGE_TRELLO_DATA.'trello-board.'.$boardID.'.dat';
	$fullPathLists = STARTPAGE_TRELLO_DATA.'trello-lists.'.$boardID.'.dat';
	$fullPathCards = STARTPAGE_TRELLO_DATA.'trello-cards.'.$boardID.'.dat';

	if ( !file_exists($fullPathBoard) || !file_exists($fullPathLists) || !file_exists($fullPathCards) ) {
		throw new RuntimeException('One/all of the trello dat files do not exist.');
	}

	return array(
		'board' => unserialize(file_get_contents($fullPathBoard)),
		'lists' => unserialize(file_get_contents($fullPathLists)),
		'cards' => unserialize(file_get_contents($fullPathCards)),
	);
}

function combineTrelloData($data) {
	if ( !is_array($data) || count($data) != 3 ) 
		throw new InvalidArgumentException('Invalid data passed. Please pass data from the startpage\trello\getFullData method.');

	$cards = array();

	// First get the lists
	foreach ( $data['lists'] AS $list ) {
		$cards[$list->id] = array(
			'name'  => $list->name,
			'cards' => array(),
		);
	}

	// Put the cards into each one
	foreach ( $data['cards'] AS $card ) {
		$labels = array();

		foreach ( $card->labels AS $label ) {
			$labels[] = $label->name;
		}

		$cards[$card->idList]['cards'][] = array(
			'id'   => $card->id,
			'name' => $card->name,
			'uri'  => $card->shortUrl,
			'labels' => $labels,
			'due'  => $card->due,
		);
	}

	return $cards;
}

function sortCardsBy($cards, $field) {
	foreach ( $cards AS &$card ) {
		usort($card['cards'], function($dataA, $dataB) {
			// If either array does not have the field, don't sort.
			if ( !isset($dataA[$field]) || !isset($dataB[$field]) ) return 0;

			$a = $dataA['cards'][$field];
			$b = $dataB['cards'][$field];

			return $a > $b ? -1 : 1;
		});
	}

	return $cards;
}

// My non-traditional method for my homework
// This is so ugly, I am so sorry.
function getHomework($boardID, $futureCutoff=false) {
	try {
		$cards = sortCardsBy(combineTrelloData(getFullData($boardID)), 'due');
	} catch ( Exception $e ) {
		return $e->getMessage();
	}

	if ( $futureCutoff == false || !is_numeric($futureCutoff) ) {
		$futureCutoff = time() + 60*60*24*7*2; // 2 weeks
	}

	$output = '';

	foreach ( $cards AS $card ) {
		if ( empty($card['cards']) ) continue;
		$addedCard = false;

		$cardHW = '<h4>'.$card['name'].'</h4>';
		$cardHW .= '<ul>';
		foreach ( $card['cards'] AS $c ) {
			if ( $c['due'] > $futureCutoff ) continue; // Must be due in the next xx time period
			if ( !in_array('Posted', $c['labels']) ) continue; // Must have the "Posted" label

			$addedCard = true;

			$cardHW .= '<li>'.$c['name'];
			$cardHW .= '<ul>';
			$cardHW .= '<li>Due '.date('M j @ g:iA', strtotime($c['due'])).'</li>';
			$cardHW .= '<li><a href="'.$c['url'].'">View Homework</a></li>';
			$cardHW .= '</ul>';
			$cardHW .= '</li>';
		}
		$cardHW .= '</ul>';

		if ( $addedCard ) $output .= $cardHW;
	}

	return $output;
}