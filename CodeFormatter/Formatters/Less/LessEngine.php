<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\BaseTheme;

class LessEngine
{

	/**
	 * @var LessParser
	 */
	private $less = '';

	private $result;

	public function __construct($less_source, BaseTheme $code_theme)
	{
        $this->less = new LessParser($less_source, $code_theme);
        $this->process();
    }
    
	protected function process()
	{
        $this->result = $this->less->render();
	}

    public function render(){
        return $this->result;
    }

	public function save($file_name = null)
	{
		file_put_contents($file_name, $this->result);
	}
}