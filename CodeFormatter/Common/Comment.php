<?php

namespace CodeFormatter\Common;

class Comment  extends BaseParser
{

	public function render()
	{
		return $this->getSource();
	}

}