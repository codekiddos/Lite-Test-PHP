<?php
require_once dirname(__FILE__)."/TestTestResult.php";
$test_runner->add_test_case(new TestTestResult());

require_once dirname(__FILE__)."/support/TestingTestCase.php";
require_once dirname(__FILE__)."/TestTestCase.php";
$test_runner->add_test_case(new TestTestCase());

require_once dirname(__FILE__)."/support/UnabstractTestRunner.php";
require_once dirname(__FILE__)."/TestTestRunner.php";
$test_runner->add_test_case(new TestTestRunner());

require_once dirname(__FILE__)."/TestTestRunnerCLI.php";
$test_runner->add_test_case(new TestTestRunnerCLI());

require_once dirname(__FILE__)."/TestTestRunnerHTML.php";
$test_runner->add_test_case(new TestTestRunnerHTML());