<?php
class TestTestCase extends TestCase 
{	
	function test_pass()
	{
		$test_case = new TestingTestCase();
		$test_case->temporal_result = new TestResult("some test");
		
		$this->assert_true($test_case->pass());
		$this->assert_equals(1, $test_case->temporal_result->count_assertions());
	}
	
	function test_fail()
	{
		$test_case = new TestingTestCase();
		$test_case->temporal_result = new TestResult("some test");
		
		$this->assert_false($test_case->fail("Failure message"));
		$this->assert_equals(1, $test_case->temporal_result->count_assertions());
		
		$this->assert_equals("Failure message", $test_case->temporal_result->get_exception()->getMessage());
	}
	
	function test_assert_true()
	{
		$test_case = new TestingTestCase();
		$test_case->temporal_result = new TestResult("some test");
		
		$this->assert_true($test_case->assert_true(true));
		
		$this->assert_false($test_case->assert_true(false));
		$expected = "Failed asserting true for bool(false)\n";
		$this->assert_equals($expected, $test_case->temporal_result->get_exception()->getMessage());
	}
	
	function test_assert_false()
	{
		$test_case = new TestingTestCase();
		$test_case->temporal_result = new TestResult("some test");
		
		$this->assert_true($test_case->assert_false(false));
		
		$this->assert_false($test_case->assert_false(true));
		$expected = "Failed asserting false for bool(true)\n";
		$this->assert_equals($expected, $test_case->temporal_result->get_exception()->getMessage());
	}
	
	function test_assert_equals()
	{
		$test_case = new TestingTestCase();
		$test_case->temporal_result = new TestResult("some test");
		
		$this->assert_true($test_case->assert_equals("value", "value"));
		
		$this->assert_false($test_case->assert_equals("value 1", "value 2"));
		$expected = "Failed asserting that expected:\nstring(7) "
					."\"value 1\"\n\nequals given:\nstring(7) \"value 2\"\n";
		$this->assert_equals($expected, $test_case->temporal_result->get_exception()->getMessage());
		
		$this->assert_false($test_case->assert_equals(true, 2));
	}
	
	function test_exception_testing()
	{
		try 
		{
			throw new Exception("some exception");
			$this->fail("Expected exception not thrown\n");
		}
		catch (Exception $exception)
		{
			if($exception->getMessage() != "some exception")
				$this->fail("Expected exception not thrown\n");

			$this->pass();
		}
	}
	
	function test_test_list()
	{
		$test_case = new TestingTestCase();
		
		$test_list = $test_case->get_tests();
		$expected = array("test_one", "test_two");
		$this->assert_equals($expected, $test_list);
	}
	
	function test_run()
	{
		$test_case = new TestingTestCase();
		
		$results = $test_case->run("TestingTestCase");
	
		$this->assert_true(is_array($results));
		$this->assert_equals("TestResult", get_class($results["test_one"]));
		$this->assert_equals("TestResult", get_class($results["test_two"]));
		$this->assert_equals("test_one", $results["test_one"]->get_name());
		$this->assert_equals(2, $results["test_one"]->count_assertions());
		$this->assert_equals(9, $results["test_one"]->get_error_line());
		$this->assert_true($results["test_one"]->get_running_time() > 0);
 		$this->assert_true($results["test_two"]->get_running_time() > 0);
	}
	
	function test_befor_each()
	{
		$test_case = new TestingTestCase();
		$test_case->run("TestingTestCase");
		$this->assert_equals(2, $test_case->before_each_call_count);
	}
	
	function test_after_each()
	{
		$test_case = new TestingTestCase();
		$test_case->run("TestingTestCase");
		$this->assert_equals(2, $test_case->after_each_call_count);
	}
}