<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\Interfaces\iTheme;

class SelectorName extends LessParser
{

	function __construct($selectors, iTheme $code_theme)
	{
		$this->setCodeTheme($code_theme);
		$this->elements = explode(',', $selectors);
	}

	public function render()
	{
		return implode(',', $this->elements);
	}

	/**
	 * return array
	 */
	public function getName(){
		return $this->elements;
	}
}