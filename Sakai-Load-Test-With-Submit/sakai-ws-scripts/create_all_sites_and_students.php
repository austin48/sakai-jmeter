<?php

require_once "init.php";

$publishsamigo = false;

foreach ($argv as $arg) {
    $key_val = explode("=", $arg);
    //print_r($key_val);
    if (count($key_val) == 2) {
        if (strtolower(trim($key_val[0], "-")) == "protocol") { $protocol = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "servername") { $serverName = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "port") { $port = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "portdelimiter") { $portDelimiter = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "requestdelay") { $requestDelay = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "sitesfile") { $sitesFile = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "resultspath") { $resultsPath = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "resultsfilename") { $resultsFileName = trim($key_val[1]); }

        if (strtolower(trim($key_val[0], "-")) ==  "studentpwd") { $studentpwd = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "adminusername") { $adminusername = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "adminpassword") { $adminpassword = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "totalstudents") { $totalstudents = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "totalsites") { $totalsites = trim($key_val[1]); }
        if (strtolower(trim($key_val[0], "-")) ==  "studentspersite") { $studentspersite = trim($key_val[1]); }

        if (strtolower(trim($key_val[0], "-") ==  "publishsamigo")) { $publishsamigo = trim($key_val[1]); }

    }
}
// echo "protocol: $protocol\n";
// echo "serverName: $serverName\n";
// echo "port: $port\n";
// echo "portDelimiter: $portDelimiter\n";
// echo "sitesFile: $sitesFile\n";
// echo "requestDelay: $requestDelay\n";
// echo "resultsPath: $resultsPath\n";
// echo "resultsFileName: $resultsFileName\n";
// echo "studentpwd: $studentpwd\n";
// echo "adminusername: $adminusername\n";
// echo "adminpassword: $adminpassword\n";
// echo "totalstudents: $totalstudents\n";
// echo "totalsites: $totalsites\n";
// echo "studentspersite: $studentspersite\n";
// echo "publishsamigo: $publishsamigo\n";

if (COPY_SITE_TEMPLATE) {
    include_once "sakai_sites_copy_sites.php";
    include_once "sakai_sites_copy_sites_content.php";
} else {
    include_once "sakai_sites_create_sites.php";
}

include_once "sakai_sites_add_tools.php";

include_once "sakai_sites_assignment_create.php";

if (!COPY_SITE_TEMPLATE) {
    include_once "sakai-ws-scripts/sakai_sites_samigo_create.php";
}

include_once "sakai_students_create.php";
include_once "sakai_sites_add_members.php";

// publish samigo quizzes
if ($publishsamigo) {

    $protocol_string =        (!empty($protocol))        ? " -Jprotocol=$protocol":"";
    $serverName_string =      (!empty($serverName))      ? " -JserverName=$serverName":"";
    $port_string =            (!empty($port))            ? " -Jport=$port":"";
    $portDelimiter_string =   (!empty($portDelimiter))   ? " -JportDelimiter=$portDelimiter":"";
    $requestDelay_string =    (!empty($requestDelay))    ? " -JrequestDelay=$requestDelay":"";
    $sitesFile_string =       (!empty($sitesFile))       ? " -JsitesFile=$sitesFile":"-JsitesFile=$JMETER_SITES_FILE";
    $resultsPath_string =     (!empty($resultsPath))     ? " -JresultsPath=$resultsPath":"";
    $resultsFileName_string = (!empty($resultsFileName)) ? " -JresultsFileName=$resultsFileName":"";

    $admin_username_string = (!empty($adminusername)) ? " -Jadminusername=$adminusername":"";
    $admin_password_string = (!empty($adminpassword)) ? " -Jadminpassword=$adminpassword":"";
    $number_sites_string =   (!empty($totalsites))    ? " -JnumberOfSites=$totalsites":"-JnumberOfSites=" . SITES_TOTAL;

    $cmd_string = "cd " . $JMETER_RUN_PATH . "; " . $JMETER_PATH . " -n -t " . $JMETER_SAMIGO_PUBLISH_PATH .
                  "$protocol_string $serverName_string $port_string $portDelimiter_string $sitesFile_string $resultsPath_string $resultsFileName_string" .
                  "$admin_username_string $admin_password_string $requestDelay_string $number_sites_string";
    echo "$cmd_string\n";
    echo "\nPublishing Samigo Quizzes...\n\n";
    $result = `$cmd_string`;

    echo $result;

}

?>