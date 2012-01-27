<?php
class TestTestRunner extends TestCase 
{
	function test_handles_test_case_collection()
	{
		$runner = new UnabstractTestRunner();
		$runner->add_test_case(new TestingTestCase());
		
		$result = $runner->get_test_cases();
		$expected = array("TestingTestCase" => new TestingTestCase());
		
		$this->assert_equals($expected, $result);
	}
	
	function test_runs_test_cases_and_keeps_results()
	{
		$runner = new UnabstractTestRunner();
		$runner->add_test_case(new TestingTestCase());
		$runner->run();
		
		$result = $runner->get_results();
		$this->assert_true($result["TestingTestCase"]["test_one"] instanceof TestResult);
	}
}