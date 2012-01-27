# Lite Test PHP

## Quick guide

	// 1. Include Lite Test PHP
	
	require_once "path_to_lite_test/LiteTest.php";
	
	
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
Will output:

![LiteTestPHP CLI example output](https://github.com/codekiddos/Lite-Test-PHP/raw/master/doc/images/LiteTestPHP_example_output.png)

## Extended documentation

> Whenever you are tempted to type something into a print statement or a debugger expression, write it as a test instead.
> 
> Martin Fowler

We believe in keeping things simple (KISS). While acknowledging (and used during years) with some great unit testing frameworks such as PHPUnit, we've decided to develop a super light weight unit testing framework.

We keep these basics in mind:

* Three assertion types should be more than enough (true, false and equals).
* Avoid coupling. It should run anywhere.
* Avoid complex setup.
* Quick learning curve.
* The faster the better.
* The less code the better.
* If you really need advanced testing options such as mocks, stubs or database testing, build them yourself by extending the classes you're testing.
* The best way to test databases is to create a testing database with fixture data. Seriously.
* Keep your tests along with the code they test.
* If you really need to test controllers (other than smoke test), move your code to domain objects easier to test and/or use CURL!

## Creating tests

Usually you want to put your tests along with the code they test. The best way to do this without polluting your package with lots of test files is placing all tests inside a 'tests' folder. Your package should look something similar to this:

	package/
	package/classes/SomeClass.php
	package/tests/TestSomeClass.php
	package/IncludeFile.php

To create a test we have to extend the abstract class TestCase. Test names begin with the prefix 'test_'.

	class TestSomeClass extends TestCase
	{
		function test_some_behaviour()
		{
			//Your testing code goes here
		}
	}

*Important!* Functions lacking the prefix 'test_' won't be executed as a test! I know it sounds obvious but next time you struggle during 10 minutes wondering why your test is not being executed remember this! =)

## Assertions
As stated, you count with three assertion types to do it all. And you can actually do it all with only these three (even with one of them):

	assert_true($prove);

	assert_false($prove);

	assert_equals($expected, $prove);

Following the previous code:

	class TestSomeClass extends TestCase
	{
		function test_some_behaviour()
		{
			$this->assert_true(true);
		}
	}

Additionally you can count on this two functions to force fail or assert:

	class TestSomeClass extends TestCase
	{
		function test_some_behaviour()
		{
			$this->fail("Some message");
			$this->pass(); //Will simply pass
		}
	}
	
## Testing exceptions
Automated exception testing is difficult to implement in testing frameworks due to the nature of the exceptions, they halt the program execution unless you catch them *in situ*. So this is the best solution in my opinion:

	try
	{
		// Excute whatever code you expect to throw a exception
		// If the exception is not thrown, force fail
		whatever_code();
		$this->fail("Failed to catch exception X");
	}
	catch(Exception $exception)
	{
		// Check if is the exception you were expecting
		if($exception->getCode() == my_code)
			$this->pass();
	}

## Running tests
You need to include the LiteTestPHP package in your tests to be able to run tests. Also you'll need to provide a TestRunner to get some nice output. Our recommendation is to create a *run.php* with the following content:

	require_once PATH_TO_LITE_TEST_PHP."LiteTestPHP.php";

	require_once dirname(__FILE__)."/TestSomeClass.php"; // You should be within tests directory

	$test_runner = new TestRunnerCLI();

	$test_runner->add_test_case(new TestSomeClass());

	$test_runner->print_results();

In this case we're using the command line interface (CLI) TestRunner which will print out a plain result. Something like this:

	$ php run.php
	
	[PASS] [TestCaseTesting] test_one
	[FAIL] [TestCaseTesting] test_two
	Failed asserting true for bool(false)

	[Stack trace...]

The CLI runner has a shortcut for running a single TestCase. This will execute and print the results on the screen:

	new TestRunnerCLI(new TestCase());

## Some advice on testing

You don't really need to test every function of your application, rather that a function or a set of functions are behaving as expected.

Tests should run as quick as a lighting. You need to run them over and over every few seconds or minutes. You can't waste time on a test battery that takes more than 2 or 3 seconds to run (at most!). If you're facing this situation, either recode your tests or break down your battery into smaller pieces grouped by similar functionality.

If you need to test abstract classes and/or private/protected methods: extend the class to a non abstract class and make a facade for the private/protected methods. As a way of evidencing your intent, a good name for the extended class could be UnabstractMyClass or ExtendedMyClass. Also, you should place the class within the tests directory, since is code created only for testing pourposes. I personally like to place all these files within a *support* folder inside *tests* folder.

	my_package/classes/MyAbstractClass.php
	my_package/tests/support/UnabstractMyAbstractClass.php

As for the code:

	abstract class MyAbstractClass
	{
		protected function protected_method($args)
		{
			//Code
		}
	
		private function private_method($args)
		{
			//Code
		}
	}


	class UnabstractMyAbstractClass extends MyAbstractClass
	{
		public function protected_method($args)
		{
			return parent::protected_method($args);
		}
	
		public function private_method($args)
		{
			return parent::private_method($args);
		}
	}

This way you can both instantiate and test your abstract class and your private/protected methods.

## Unit testing? Behaviour testing? Integration testing?

Rather go for *Common Sense Testing*. Don't write unnecessary tests, the less code the better, period. But don't leave untested code! Let's say you're testing this code:

	class MyClass
	{
		protected $name;
	
		public function __construct($name)
		{
			$this->set_name($name);
		}
	
		public function set_name($name)
		{
			$this->name = $name;
		}
	
		public function get_name()
		{
			return $this->name;
		}
	}

You could write this abomination:

	class TestCaseMyClass extends TestCase
	{
		function test_construct()
		{
			$my_class = new MyClass("some name");
		
			$this->assert_true($my_class instanceof MyClass);
		}
	
		function test_set_get_name()
		{
			$my_class = new MyClass("some name");
			$this->assert_equals("some name", $my_class->get_name());
		
			$my_class->set_name("another name");
			$this->assert_equals("another name", $my_class->get_name());
		}
	}

Or simply:

	class TestCaseMyClass extends TestCase
	{
		function test_construction()
		{
			$my_class = new MyClass("some name");
			$this->assert_equals("some name", $my_class->get_name());
		}
	}

You're testing exactly the same with less code and more Common Sense.

## Happy testing!

