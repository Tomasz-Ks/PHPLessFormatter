<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\Interfaces\iTheme;
use CodeFormatter\Formatters\Less\Themes\LessBaseTheme;

class Attribute extends LessParser
{

	public $name = '';
	public $value = '';

	function __construct($name, $value, iTheme $code_theme)
	{
		$this->setCodeTheme($code_theme);
		$this->name = $name;
		$this->value = $value;
		$this->normalize();
	}

	public function render()
	{
		return $this->name . ((!strlen($this->value))?';':(':' . trim($this->value) . ';'));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return iTheme|string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * remove expendable chars
	 */
	private function normalize(){
		$this->name = rtrim($this->name, ":;\t\r\n");
		$this->value = rtrim($this->value, ";");
	}

}