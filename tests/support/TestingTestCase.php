<?php
class TestingTestCase extends TestCase
{
	public $temporal_result;
	
	public function test_one()
	{
		$this->assert_true(true);
		$this->assert_true(false);
	}
	
	public function test_two()
	{
		$this->assert_true(true);
	}
	
	public $before_each_call_count = 0;
	public $after_each_call_count = 0;
	
	public function before_each()
	{
		$this->before_each_call_count++;
	}

	public function after_each()
	{
		$this->after_each_call_count++;
	}
}