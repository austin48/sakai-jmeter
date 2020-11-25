<?php

foreach ($argv as $arg) {
    $key_val = explode("=", $arg);
    //print_r($key_val);
    if (count($key_val) == 2) {
        if (strtolower(trim($key_val[0], "-") ==  "totalstudents")) { $totalstudents = trim($key_val[1]); }
    }
}

//echo "totalstudents: $totalstudents\n";

include_once "sakai_sites_delete_sites.php";
include_once "sakai_students_delete.php";

?>