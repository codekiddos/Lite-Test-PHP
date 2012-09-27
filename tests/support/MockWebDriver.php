<?php
class WebDriver extends MockTracer {}
class MockWebDriver extends WebDriver
{	
	public function session()
	{
		$this->add_trace(__FUNCTION__);
		return new MockWebDriverSession();
	}
}