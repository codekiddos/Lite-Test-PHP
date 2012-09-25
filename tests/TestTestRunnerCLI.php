<?php
class TestTestRunnerCLI extends TestCase 
{	
	function test_prints_results()
	{
		$CLI_runner = new TestRunnerCLI();
		$CLI_runner->time_precision = 0;
		$CLI_runner->add_test_case(new TestingTestCase());

		ob_start();
		$CLI_runner->print_results();
		$result = ob_get_contents();
		ob_end_clean();

		$prove = explode("\n", $result);

		$clear_screen = urldecode("%1B%5BH%1B%5B2J");
		//$this->assert_equals($clear_screen, $prove[0]);

		$failed_test = "[\x1b[0;31mFAIL\x1b[m] [0 ms] [TestingTestCase] \x1b[0;31mtest_one\x1b[m line 9";
		$this->assert_equals($failed_test, $prove[1]);
		
		$passed_test = "\[\\x1b\[0;32mPASS\\x1b\[m\] \[0 ms\] \[TestingTestCase\] test_two";

		$this->assert_true(preg_match("/".$passed_test."/", $result) == 1);

		$summary = "Cases: 1  Passed tests: 2  Failed tests: 1  Total assertions: 3  Running time: 0 ms";
		
		$this->assert_true(preg_match("/".$summary."/", $result) == 1);
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