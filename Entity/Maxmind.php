<?php 


class Default_Entity_Geodata extends stdClass
{

    private $city;
    private $continent;
    private $country;
    private $location;
    private $postal;
    private $registered_country;
    private $represented_country;
    private $subdivisions;
    private $traits;
    private $maxmind;

    
    /**
     * @param string $traits
     */
    public function setTraits($traits)
    {
        $this->traits = $traits;
    }

    /**
     * @return string
     */
    public function getTraits()
    {
        return $this->traits;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $continent
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
    }

    /**
     * @return string
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        // get available countries
        $locale = Zend_Registry::get('Zend_Translate')->getLocale();
        $territories = Zend_Locale::getTranslationList('territory', $locale, 2);
        $territories = array_filter($territories);
        $territories = str_replace("'", "", $territories);

        // check if result country code is valid
        if (array_key_exists($country, $territories)) {
            $this->country = $country;
        }
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $maxmind
     */
    public function setMaxmind($maxmind)
    {
        $this->maxmind = $maxmind;
    }

    /**
     * @return string
     */
    public function getMaxmind()
    {
        return $this->maxmind;
    }

    /**
     * @param string $postal
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;
    }

    /**
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * @param string $registered_country
     */
    public function setRegisteredCountry($registered_country)
    {
        $this->registered_country = $registered_country;
    }

    /**
     * @return string
     */
    public function getRegisteredCountry()
    {
        return $this->registered_country;
    }

    /**
     * @param string $represented_country
     */
    public function setRepresentedCountry($represented_country)
    {
        $this->represented_country = $represented_country;
    }

    /**
     * @return string
     */
    public function getRepresentedCountry()
    {
        return $this->represented_country;
    }

    /**
     * @param string $subdivisions
     */
    public function setSubdivisions($subdivisions)
    {
        $this->subdivisions = $subdivisions;
    }

    /**
     * @return string
     */
    public function getSubdivisions()
    {
        return $this->subdivisions;
    }

    /**
     * Sets all data from an array.
     *
     * @param  array $data
     * @return Darwin_Model_Geodata Provides a fluent interface
     */
    public function setFromArray(array $data)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        foreach ($data as $name => $value) {
            $methodName = 'set' . $filter->filter($name);
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }

        return $this;
    }


}
