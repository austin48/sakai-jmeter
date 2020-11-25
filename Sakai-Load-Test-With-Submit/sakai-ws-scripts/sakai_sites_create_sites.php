<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nCreating Sites";
echo "\n--------------\n";

$sites_file = $JMETER_SITES_FILE;
$results = `rm $sites_file`;

$num_sites = (!empty($totalsites)) ? $totalsites:SITES_TOTAL;

for ($i = 1; $i <= $num_sites; $i++) {

    $siteidtocopy = TEMPLATE_SITE_ID;
    $siteid = BASE_SITE_ID . $i . "_". rand(100000, 999999);
    $title = $siteid;
    $description = "";
    $shortdesc = "";
    $iconurl = "";
    $infourl = "";
    $joinable = false;
    $joinerrole = "";
    $published = true;
    $publicview = false;
    $skin = "";
    $type = SITE_TYPE;

    $response = $soap_sakai_script->addNewSite($sessionid, $siteid, $title, $description, $shortdesc, $iconurl, $infourl, $joinable, $joinerrole, $published, $publicview, $skin, $type);

    echo "$siteid - $response\n";

    $results = `echo $siteid >> $sites_file`;

}

echo "\n";

?>
