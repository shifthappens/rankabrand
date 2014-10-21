<?php

$command = $_GET['command'];
$lang = $_GET['lang'];
$tld = $lang == 'en' ? 'org' : $lang; //if the language is 'en' the TLD must be .org for correct URL solving. Otherwise we can (still) safely assume it's rankabrand.lang/
$apiurl = 'http://rankabrand.'.$tld.'/api/78bfe409adae69881bff21bb52065044/'.$lang.'/'.urldecode($command);

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
curl_setopt($ch, CURLOPT_URL, $apiurl);

$data = curl_exec($ch);
curl_close($ch);

print $data;