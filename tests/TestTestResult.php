<?php
class TestTestResult extends TestCase 
{
	function test_initialize()
	{
		$test_result = new TestResult("test name");
		$this->assert_equals("test name",  $test_result->get_name());
	}
	
	function test_assertions()
	{
		$test_result = new TestResult("test name");
		
		$test_result->add_assertion(true);
		$test_result->add_assertion(true);
		$this->assert_equals(2, $test_result->count_assertions());
		$this->assert_true($test_result->passed());
		
		$test_result->add_assertion(false, new Exception("Yet some other message"));
		$this->assert_equals(3, $test_result->count_assertions());
		$this->assert_false($test_result->passed());
		$this->assert_true($test_result->get_exception() instanceof Exception);
	}
}