<?php
class WebDriverBrowser
{
	public $session;
	protected $web_driver;
	
	const DEFAULT_MAX_WAITING_TIME  = 10000;
	const DEFAULT_SELECTOR_TYPE = 'css selector';
	
	public function __construct(WebDriver $web_driver)
	{
		$this->session = $web_driver->session();
		$this->web_driver = $web_driver;
	}
	
	public function new_session()
	{
		$this->session->close();
		$this->session = $this->web_driver->session();
	}
	
	public function element($selector, $selector_type = self::DEFAULT_SELECTOR_TYPE, $max_waiting_time = self::DEFAULT_MAX_WAITING_TIME)
	{
		$this->wait_for_element($selector, $selector_type, $max_waiting_time);
		return $this->session->element($selector_type, $selector);
	}
	
	public function elements($selector, $selector_type = self::DEFAULT_SELECTOR_TYPE, $max_waiting_time = self::DEFAULT_MAX_WAITING_TIME)
	{
		$this->wait_for_element($selector, $selector_type, $max_waiting_time);
		return $this->session->elements($selector_type, $selector);

	}
	
	public function wait_for_element($selector, $selector_type = self::DEFAULT_SELECTOR_TYPE, $max_waiting_time = self::DEFAULT_MAX_WAITING_TIME)
	{
		$start_time = $this->get_miliseconds();

		while(true)
		{
			try
			{
				$this->session->element($selector_type, $selector);
			}
			catch(Exception $exception)
			{
				$now = $this->get_miliseconds();
				if(($now - $start_time) >= $max_waiting_time)
					throw $exception;
					
				continue;
			}
			break;
		}		
	}
	
	protected function get_miliseconds() 
	{
		return round(microtime(true) * 1000);
	}
	
	public function to_window($window_number)
	{
		$handles = $this->session->window_handles();
		$this->session->focusWindow($handles[$window_number]);
	}
	
	public function to_frame($frame)
	{
		$this->session->frame(array("id" => $frame));
	}
	
	public function to_main_frame()
	{
		$this->to_frame(null);
	}
	
	public function set_element_value($element, $value, $selector_type = self::DEFAULT_SELECTOR_TYPE)
	{
		if(!$element instanceof WebDriverElement)
			$element = $this->element($element, $selector_type);
		
		$element->value($this->split_string($value));
		
		return $element;
	}
	
	protected function split_string($string)
	{
	   return array("value" => preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY));
	}
	
	public function __call($method, $arguments)
	{
		call_user_func_array(array($this->session, $method), $arguments);
	}
}