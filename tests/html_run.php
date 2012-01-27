<?php
require_once dirname(__FILE__)."/..".DIRECTORY_SEPARATOR."LiteTestPHP.php";

$test_runner = new TestRunnerHTML();

require_once dirname(__FILE__)."/battery.php";

$test_runner->run();
?>

<html>
<head>
<style type="text/css">
	* {font-size:13px; font-family: Symbol, sans-serif; margin:0; padding:0;}
	body { margin:5px;}
	ul { padding-left: 10px;}
	h1 {font-size:14px; clear:both; margin:0; padding:3px; line-height: 16px;}
	span.pass, span.fail {display:block; float:left; padding:3px; color:white; font-size:10px; line-height: 10px;}
	span.pass {background:green;}
	span.fail {background:red;}
	pre.message {float:left; clear:both; padding:5px; font-size:12px;}
	pre.stack_trace {float:left; clear:both; padding:5px; font-size:12px;}
	li { margin:0; padding:0; list-style:none; display:block; overlfow:hidden; clear:both; padding:1px;}
	ul { overflow:hidden; margin:0;}
	span.test_name {display:block; float:left; padding:3px 5px 3px 5px;}
	div.pass ul {display:none;}
	div.pass { border-left: 5px solid green; margin-bottom: 3px; padding-left:3px;}
	div.fail { border-left: 5px solid red; margin-bottom: 3px; padding-left:3px;}
	div.summary { font-size: 14px; margin-bottom: 14px; }
</style>
</head>
<body>

<?php echo $test_runner->get_output() ?>

</body>
</html>