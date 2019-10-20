<?php
function getCurrentTemp() {
  $ch = curl_init("http://api.openweathermap.org/data/2.5/weather?q=<city>,gb&appid=<apikey>&units=metric");

  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $jsonstring = curl_exec ($ch);
//print($jsonstring);
  $result= json_decode($jsonstring); //execute and get the results
//var_dump($result);
  curl_close($ch);
  return $result->main->temp;
}
//print getCurrentTemp();
?>
