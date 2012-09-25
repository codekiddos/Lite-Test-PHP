<?php
class TestTestRunnerHTML extends TestCase 
{
	function test_outputs_html()
	{
		$HTML_runner = new TestRunnerHTML();
		$HTML_runner->add_test_case(new TestingTestCase());
		$HTML_runner->run("testingTestCase");
		
		$output = $HTML_runner->get_output();
		$prove = simplexml_load_string("<testing_wrapper>".$output."</testing_wrapper>");
		
		$this->assert_equals("Cases: 1  Passed tests: 2  Failed tests: 1  Total assertions: 3", $prove->div[0]);

		$this->assert_equals("fail", $prove->div[1]->attributes()->class);
		
		$this->assert_equals("fail", $prove->div[1]->ul->li[0]->attributes()->class);
		$this->assert_equals("fail", $prove->div[1]->ul->li[0]->span[0]->attributes()->class);
		$this->assert_equals("FAIL", $prove->div[1]->ul->li[0]->span[0]);
		$this->assert_equals("test_one line 9", $prove->div[1]->ul->li[0]->span[1]);
		
		
		$this->assert_equals("pass", $prove->div[1]->ul->li[1]->attributes()->class);
		$this->assert_equals("pass", $prove->div[1]->ul->li[1]->span[0]->attributes()->class);
		$this->assert_equals("PASS", $prove->div[1]->ul->li[1]->span[0]);
		$this->assert_equals("test_name", $prove->div[1]->ul->li[1]->span[1]->attributes()->class);
	}
}