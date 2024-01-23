<?php

/*
 * file.php
 * file.php?limit=50
 * file.php?offset=7
 * file.php?search=<in id>
 * file.php?search=<in id>&criteria=id
 * file.php?search=<in de_de>&criteria=de
 */

header("Content-Type: application/json");

$mysqli = new mysqli("192.168.178.31", "preise", "^s1FptokR$6MtHoZ7[bmA,DdRzQs^B#tNcYcq?h|uMUji;Ji;TmM8^qX|#ioJE)an{<9#(0_GX-fT(8MopkGG.oo6&E=jOSmT8bw1Hz>3+.{/1x)6/~r9bXss.%`1Ur3", "preise");

$getData = null;

$limit = 20;
if(array_key_exists("limit", $_GET)) $limit = $_GET["limit"];
if(strlen($limit) === 0) {
    $limit = 20;
}

if($limit > 50) {
    echo '{"error":5,"message":"max limit is 50!"}';
    http_response_code(400);
    exit;
}

$offset = 0;
if(array_key_exists("offset", $_GET)) $offset = $_GET["offset"];
if(strlen($offset) === 0) {
    $offset = 20;
}

$search = "";
if(array_key_exists("search", $_GET)) $search = $_GET["search"];
if(strlen($search) !== 0) {
    $searchCrit = 'item_id';
    $ucrit = "id";
    if(array_key_exists("criteria", $_GET)) $ucrit = $_GET["criteria"];
    if($ucrit === "id") $searchCrit = 'item_id';
    else if($ucrit === "de_de") $searchCrit = 'de_de';
    else {
        echo '{"error":4,"message":"bad criteria!"}';
        http_response_code(400);
        exit;
    }

    $getData = $mysqli->prepare('SELECT min_price,max_price,de_de FROM `minmax` WHERE ' . $searchCrit . ' LIKE ? LIMIT ? OFFSET ?;');

    if(!$getData->bind_param('sss', $search, $limit, $offset)) {
        echo '{"error":1,"message":"parameter bind failed!"}';
        http_response_code(500);
        exit;
    }
} else {
    // no serch=xyz
    $getData = $mysqli->prepare("SELECT min_price,max_price,de_de FROM `minmax` LIMIT ? OFFSET ?;");

    if(!$getData->bind_param('ss', $limit, $offset)) {
        echo '{"error":1,"message":"parameter bind failed!"}';
        http_response_code(500);
        exit;
    }
}

if(!$getData->execute()) {
    echo '{"error":2,"message":"querry failed!"}';
    http_response_code(500);
    exit;
}

$result = $getData->get_result();

if(!($result->num_rows > 0)) {
    echo '{"error":3,"message":"no data!"}';
    http_response_code(404);
    exit;
}

$rowFMT = '{"min":"%s","max":"%s","de_de":"%s"}';

$p = array();
$i = 0;
while($row = $result->fetch_assoc()) {
    $p[$i] = sprintf($rowFMT, $row["min_price"], $row["max_price"], $row["de_de"]);
    $i++;
}
printf('{"error":0,"data":[%s]}', implode(',', $p))

?>
