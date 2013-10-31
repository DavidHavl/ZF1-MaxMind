<?php

class Default_Service_Maxmind extends stdClass
{
    private $_userId = "xxxxxxxxx";
    private $_licenseKey = "xxxxxxxxxxxxxxx";
    private $_endpoint = 'omni';

    /**
     * Get geo data as object from maxmind web service using given IP
     * @param string $ip
     * @return Default_Entity_Geodata|null
     */
    public function getDataFromIp($ip) {
        if (!$this->validateIpAddress($ip)) {
            return null;
        }

        // get country from IP
        try {
            $serviceUrl = "https://geoip.maxmind.com/geoip/v2.0/";
            $url = $serviceUrl . $this->_endpoint . '/' . $ip;

            $geoClient = new Zend_Http_Client();
            $geoClient->setUri($url);
            $geoClient->setHeaders('Accept', 'application/json');
            $geoClient->setAuth($this->_userId, $this->_licenseKey);

            // send via GET
            $result = $geoClient->request('GET');
            // check if request was successful
            if (!empty($result) && $result->isSuccessful()) {
                $responseObject = Zend_Json_Decoder::decode($result->getBody(), Zend_Json::TYPE_ARRAY);
                $resultObject = new Default_Entity_Geodata();
                // set continent
                if (!empty($responseObject['continent']['names']['en'])) {
                    $resultObject->setContinent($responseObject['continent']['names']['en']);
                }
                // set country
                if (!empty($responseObject['country']['iso_code'])) {
                    $resultObject->setCountry($responseObject['country']['iso_code']);
                }
                // TODO: city, location,...
                return $resultObject;
            }


        } catch (Exception $exc) {
            // silence
            return null;
        }

        return null;
    }


    /**
     * Method to validate ip address format
     * @param string $ip
     * @return boolean
     */ 
    function validateIpAddress($ip)
    {
        //first of all the format of the ip address is matched
        if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip))
        {
            //now all the intger values are separated
            $parts=explode(".",$ip);
            //now we need to check each part can range from 0-255
            foreach($parts as $ipParts)
            {
                if(intval($ipParts)>255 || intval($ipParts)<0)
                    return false; //if number is not within range of 0-255
            }
            return true;
        }
        else
            return false; //if format of ip address doesn't matches
    }



    /**
     * Calculate distance between 2 points.
     * @param arra $point1 = array('lat' => 0, 'long' => 0)
     * @param array $point2 = array('lat' => 0, 'long' => 0)
     * @return number of miles
     */
    public function calulateDistanceBetween($point1, $point2)
    {
        $radius      = 3958;      // Earth's radius (miles)
        $pi          = 3.1415926;
        $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

        $distance = ($radius * $pi * sqrt(
                ($point1['lat'] - $point2['lat'])
                * ($point1['lat'] - $point2['lat'])
                + cos($point1['lat'] / $deg_per_rad)  // Convert these to
                * cos($point2['lat'] / $deg_per_rad)  // radians for cos()
                * ($point1['long'] - $point2['long'])
                * ($point1['long'] - $point2['long'])
            ) / 180);

        return $distance;  // Returned using the units used for $radius.
    }

}
