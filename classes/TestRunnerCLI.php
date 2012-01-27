<?php
class TestRunnerCLI extends TestRunner 
{
	const RED_TEXT = "\x1b[0;31m";
	const GREEN_TEXT = "\x1b[0;32m";
	const WHITE_TEXT = "\x1b[m";
	
	protected $total_results = 0;
	protected $total_failed = 0;
	protected $total_assertions = 0;
	
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
		echo "\n";
		echo "Cases: " . sizeof($this->test_cases) . "  ";
		echo "Passed tests: " . ($this->total_results + $this->total_failed) ."  ";
		echo "Failed tests: " . $this->total_failed ."  ";
		echo "Total assertions: " . $this->total_assertions;
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
				$this->print_test_pass($case_name, $one_result);
			}
			else
			{
				$this->total_failed++;
				$this->print_test_fail($case_name, $one_result);
			}
		}
	}
	
	protected function print_test_pass($case_name, TestResult $result)
	{
		echo "[".self::GREEN_TEXT.self::PASS.self::WHITE_TEXT."] [$case_name] {$result->get_name()}\n";
	}
	
	protected function print_test_fail($case_name, TestResult $result)
	{
		$exception = $result->get_exception();
		$trace = $exception->getTrace();
		$line = $trace[1]["line"];
		
		echo "[".self::RED_TEXT.self::FAIL.self::WHITE_TEXT."] [$case_name] ".self::RED_TEXT."{$result->get_name()}".self::WHITE_TEXT." line $line\n\n";
		echo $exception->getMessage()."\n";
		echo $exception->getTraceAsString()."\n\n";
	}
}