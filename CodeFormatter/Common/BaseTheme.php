<?php

namespace CodeFormatter\Common;

use CodeFormatter\Common\Interfaces\iRenderable;
use CodeFormatter\Common\Interfaces\iTheme;

class BaseTheme implements iRenderable, iTheme
{

	/**
	 * @var bool
	 */
	private $use_indentation = true;

	/**
	 * @var int
	 */
	private $indentation_level = -1;

	/**
	 * @var string
	 */
	private $indentation_char = "\t";

	/**
	 * @var int
	 */
	private $indentation_lenght = 1;

	/**
	 * @return boolean
	 */
	public function isUseIndentation()
	{
		return $this->use_indentation;
	}

	/**
	 * @param boolean $use_indentation
	 */
	public function setUseIndentation($use_indentation)
	{
		$this->use_indentation = $use_indentation;
	}

	public function indentNext(){
		return ++$this->indentation_level;
	}

	public function indentBack(){
		--$this->indentation_level;
		return $this->getIndentationLevel();
	}

	/**
	 * @return int
	 */
	public function getIndentationLevel()
	{
		$lvl = $this->indentation_level;
		return ($lvl<0)?0:$lvl;
	}

	/**
	 * @param int $indentation_level
	 */
	public function setIndentationLevel($indentation_level)
	{
		$this->indentation_level = $indentation_level;
	}

	/**
	 * @return string
	 */
	public function getIndentationChar()
	{
		return $this->indentation_char;
	}

	/**
	 * @param string $indentation_char
	 */
	public function setIndentationChar($indentation_char)
	{
		$this->indentation_char = $indentation_char;
	}

	/**
	 * @return int
	 */
	public function getIndentationLenght()
	{
		return $this->indentation_lenght;
	}

	/**
	 * @param int $indentation_lenght
	 */
	public function setIndentationLenght($indentation_lenght)
	{
		$this->indentation_lenght = $indentation_lenght;
	}

	public function renderIndentation(){
		return ($this->use_indentation)?str_repeat($this->getIndentationChar(), $this->getIndentationLenght()*$this->getIndentationLevel()):'';
	}

	public function render($elements=array())
	{
		return '';
	}
}