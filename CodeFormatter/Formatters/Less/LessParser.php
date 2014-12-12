<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\BaseParser;
use CodeFormatter\Common\EmptyLine;
use CodeFormatter\Common\Interfaces\iTheme;
use CodeFormatter\Formatters\Less\Themes\LessBaseTheme;

class LessParser extends BaseParser
{

	/**
	 * @var array of Selectors
	 */
	protected $selectors = array();

	/**
	 * @var array of Attributes
	 */
	protected $attributes = array();

	/**
	 * @var bool
	 */
	protected $hasSelector = false;

	/**
	 * all elements with order
	 * @var array
	 */
	protected $elements = array();

	function __construct($source, iTheme $code_theme)
	{
		$this->code_theme = $code_theme;
		$this->source = $source;
		$this->process();
	}

	/**
	 *
	 */
	protected function process()
	{
		if ($this->isDone())
			return;
		$src = $this->getSource();
		//getting root elements
		$counter = 0;
		$buffer = '';
		$selector_open = false;
		$selector_name = '';
		$block_comment_open = false;
		$line_comment_open = false;
		$bracket_open = false;
		$quote_open = false;
		$comment_open = false;
		$ct = $this->getCodeTheme();

		$strlen = strlen($src);
		for ($i = 0; $i < $strlen; $i++) {
			$char = $src[$i];
			$buffer .= $char;
			switch ($char) {
				case ';'://attribute end
					if (!$selector_open && !$comment_open && !$bracket_open) {
						$divider_pos = strpos(trim($buffer), ':');
						$buffer = trim($buffer);
						$attr[0] = substr($buffer, 0, $divider_pos);
						$attr[1] = substr($buffer, $divider_pos, strlen($buffer));
						$attrName = trim($attr[0]);
						$attrVal = trim($attr[1], ': ');
						if ($attrName[0] == '@') {
							$attribute = new Variable($attrName, $attrVal, $ct);
						} else {
							$attribute = new Attribute($attrName, $attrVal, $ct);
						}
						$this->elements[] = $attribute;
						$buffer = '';
					}
					break;
				case '{'://selector start
					if (!$bracket_open) {
						if (!$selector_open && !$block_comment_open) {
							$selector_name = rtrim(trim($buffer), '{');
							$buffer = '';
							$selector_open = true;
						}
						$counter++;
					}
					break;
				case '"':
					if (!$quote_open) {
						$quote_open = true;
					} else {
						$quote_open = false;
					}
					break;
				case '}'://selector end
					if (!$block_comment_open && !$bracket_open) {
						$counter--;
						if ($counter == 0) {
							$sName = new SelectorName(trim($selector_name), $ct);
							$buffer = rtrim($buffer, '}');
							$selector = new Selector($sName, trim($buffer), $ct);
							$this->hasSelector = true;
							$this->elements[] = $selector;
							$buffer = $selector_name = '';
							$selector_open = false;
						}
					}
					break;
				case '\\'://find block comment start
					if (isset($src[$i + 1]) && '*' === $src[$i + 1]) {
						$block_comment_open = $comment_open = true;
					}
					break;
				case "\n"://find new line
					if (!$selector_open && $line_comment_open && $comment = trim($buffer)) {
						$this->elements[] = new LineComment($comment, $ct);
						$line_comment_open = $comment_open = false;
						$buffer = '';
						break;
					}
					if (isset($src[$i + 1]) && in_array($src[$i + 1], array("\n", "\r"))) {
						$this->elements[] = new EmptyLine();
					}
					break;
				case '/':
					if ('*' === $src[$i - 1]) {//find block comment end
						$block_comment_open = $comment_open = false;
						$this->elements[] = new BlockComment(trim($buffer), $ct);
						$buffer = '';
						break;
					}
					if (isset($src[$i + 1]) && $src[$i + 1] == '/' && !$line_comment_open) {
						$line_comment_open = $comment_open = true;
					}
					break;
				case '(':
					$bracket_open = false;
					break;
				case ')':
					$bracket_open = false;
					break;
			}
		}
		$this->setDone();
	}

	public function render()
	{
		if (!$this->isDone()) {
			$this->process();
		}
		if ($this->result)
			return $this->result;
		$this->result = $this->getCodeTheme()->render($this->getElements());

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
	 * GET all elements
	 * @return array
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * @return bool
	 */
	public function hasSelectors()
	{
		return $this->hasSelector;
	}

}