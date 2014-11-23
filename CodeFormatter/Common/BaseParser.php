<?php

namespace CodeFormatter\Common;

use CodeFormatter\Common\Interfaces\iRenderable;
use CodeFormatter\Common\Interfaces\iTheme;

class BaseParser implements iRenderable
{

	protected $result = null;

	/**
	 * @var BaseTheme
	 */
	protected $code_theme = null;

	/**
	 * @var string less source
	 */
	protected $source = null;

	/**
	 * Element is parsed
	 * @var bool
	 */
	protected $isDone = false;

	function __construct($source, $code_theme)
	{
		$this->code_theme = $code_theme;
		$this->source = $source;
		$this->process();
	}

	protected function process()
	{
	}

	/**
	 * Render formatted code
	 * @return null
	 */
	public function render()
	{
		if ($this->result === null) {
			$this->process();
		}

		return $this->result;
	}

	/**
	 * @return iTheme
	 */
	public function getCodeTheme()
	{
		return $this->code_theme;
	}

	/**
	 * @param iTheme $code_theme
	 */
	public function setCodeTheme(iTheme $code_theme)
	{
		$this->code_theme = $code_theme;
	}

	/**
	 * @return string
	 */
	public function getSource()
	{
		return $this->source;
	}

	/**
	 * @param string $source
	 */
	public function setSource($source)
	{
		$this->source = $source;
	}

	/**
	 * @return boolean
	 */
	public function isDone()
	{
		return $this->isDone;
	}

	/**
	 * @param boolean $isDone
	 */
	public function setDone($isDone = true)
	{
		$this->isDone = $isDone;
	}

}