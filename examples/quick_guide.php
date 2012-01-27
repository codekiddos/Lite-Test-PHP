<?php
// 1. Include Lite Test PHP
require_once dirname(__FILE__)."/../LiteTestPHP.php";


// 2. Create a TestCase and add some tests. Test functions must have a test_ prefix
class TestCaseMyClass extends TestCase
{
	function test_my_class()
	{
		$my_class = new MyClass();
		$this->assert_true($my_class instanceof MyClass);
	}
}


// 3. Choose a TestRunner and add your TestCase (CLI runner in this case)
$runner = new TestRunnerCLI();
$runner->add_test_case(new TestCaseMyClass());


// 4. Run your tests
$runner->print_results();


class MyClass
{

}