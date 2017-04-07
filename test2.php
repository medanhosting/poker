<?php


$url = "http://192.99.236.77:81/api";  // put your API path here
$pw = "save";                          // put your API password here


$params = array(
    "Command" => "LogsHandHistory",
    //"Result" => "Ok",
    //"Files" => "2",
    //"Date" => "2016-12-20",
    //"Name" => "Hihand",
    //"Date1" => "2015-02-01",
    //"Name1" => "Ring Game #1",
    //"Date2" => "2015-02-05",
    //"Name2" => "Tournament #3 - Table 1"
);

$params = array_merge($params, $_GET);

$api = Poker_API($params);

echo '<pre>';
var_dump($api);
echo '</pre>';


function Poker_API($params)
{
    global $url, $pw;
    $params['Password'] = $pw;
    $params['JSON'] = 'Yes';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    if (curl_errno($curl)) $obj = (object) array('Result' => 'Error', 'Error' => curl_error($curl));
    else if (empty($response)) $obj = (object) array('Result' => 'Error', 'Error' => 'Connection failed');
    else $obj = json_decode($response);
    curl_close($curl);
    return $obj;
}
