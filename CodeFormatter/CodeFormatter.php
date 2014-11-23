<?php

spl_autoload_register('codeformatter_autoload', false, true);

function codeformatter_autoload($class_name) {
	$pathArray = explode('\\', $class_name);
	unset($pathArray[0]);
	$pathStr =  implode(DIRECTORY_SEPARATOR, $pathArray);
	$path = __DIR__.DIRECTORY_SEPARATOR.$pathStr.".php";
	$exist = realpath($path);
	if (!$exist){
		throw new Exception('File not found!: '.$path);
	}
	require_once($exist);
}
