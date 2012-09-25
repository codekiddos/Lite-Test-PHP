<?php
class TestRunnerCLI extends TestRunner 
{
	const RED_TEXT = "\x1b[0;31m";
	const GREEN_TEXT = "\x1b[0;32m";
	const WHITE_TEXT = "\x1b[m";
	
	protected $total_results = 0;
	protected $total_failed = 0;
	protected $total_assertions = 0;
	protected $tests_running_time = 0;
	
	public $time_precision = 6;
	
	public function __construct($test_case = null)
	{
		if(!empty($test_case) && ($test_case instanceof TestCase))
		{
			$this->add_test_case($test_case);
			$this->print_results();
		}
	}
	
	public function print_results()
	{
		system("clear");
		
		$this->run();
		
		foreach($this->get_results() as $case_name => $test_results)
		{
			$this->print_case_results($case_name, $test_results);
		}
		
		$this->print_summary();
	}
	
	protected function print_summary()
	{
		echo "\n\n";
		echo "Cases: " . sizeof($this->test_cases) . "  ";
		echo "Passed tests: " . ($this->total_results + $this->total_failed) ."  ";
		echo "Failed tests: " . $this->total_failed ."  ";
		echo "Total assertions: " . $this->total_assertions ."  ";
		echo "Running time: " . $this->format_time($this->tests_running_time) . " ms";
		echo "\n\n";
	}
	
	protected function print_case_results($case_name, $test_results)
	{
		foreach($test_results as $one_result)
		{
			$this->total_assertions += $one_result->count_assertions();
			
			if($one_result->passed())
			{
				$this->total_results++;
				$this->print_test_pass($one_result);
			}
			else
			{
				$this->total_failed++;
				$this->print_test_fail($one_result);
			}
		}
	}

	protected function print_test_pass(TestResult $result)
	{
		$case_name = $result->get_testcase();
		$running_time = $this->format_time($result->get_running_time());

		echo "\n[".self::GREEN_TEXT.self::PASS.self::WHITE_TEXT."] [{$running_time} ms] [$case_name] {$result->get_name()}";
	}
	
	protected function print_test_fail(TestResult $result)
	{
		$case_name = $result->get_testcase();
		$running_time = $this->format_time($result->get_running_time());
		$exception = $result->get_exception();
		$line = $result->get_error_line();

		echo "\n[".self::RED_TEXT.self::FAIL.self::WHITE_TEXT."] [{$running_time} ms] [$case_name] "
			.self::RED_TEXT."{$result->get_name()}".self::WHITE_TEXT." line {$result->get_error_line()}\n\n";
		echo $exception->getMessage()."\n";
		echo $exception->getTraceAsString()."\n\n";
	}
	
	protected function format_time($time)
	{
		return number_format($time, $this->time_precision);
	}
}