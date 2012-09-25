<?php
abstract class TestRunner
{
	public $test_cases = array();
	public $test_results = array();
	
	const PASS = "PASS";
	const FAIL = "FAIL";
	
	public function add_test_case(TestCase $test_case)
	{
		$test_name = get_class($test_case);
		$this->test_cases[$test_name] = $test_case;
	}
	
	public function get_test_cases()
	{
		return $this->test_cases;
	}
	
	public function run()
	{
		foreach($this->test_cases as $case_name => $case)
		{
			$this->test_results[$case_name] = $case->run($case_name);
		}
	}
	
	public function get_results()
	{
		return $this->test_results;
	}
}