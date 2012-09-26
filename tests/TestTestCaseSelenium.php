<?php
class TestTestCaseSelenium extends TestCase
{
	public function test_test_case_selenium_extends_test_case()
	{
		$webdriver = new TestingWebDriver();
		$test_case_selenium = new TestCaseSelenium($webdriver);
		$this->assert_true($test_case_selenium instanceof TestCase);
	}
	
	public function test_construct_gets_new_session_and_saves_to_this_browser()
	{
		$webdriver = new TestingWebDriver();
		$test_case_selenium = new TestCaseSelenium($webdriver);
		
		$this->assert_equals($webdriver->trace['session'], 'firefox');
		$this->assert_equals($test_case_selenium->browser, "browser");
	}
}