<?php
class WebDriverElement extends MockTracer{}
class MockWebDriverElement extends WebDriverElement{
	
	public function value($value)
	{
		$this->add_trace(__FUNCTION__, $value);
	}
	
	public function clear()
	{
		$this->add_trace(__FUNCTION__);
	}
	
}