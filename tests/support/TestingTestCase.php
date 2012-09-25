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
}