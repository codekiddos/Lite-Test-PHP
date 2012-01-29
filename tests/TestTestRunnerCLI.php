<?php
class TestTestRunnerCLI extends TestCase 
{	
	function test_prints_results()
	{
		$CLI_runner = new TestRunnerCLI();
		$CLI_runner->add_test_case(new TestingTestCase());
		$CLI_runner->run();
		
		ob_start();
			$CLI_runner->print_results();
			$result = ob_get_contents();
		ob_end_clean();
		
		$prove = explode("\n", $result);
		
		$clear_screen = urldecode("%1B%5BH%1B%5B2J");
		$this->assert_equals($clear_screen, $prove[0]);
		
		$passed_test = "[\x1b[0;32mPASS\x1b[m] [TestingTestCase] test_one";
		$this->assert_equals($passed_test, $prove[1]);
		
		$failed_test = "[\x1b[0;31mFAIL\x1b[m] [TestingTestCase] \x1b[0;31mtest_two\x1b[m line 14";
		$this->assert_equals($failed_test, $prove[2]);
		
		$summary = "Cases: 1  Passed tests: 2  Failed tests: 1  Total assertions: 3";
		$this->assert_equals($summary, $prove[22]);
	}
	
	function test_if_case_provided_in_construct_autoruns()
	{
		ob_start();
			$CLI_runner = new TestRunnerCLI(new TestingTestCase());
			$result = ob_get_contents();
		ob_end_clean();
		
		
		$test_results = $CLI_runner->get_results();
		$this->assert_equals(2, sizeof($test_results["TestingTestCase"]));
	}
}