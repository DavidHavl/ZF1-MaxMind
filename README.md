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

$maxmindService = new Default_Service_Maxmind($user, $license, $enpoint);
$geodata = $maxmindService->getDataFromIp();
if (!empty($geodata) && $geodata instanceof Default_Entity_Geo) {
  echo $geodata->getCountry();
}
```
