<?php
class TestWebDriverBrowser extends TestCase
{
	public function before_each()
	{
		$this->web_driver = new MockWebDriver();
		$this->browser = new WebDriverBrowser($this->web_driver);
	}
	
	public function test_open()
	{
		$this->assert_equals($this->web_driver->trace[0]["method"], "session");
		$this->assert_true($this->browser->session instanceof WebDriverSession);
		
		$this->browser->open("test_url");
		
		$this->assert_equals($this->browser->session->trace[0]["method"], "open");
		$this->assert_equals($this->browser->session->trace[0]["args"], "test_url");
	}
	
	public function test_new_session()
	{
		$old_session = $this->browser->session;
		$this->browser->new_session();
		
		$this->assert_equals($old_session->trace[0]["method"], "close");
		$this->assert_equals($this->web_driver->trace[1]["method"], "session");
	}
	
	public function test_element_existant()
	{
		$element = $this->browser->element('existant_element');
		
		$this->assert_equals($this->browser->session->trace[0]['args'], array('css selector', 'existant_element'));
		$this->assert_true($element instanceof WebDriverElement);
	}
	
	public function test_element_non_existant()
	{
		$exception_thrown = false;
		try 
		{
			$this->browser->element('non_existant_element', 'css selector', 10);
		}
		catch(Exception $exception){
			$exception_thrown = true;
		}
		
		$this->assert_true($exception_thrown);
	}
	
	public function test_element_max_waiting_time()
	{
		$element = $this->browser->element("existant_element_waiting");
		$this->assert_true($element instanceof WebDriverElement);
	}
	
	public function test_elements()
	{
		$elements = $this->browser->elements('existant_element');
		$this->assert_true($elements[0] instanceof WebDriverElement);
	}
	
	public function test_elements_non_existant()
	{
		$exception_thrown = false;
		try 
		{
			$this->browser->elements('non_existant_element', 'css selector', 10);
		}
		catch(Exception $exception){
			$exception_thrown = true;
		}
		
		$this->assert_true($exception_thrown);
	}
	
	public function test_elements_max_waitintg_time()
	{
		$elements = $this->browser->elements('existant_element_waiting');
		$this->assert_true($elements[0] instanceof WebDriverElement);
	}
	
	public function test_focus_window()
	{
		$this->browser->to_window(1);
		$this->assert_equals($this->browser->session->trace[0]["method"], "window_handles");
		$this->assert_equals($this->browser->session->trace[1]["method"], "focusWindow");
		$this->assert_equals($this->browser->session->trace[1]["args"], $this->browser->session->window_handles[1]);
	}
	
	public function test_focus_frame()
	{
		$this->browser->to_frame(1);
		$this->assert_equals($this->browser->session->trace[0]["method"], "frame");
		$this->assert_equals($this->browser->session->trace[0]["args"], array("id" => 1));
	}
	
	public function test_focus_main_frame()
	{
		$this->browser->to_main_frame();
		$this->assert_equals($this->browser->session->trace[0]["method"], "frame");
		$this->assert_equals($this->browser->session->trace[0]["args"], array("id" => null));
	}
}