<?php
$rURL = "https://www.iplocate.io/api/lookup/";

if ((isset($_GET["ip"])) && (filter_var($_GET["ip"], FILTER_VALIDATE_IP))) {
    if (!file_exists("./data/".md5($_GET["ip"]))) {
        $rData = json_decode(file_get_contents($rURL.$_GET["ip"]), True);
        if (($rData["org"]) OR ($rData["isp"])) {
            $rISP = Array("isp_info" => Array("description" => $rData["isp"] ? $rData["isp"] : $rData["org"], "type" => "Custom", "is_server" => false));
            file_put_contents("./data/".md5($_GET["ip"]), json_encode($rISP));
        }
    }
    if (file_exists("./data/".md5($_GET["ip"]))) {
        echo file_get_contents("./data/".md5($_GET["ip"]));
    }
}
?>