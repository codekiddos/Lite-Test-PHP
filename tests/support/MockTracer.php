<?php
class MockTracer
{
	public $trace = array();
	
	protected function add_trace($method, $args = null)
	{
		$this->trace[] = array("method" => $method, "args" => $args);
	}
}