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
	
	function test_error_line()
	{
		$test_result = new TestResult("test name");
		
		$test_result->set_error_line("some line");
		$this->assert_equals("some line", $test_result->get_error_line());
	}
	
	function test_running_time()
	{
		$test_result = new TestResult("test name");

		$test_result->set_running_time(0.2316759);
		$this->assert_equals(0.2316759, $test_result->get_running_time());
	}
	
	function test_testcase()
	{
		$test_result = new TestResult("test name");

		$test_result->set_testcase('My testcase');
		$this->assert_equals('My testcase', $test_result->get_testcase());
	}
}