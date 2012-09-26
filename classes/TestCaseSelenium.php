<?php
class TestCaseSelenium extends TestCase
{
	protected $web_driver;
	public $browser;
	
	public function __construct($web_driver)
	{
		$this->web_driver = $web_driver;
		$this->browser = $web_driver->session('firefox');
	}
}