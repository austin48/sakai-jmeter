<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nDeleting Users";
echo "\n--------------\n";

$num_students = (!empty($totalstudents)) ? $totalstudents:STUDENTS_TOTAL;

for ($i = 1; $i <= $num_students; $i++) {

    $eid = STUDENT_BASE_EID . $i;

    $response = $soap_sakai_script->removeUser($sessionid, $eid);

    echo "$eid - $response\n";

}

echo "\n";

?>