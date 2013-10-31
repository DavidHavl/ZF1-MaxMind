ZF1-MaxMind
===========

MaxMind ZF1 Service API


USAGE:
------
```php

$ip = $_SERVER['REMOTE_ADDR'];
$user = "xxxxx";
$license = "xxxxxxxxxx";
$endpoint = "omni";

// get service
$maxmindService = new Default_Service_Maxmind($user, $license, $enpoint);
// fetch data
$geodata = $maxmindService->getDataFromIp($ip);
// check correct result object
if (!empty($geodata) && $geodata instanceof Default_Entity_Geo) {
  // print out country
  echo $geodata->getCountry();
}
```
