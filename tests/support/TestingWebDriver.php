<?php
class TestingWebDriver
{
	public $trace = array();
	
	public function session($browser)
	{
		$this->trace('session', $browser);
		
		return "browser";
	}
	
	protected function trace($method, $args)
	{
		$this->trace[$method] = $args;
	}
}
