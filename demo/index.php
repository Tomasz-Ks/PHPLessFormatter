<?php
/**
 * Created by PhpStorm.
 * User: Tomek
 * Date: 2014-11-04
 * Time: 17:34
 */

use CodeFormatter\Formatters\Less\LessEngine;
use CodeFormatter\Formatters\Less\Themes\GtTheme;
$t = microtime(true);

$lessFormated = '';
$tabSize = (isset($_POST['tab-size']))?(int)$_POST['tab-size']:4;
$tabSpacing = (isset($_POST['tab-spacing']))?(int)$_POST['tab-spacing']:9;
$lineLen = (isset($_POST['line-length']))?(int)$_POST['line-length']:80;
if (!empty($_POST) && isset($_POST['source'])) {

	require ".." . DIRECTORY_SEPARATOR . "CodeFormatter" . DIRECTORY_SEPARATOR . "CodeFormatter.php";

	$less_raw = $_POST['source'];
	$theme = new GtTheme($lineLen, $tabSize, $tabSpacing);

	$less = new LessEngine($less_raw, $theme);
	$lessFormated = $less->render();
	$less->save('result.less');
}
$time = (microtime(true) - $t);
?>
	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Less Code Formatter</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
	</head>
	<body>
	<style>
		body, html, form, .container, .col-sm-12 {
			height : 100%;
		}
		.page-header {
			margin-top : 0;
		}
		h1 {
			font-size : 2em;
		}

		.clear {
			clear : both;
			float : none;
		}

		.row.form {
			height : 70%;
		}

		.form-group.code {
			height     : 95%;
			min-height : 400px;
		}

		.form-group.code textarea {
			height        : 100%;
			width         : 100%;
			-moz-tab-size : 4;
			tab-size      : 4;
			font-family   : monospace;
			font          : 12px monospace;
		}

		.input-group {
			float        : left;
			margin-right : 10px;
		}

		.input-group input,
		.input-group select {
			text-align : center;
		}

		.input-group input.form-control {
			width : 80px;
		}

		.input-group input,
		.input-group label {
			float : none;
		}

		.input-group label {
			display : block;
		}
	</style>
	<form action="#" method="POST">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="well well-sm">
						<div class="page-header">
							<h1>Less Code Formatter</h1>
						</div>
						<div>
							<div class="input-group">
								<label class="control-label">Style:</label>
								<select class="form-control" name="theme" id="">
									<option value="gttheme">GtTheme</option>
								</select>
							</div>
							<div class="input-group tab-size">
								<label class="control-label">Tab size:</label>
								<input class="form-control" type="text" name="tab-size" value="<?php echo $tabSize; ?>"/>
							</div>
							<div class="input-group tab-size">
								<label class="control-label">Tab spacing:</label>
								<input class="form-control" type="text" name="tab-spacing" value="<?php echo $tabSpacing; ?>"/>
							</div>
							<div class="input-group line-length">
								<label class="control-label">Line length:</label>
								<input class="form-control" type="text" name="line-length" value="<?php echo $lineLen; ?>"/>
							</div>
							<div class="form-group">
								<button class="btn btn-primary pull-right" type="submit">Format</button>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row form">
				<div class="col-sm-12">
					<div class="form-group code">
						<textarea name="source" id="" class="form-control"
						          placeholder="Put less code here..."><?php echo stripslashes($lessFormated) ?></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary pull-right" type="submit">Format</button>
					</div>
				</div>
			</div>
		</div>
		<?php echo $time; ?>
	</form>
	</body>
	</html>
<?php
