<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nCreating Users";
echo "\n---------------\n";

$num_students = (!empty($totalstudents)) ? $totalstudents:STUDENTS_TOTAL;

for ($i = 1; $i <= $num_students; $i++) {

    $eid = STUDENT_BASE_EID . $i;
    $firstname = STUDENT_BASE_FIRST_NAME . $i;
    $lastname = STUDENT_BASE_LAST_NAME . $i;
    //$email = $eid . EMAIL_BASE;
    $email = "";
    $type = STUDENT_TYPE;
    $password = (!empty($studentpwd)) ? $studentpwd:STUDENT_PASSWORD;

    $response = $soap_sakai_script->addNewUser($sessionid, $eid, $firstname, $lastname, $email, $type, $password);

    echo "$eid\n";

}

echo "\n";

?>