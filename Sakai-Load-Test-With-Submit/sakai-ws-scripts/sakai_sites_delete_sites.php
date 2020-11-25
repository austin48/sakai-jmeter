<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nDeleting Sites";
echo "\n--------------\n";

$file_lines = file($JMETER_SITES_FILE);

foreach ($file_lines as $line) {

    $siteid = trim($line);

    $response = $soap_sakai_script->removeSite($sessionid, $siteid);    // soft delete
    $response = $soap_sakai_script->removeSite($sessionid, $siteid);    // hard delete

    echo "$siteid - $response\n";

}

echo "\n";

?>
