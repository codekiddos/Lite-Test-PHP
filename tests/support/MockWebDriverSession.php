<?php

class WebDriverSession extends MockTracer {}

class MockWebDriverSession extends WebDriverSession
{
	protected $page_loaded = 0;
	
	public function open($url)
	{
		$this->add_trace(__FUNCTION__, $url);
	}
	
	public function close()
	{
		$this->add_trace(__FUNCTION__);
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
			
		
		if($selector == 'non_existant_element_waiting')
			throw new Exception();
			
	}
	
	public function elements($selector_type, $selector)
	{
		$this->add_trace(__FUNCTION__, array($selector_type, $selector));
		$elements = array(new MockWebDriverElement());
		
		if($selector == 'existant_element')
			return $elements;
		
		/*if($selector == 'non_existant_element')
			throw new Exception();
			
		if($selector == 'existant_element_waiting')
		{
			if($this->page_loaded >= 5)
				return new MockWebDriverElement();
				
			$this->page_loaded++;
			throw new Exception();
		}
			
		
		if($selector == 'non_existant_element_waiting')
			throw new Exception();*/
			
	}
}