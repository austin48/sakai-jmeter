<?php 

require_once 'init.php';

$wsdl_sakai_script = new SoapClient($wsdl_path . 'sakai' . $wsdl_ext, array('exceptions' => 0));
list($soap_sakai_script, $sessionid) = [$wsdl_sakai_script, $sessionid];


echo "\nAdd Tools to Site";
echo "\n-----------------\n";

$file_lines = file($JMETER_SITES_FILE);
foreach ($file_lines as $line) {

    $siteid = trim($line);

    if (!COPY_SITE_TEMPLATE) {
        // overview page and tool
        $response = $soap_sakai_script->addNewPageToSite($sessionid, $siteid, "Overview", 1);
        $response = $soap_sakai_script->addConfigPropertyToPage($sessionid, $siteid, "Overview", "is_home_page", "true");

        $response = $soap_sakai_script->addNewToolToPage($sessionid, $siteid, "Overview", "Site Information Display", "sakai.iframe.site", "0,0");
        echo "$siteid - $response - sakai.iframe.site\n";
        $response = $soap_sakai_script->addConfigPropertyToTool($sessionid, $siteid, "Overview", "Worksite Information", "special", "worksite");
        $response = $soap_sakai_script->addNewToolToPage($sessionid, $siteid, "Overview", "Recent Announcements", "sakai.synoptic.announcement", "0,1");
        $response = $soap_sakai_script->addNewToolToPage($sessionid, $siteid, "Overview", "Calendar", "sakai.summary.calendar", "1,1");

        add_tool_and_page($sessionid, $siteid, "sakai.siteinfo", null, null, 0, 99, 0);
        add_tool_and_page($sessionid, $siteid, "sakai.samigo", null, null, 0, 99, 0);
    }

    // other tools
    add_tool_and_page($sessionid, $siteid, "sakai.assignment.grades", null, null, 0, 99, 0);
    add_tool_and_page($sessionid, $siteid, "sakai.forums", null, null, 0, 99, 0);


}

echo "\n";

function add_tool_and_page($sessionid, $siteid, $toolid, $pagetitle, $tooltitle, $pagelayout, $position, $popup) {

    global $soap_sakai_script;

    $response = $soap_sakai_script->addToolAndPageToSite($sessionid, $siteid, $toolid, $pagetitle, $tooltitle, $pagelayout, $position, $popup);

    echo "$siteid - $response - $toolid\n";

}

?>
