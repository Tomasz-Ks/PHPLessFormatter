<?php

spl_autoload_register('codeformatter_autload', false, true);

function codeformatter_autload($class_name) {
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
	//echo realpath(".") . DIRECTORY_SEPARATOR . $path.".php\n";
	$path = realpath(".".DIRECTORY_SEPARATOR. $path . ".php");
	//echo "Load: ".$path."\n";
	require_once($path);
}
