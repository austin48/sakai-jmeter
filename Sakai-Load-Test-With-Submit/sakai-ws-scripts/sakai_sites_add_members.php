<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nAdding Members to Sites";
echo "\n-----------------------\n";

$j = 1;
$roleid = STUDENT_ROLE_ID;

$file_lines = file($JMETER_SITES_FILE);
foreach ($file_lines as $line) {

    $siteid = trim($line);
    $title = $siteid;

    $num_students = (!empty($totalstudents)) ? $totalstudents:STUDENTS_TOTAL;

    for ($j; $j <= $num_students; $j++) {

        $num_students_per_site = (!empty($studentspersite)) ? $studentspersite:STUDENTS_PER_SITE;

        for ($y = 0; $y < $num_students_per_site; $y++) {
            $eid = STUDENT_BASE_EID . $j++;
            $response = $soap_sakai_script->addMemberToSiteWithRole($sessionid, $siteid, $eid, $roleid);

            echo "$siteid - $eid - $response\n";
        }
        break;
    }

}

echo "\n";

?>
