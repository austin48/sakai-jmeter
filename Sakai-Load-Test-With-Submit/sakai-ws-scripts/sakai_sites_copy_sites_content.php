<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nCopying Site Content From Template: " . TEMPLATE_SITE_ID;
echo "\n---------------------------------------------------\n";

$file_lines = file($JMETER_SITES_FILE);
foreach ($file_lines as $line) {

    $sourcesiteid = TEMPLATE_SITE_ID;
    $destinationsiteid = trim($line);
    $title = $destinationsiteid;

    $response = $soap_sakai_script->copySiteContent($sessionid, $sourcesiteid, $destinationsiteid);

    echo "$sourcesiteid contents copied to $destinationsiteid - $response\n";

}

echo "\n";

?>
