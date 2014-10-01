<?php isset($links) or die('Unauthorized access.');

define('STARTPAGE_DOKU_ROOT', '/path/to/dokuwiki/here/');
define('STARTPAGE_TRELLO_DATA', '/path/to/trello/data/here/check/crontab/');
define('STARTPAGE_TRELLO_BOARD', 'BOARDID');
define('STARTPAGE_TRELLO_CUTOFF', 60*60*24*7*2);

require './modules/doku.php';
require './modules/trello.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Startpage for James Droste">
	<meta name="author" content="James Droste <james@droste.im>">

	<title><?php echo $greeting; ?></title>

	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/startpage.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<h1>links</h1>
			<div class="container-fluid links">
				<div class="row links-row">
					<!-- links go here -->
					<?php foreach ( $links AS $cat => $linkarr ) : ?>
					<div class="links-category list-group">
				        <div class="row-category-header list-group-item active"><?php echo $cat; ?></div>
						<?php foreach ( $linkarr as $l ) : ?>
						<a href="<?php echo $l[1]; ?>" class="list-group-item"><?php echo $l[0]; ?></a>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-md-2">
			<h1>notes</h1>
			<?php echo \startpage\doku\getPage('notes/start'); ?>
		</div>

		<div class="col-md-2">
			<h1>due soon</h1>
			<?php echo \startpage\trello\getHomework(STARTPAGE_TRELLO_BOARD, STARTPAGE_TRELLO_CUTOFF); ?>
		</div>
	</div>
</div>
</body>
</html>
