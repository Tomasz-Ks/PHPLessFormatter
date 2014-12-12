<?php

namespace CodeFormatter\Formatters\Less\Themes;

use CodeFormatter\Common\BaseTheme;
use CodeFormatter\Common\Comment;
use CodeFormatter\Formatters\Less\Attribute;
use CodeFormatter\Formatters\Less\LineComment;
use CodeFormatter\Formatters\Less\Selector;
use CodeFormatter\Formatters\Less\Variable;

class GtTheme extends BaseTheme
{

	protected $previousElem = null;
	protected $nextElem = null;

	protected $lineMaxLength = 60;

	//CONFIG
	protected $lineCurrentLength = 0;
	protected $tabSize = 4;
	protected $tabSpacing = 12;

	function __construct($lineMaxLength = 60, $tabSize = 4, $tabSpacing = 12)
	{
		$this->lineMaxLength = $lineMaxLength;
		$this->tabSize = $tabSize;
		$this->tabSpacing = $tabSpacing;
	}

	/**
	 * @param Selector $selector
	 * @return string
	 */
	protected function renderSelector(Selector $selector)
	{
		$this->lineCurrentLength = 0;
		$indentation = $this->renderIndentation();
		$result = ($this->previousElem instanceof Attribute)?"\n":'';
		$name = $selector->getName()->getName();
		$name = $indentation . implode(',', $name);
		$i = $this->renderSelectorIndentation($name);
		$indentation1 = $i===false?"\n".$this->renderSelectorIndentation(''):$i;
		if ($i!==false){
			$len = str_replace("\t",str_repeat(' ', $this->getTabSize()),$name.$i);
			$this->lineCurrentLength += strlen($len);
		}
		$result .= $name . $indentation1 . '{' . (($selector->getFirstChild() instanceof Selector) ? "\n" : ' ');
		$end = ($this->nextElem instanceof LineComment)?'':"\n";
		$result .= $selector->render();
		$result .= ($selector->hasSelectors() ? ((!strlen($end))?"\n":'') . $indentation : ' ') . "}";
		$result .= $end;
		return $result;
	}

	/**
	 * @param Attribute $attribute
	 * @return string
	 */
	protected function renderAttribute(Attribute $attribute)
	{
		$result = '';
		if ($this->lineCurrentLength >= $this->lineMaxLength){
			$result .= "\n".$this->renderIndentation().$this->renderSelectorIndentation('').'  ';
			$this->lineCurrentLength = 0;
		}
		$result .= $attribute->render();
		$this->lineCurrentLength += strlen($result);
		return $result;
	}

	/**
	 * @param Variable $variable
	 * @return string
	 */
	protected function renderVariable(Variable $variable)
	{
		$result = '';//($this->previousElem instanceof Selector)?$this->renderIndentation():'';
		$result .= $variable->render();
		return $result;
	}

	/**
	 * @param Comment $comment
	 * @return string
	 */
	protected function renderComment(Comment $comment)
	{
		return $comment->render()."\n";
	}

	protected function renderSelectorIndentation($selName)
	{
		$tabsCount = strlen(trim($selName)) / $this->tabSize;
		if (0 > $tabsCount)
			$tabsCount = 0;

		$count = ceil($this->tabSpacing - $this->getIndentationLevel() - $tabsCount);
		if (0>$count)
			return false;
		$result = str_repeat($this->getIndentationChar(), $count);
		return $result;
	}


	/**
	 * @param array $elements
	 * @return string
	 */
	public function render($elements = array())
	{

		$result = '';
		$keys = array_keys($elements);
		$count = count($elements);
		for($i=0;$i<$count;$i++){
			$key = $keys[$i];
			$elem = $elements[$i];
			$this->indentNext();
			$this->nextElem = isset($elements[$key+1])?$elements[$key+1]:null;
				if ($elem instanceof Selector)
					$result .= $this->renderSelector($elem);
				elseif ($elem instanceof Variable)
					$result .= $this->renderVariable($elem);
				elseif ($elem instanceof Attribute)
					$result .= $this->renderAttribute($elem);
				elseif ($elem instanceof Comment)
					$result .= $this->renderComment($elem);
				else
					$result .= $elem->render();
			$this->indentBack();
			$this->previousElem = $elem;
		}
		return $result;
	}

	/**
	 * @return int
	 */
	public function getLineCurrentLength()
	{
		return $this->lineCurrentLength;
	}

	/**
	 * @param int $lineCurrentLength
	 */
	public function setLineCurrentLength($lineCurrentLength)
	{
		$this->lineCurrentLength = $lineCurrentLength;
	}

	/**
	 * @return int
	 */
	public function getTabSize()
	{
		return $this->tabSize;
	}

	/**
	 * @param int $tabSize
	 */
	public function setTabSize($tabSize)
	{
		$this->tabSize = $tabSize;
	}

}