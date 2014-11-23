<?php

namespace CodeFormatter\Common;

use CodeFormatter\Common\Interfaces\iRenderable;

class EmptyLine implements iRenderable
{

	public function render()
	{
		return "\n";
	}

}