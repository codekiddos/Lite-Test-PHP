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

		$reg_expression = "/\[\\x1b\[0;32mPASS\\x1b\[m\][\s]\[TestingTestCase\][\s]test_one[\n]";
		$reg_expression .= "\[\\x1b\[0;31mFAIL\\x1b\[m\][\s]\[TestingTestCase\][\s]\\x1b\[0;31mtest_two\\x1b\[m[\s]line 14[\n]/";
		$matches = preg_match($reg_expression, $result);
		
		$this->assert_equals(1, $matches);
	}
	
	function test_if_case_provided_in_construct_autoruns()
	{
		ob_start();
			$CLI_runner = new TestRunnerCLI(new TestingTestCase());
			$result = ob_get_contents();
		ob_end_clean();
		
		$reg_expression = "/\[\\x1b\[0;32mPASS\\x1b\[m\][\s]\[TestingTestCase\][\s]test_one[\n]";
		$reg_expression .= "\[\\x1b\[0;31mFAIL\\x1b\[m\][\s]\[TestingTestCase\][\s]\\x1b\[0;31mtest_two\\x1b\[m[\s]line 14[\n]/";
		$matches = preg_match($reg_expression, $result);
		
		$this->assert_equals(1, $matches);
	}
	
	function test_summary()
	{
		ob_start();
			$CLI_runner = new TestRunnerCLI(new TestingTestCase());
			$result = ob_get_contents();
		ob_end_clean();
		
		$reg_expression = "/Cases:[\s]1[\s][\s]Passed tests:[\s]2[\s][\s]Failed tests:[\s]1[\s][\s]Total assertions:[\s]3[\n]$/";
		$matches = preg_match($reg_expression, $result);
		
		$this->assert_equals(1, $matches);
	}
}