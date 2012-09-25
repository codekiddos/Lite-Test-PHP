<?php
class TestTestCaseSelenium extends TestCase
{
	public function test_test_case_selenium_extends_test_case()
	{
		$test_case_selenium = new TestCaseSelenium();
		$this->assert_true($test_case_selenium instanceof TestCase);
	}
}