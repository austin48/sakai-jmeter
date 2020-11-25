<?php 

require_once 'init.php';

$wsdl_testsandquizzes_script = new SoapClient($wsdl_path . 'testsandquizzes' . $wsdl_ext, array('exceptions' => 0));
list($soap_testsandquizzes_script, $sessionid) = [$wsdl_testsandquizzes_script, $sessionid];


echo "\nCreating Samigo assessments";
echo "\n---------------------------\n";

$file_lines = file($JMETER_SITES_FILE);

foreach ($file_lines as $line) {

    $siteid = trim($line);
    $site_title = $siteid;
    $siteproperty = "";
    $xmlfile = __DIR__ . "/exported-assessment.xml";
    $xmlstring = file_get_contents($xmlfile);
    // echo $xmlstring;

//    $response = $soap_testsandquizzes_script->createAssessmentFromExport($sessionid, $siteid, $siteproperty, $xmlstring);
    $response = $soap_testsandquizzes_script->createAssessmentFromExportFile($sessionid, $siteid, $siteproperty, $xmlfile);

    echo "$siteid - $site_title - quiz created - $response\n";

}

echo "\n";

?>
