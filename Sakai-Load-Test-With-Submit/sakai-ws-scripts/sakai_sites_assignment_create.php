<?php 

require_once 'init.php';

$wsdl_assignments_script = new SoapClient($wsdl_path . 'assignments' . $wsdl_ext, array('exceptions' => 0));
list($soap_assignments_script, $sessionid) = [$wsdl_assignments_script, $sessionid];

echo "\nCreating Assignments";
echo "\n--------------------\n";

$file_lines = file($JMETER_SITES_FILE);
foreach ($file_lines as $line) {

    $context = trim($line);
    $title = "Assignment 1";
    $dueTime = strtotime("31 December 2050") * 1000;
    $openTime = time();
    $closeTime = $dueTime;
    $maxPoints = 1;
    $gradeType = 1;
    $instructions = "What did you learn today?";
    $subType = 1;

    $response = $soap_assignments_script->createAssignment($sessionid, $context, $title, $dueTime, $openTime, $closeTime, $maxPoints, $gradeType, $instructions, $subType);

    echo "$context - $title - assignment created - $response\n";

}

echo "\n";

?>
