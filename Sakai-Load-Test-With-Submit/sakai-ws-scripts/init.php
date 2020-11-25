<?php

error_reporting(E_ALL);

ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
ini_set("soap.wsdl_cache_enabled", "0");

date_default_timezone_set('Pacific/Honolulu');


$JMETER_PATH  = "<path-to-jmeter>/jmeter";
$JMETER_RUN_PATH = "<directory-to-run-jmeter-from>";
$JMETER_SITES_FILE = "<path-to>/sites.csv";
$JMETER_SAMIGO_PUBLISH_PATH = "<path-to-jmx-scripts>/Sakai-Load-Test-With-Submit/Sakai-Load-Test-Publish-Samigo.jmx";

$host = "<sakai-url>";
$user = "<admin-login>";
$pass = "<admin-password>";

const STUDENTS_TOTAL = 500;
const SITES_TOTAL = 20;
const STUDENTS_PER_SITE = 25;

const STUDENT_BASE_EID = "jmeterstudent";
const STUDENT_BASE_FIRST_NAME = "Student";
const STUDENT_BASE_LAST_NAME = "JMeter";
const EMAIL_BASE = "";
const STUDENT_TYPE = "Student";
const STUDENT_PASSWORD = "";

const COPY_SITE_TEMPLATE = true;
const TEMPLATE_SITE_ID = "JMETER_COURSE_TEMPLATE";
const BASE_SITE_ID = "JMETER_COURSE_";
const BASE_SITE_TITLE = "JMETER_COURSE_";
const SITE_TYPE = "course";

const STUDENT_ROLE_ID = "Student";


// connect to Sakai Web Services
if (!empty($user) && !empty($pass)) {
    $wsdl_path = $host .'/sakai-ws/soap/' ;
    $wsdl_ext = '?wsdl';

    $wsdl_login = new SoapClient($wsdl_path . "login" . $wsdl_ext, array('exceptions' => 0));

    $sessionid = sakai_soap_connect($user, $pass, $wsdl_login);
    $sessionid = $login->login($user, $pass);

    // print_r($sessionid);
    // echo "\n";
 
    if (is_soap_fault($sessionid)) {
        echo("SOAP Fault: (faultcode: {$sessionid ->faultcode}, faultstring: {$sessionid ->faultstring})");
        exit(1);
    }

} else {
    die("\n\nERROR: credentials not provided\n\n");
}

?>