<?php

namespace CodeFormatter\Formatters\Less;

use CodeFormatter\Common\BaseParser;
use CodeFormatter\Common\BaseTheme;

class LessEngine
{

	/**
	 * @var LessParser
	 */
	public $less = '';

	private $result;

	public function __construct($less_source, BaseTheme $code_theme)
	{
//        $less = $this->clear($less_source);
        $this->less = new LessParser($less_source, $code_theme);
        $this->process();
    }
    
	protected function process()
	{
        $this->result = $this->less->render();
	}

    public function render(){
        return  $this->result;
    }

	public function save($file_name = null)
	{
		file_put_contents($file_name, $this->result);
	}
}