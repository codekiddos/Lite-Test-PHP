<?php
class TestRunnerHTML extends TestRunner 
{
	protected $total_results = 0;
	protected $total_failed = 0;
	protected $total_assertions = 0;
	
	public function get_output()
	{
		$output = "";
		foreach($this->get_results() as $case_name => $test_results)
		{
			$output .= $this->get_case_results($case_name, $test_results);
		}
		
		return $this->summary().$output;
	}
	
	protected function summary()
	{
		$result = "<div class='summary'>";
		$result .= "Cases: " . sizeof($this->test_cases) . "  ";
		$result .= "Passed tests: " . ($this->total_results + $this->total_failed) ."  ";
		$result .= "Failed tests: " . $this->total_failed ."  ";
		$result .= "Total assertions: " . $this->total_assertions;
		$result .= "</div>\n";
		
		return $result;
	}
	
	protected function get_case_results($case_name, $test_results)
	{
		$output  = "<h1>$case_name</h1>\n";
		$output .= "<ul>\n";
		
		$case_result = true;
		foreach($test_results as $one_result)
		{
			$this->total_assertions += $one_result->count_assertions();
			
			if($one_result->passed())
			{
				$this->total_results++;
				$output .= $this->get_test_pass($one_result);
			}
			else
			{
				$this->total_failed++;
				$output .= $this->get_test_fail($one_result);
				$case_result = false;
			}
		}
		
		$output .= "</ul>\n";
		
		return $this->wrap_case($case_result, $output);
	}
	
	protected function wrap_case($case_result, $output)
	{
		$class = "pass";
		
		if(!$case_result)
			$class = "fail";
			
		return "<div class='$class'>\n$output</div>";
	}
	
	protected function get_test_pass(TestResult $result)
	{
		$output  = "<li class='pass'>\n<span class='pass'>".self::PASS."</span>\n";
		$output .= "<span class='test_name'>{$result->get_name()}</span>\n</li>\n";
		
		return $output;
	}
	
	protected function get_test_fail(TestResult $result)
	{
		$exception = $result->get_exception();
		
		$output  = "<li class='fail'>\n<span class='fail'>".self::FAIL."</span>\n";
		$output .= "<span class='test_name'>{$result->get_name()} line {$result->get_error_line()}</span>\n";
		$output .= "<pre class='message'>{$exception->getMessage()}</pre>\n";
		$output .= "<pre class='stack_trace'>{$exception->getTraceAsString()}</pre>\n</li>\n";
		
		return $output;
	}
}