<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\Interfaces\iTheme;
use CodeFormatter\Formatters\Less\Themes\LessBaseTheme;

class Selector extends LessParser
{

	/**
	 * @var SelectorName
	 */
	private $name = null;

	/**
	 * @param SelectorName $name
	 * @param string|null $content Body of selector
	 * @param LessBaseTheme $code_theme
	 */
	function __construct(SelectorName $name, $content, iTheme $code_theme)
	{
		$this->name = $name;
		parent::__construct($content, $code_theme);
	}

	public function render()
	{
		$ct = $this->getCodeTheme();
		$result = $ct->render($this->elements);
		if (!strlen($result) && strlen($this->getSource())){
			$result = rtrim($this->getSource(), "} \t");
		}
		return $result;
	}

	/**
	 * @return SelectorName
	 */
	public function getName()
	{
		return $this->name;
	}

	public function getFirstChild(){
		return isset($this->elements[0])?$this->elements[0]:null;
	}

}
