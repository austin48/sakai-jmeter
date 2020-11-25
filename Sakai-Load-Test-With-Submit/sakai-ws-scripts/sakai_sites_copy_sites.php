<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nCopying Sites From Template: " . TEMPLATE_SITE_ID;
echo "\n---------------------------------------------\n";

$sites_file = $JMETER_SITES_FILE;
$results = `rm $sites_file`;

$num_sites = (!empty($totalsites)) ? $totalsites:SITES_TOTAL;

for ($i = 1; $i <= $num_sites; $i++) {

    $siteidtocopy = TEMPLATE_SITE_ID;
    $newsiteid = BASE_SITE_ID . $i . "_". rand(100000, 999999);
    $title = $newsiteid;
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

    $response = $soap_sakai_script->copySite($sessionid, $siteidtocopy, $newsiteid, $title, $description, $shortdesc, $iconurl, $infourl, $joinable, $joinerrole, $published, $publicview, $skin, $type);

    echo "$newsiteid - $response\n";

    $results = `echo $newsiteid >> $sites_file`;

}

echo "\n";

?>
