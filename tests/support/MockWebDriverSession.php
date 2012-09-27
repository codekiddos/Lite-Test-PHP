<?php

class WebDriverSession extends MockTracer {}

class MockWebDriverSession extends WebDriverSession
{
	protected $page_loaded = 0;
	
	public $window_handles;
	
	public function __construct()
	{
		$this->window_handles = array("handle1", "handle2", "handle3");
	}
	
	public function open($url)
	{
		$this->add_trace(__FUNCTION__, $url);
	}
	
	public function close()
	{
		$this->add_trace(__FUNCTION__);
	}
	
	public function window_handles()
	{
		$this->add_trace(__FUNCTION__);
		return $this->window_handles;
	}
	
	public function focusWindow($window_handle)
	{
		$this->add_trace(__FUNCTION__, $window_handle);
	}
	
	public function frame($frame)
	{
		$this->add_trace(__FUNCTION__, $frame);
	}
	
	public function element($selector_type, $selector)
	{
		$this->add_trace(__FUNCTION__, array($selector_type, $selector));
		
		if($selector == 'existant_element')
			return new MockWebDriverElement();
		
		if($selector == 'non_existant_element')
			throw new Exception();
			
		if($selector == 'existant_element_waiting')
		{
			if($this->page_loaded >= 5)
				return new MockWebDriverElement();
				
			$this->page_loaded++;
			throw new Exception();
		}
	
	}
	
	public function elements($selector_type, $selector)
	{
		$this->add_trace(__FUNCTION__, array($selector_type, $selector));
		$elements = array(new MockWebDriverElement());
		
		if($selector == 'existant_element')
			return $elements;
		
		if($selector == 'non_existant_element')
			throw new Exception();
			
		if($selector == 'existant_element_waiting')
		{
			if($this->page_loaded >= 5)
				return $elements;
				
			$this->page_loaded++;
			throw new Exception();
		}
	}
}