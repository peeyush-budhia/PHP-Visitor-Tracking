<?php

/**
 * @package         PHP-Lib
 * @description     Class is used to get the visitor's geographical details like IP, Country Code, Country, Continent, etc  using external geo plugin
 * @copyright       Copyright (c) 2013, Peeyush Budhia
 * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
 */

class GeoIP
{
    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's country
     * @return SimpleXMLElement[]|string
     *          Return visitor's country | Unknown Country
     */
    function getCountry()
    {
        $ip = $this->getIP();
        $geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
        if ($geoXML->geoplugin_countryName == '') {
            return 'Unknown Country';
        } else {
            return $geoXML->geoplugin_countryName;
        }

    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's region
     * @return SimpleXMLElement[]|string
     *          Return visitor's region | unknown region
     */
    function getRegion()
    {
        $ip = $this->getIP();
        $geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
        if ($geoXML->geoplugin_regionName == '') {
            return 'Unknown Region';
        } else {
            return $geoXML->geoplugin_region;
        }
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's IP Address
     * @return mixed
     *          Return IP Address of the visitor
     */
    function getIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $_realIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $_realIP = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $_realIP = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $_realIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (getenv($_SERVER['HTTP_CLIENT_IP'])) {
                $_realIP = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $_realIP = $_SERVER['REMOTE_ADDR'];
            }
        }
        return $_realIP;
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's city
     * @return SimpleXMLElement[]|string
     *          Return visitor's city | unknown city
     */
    function getCity()
    {
        $ip = $this->getIP();
        $geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
        if ($geoXML->geoplugin_city == '') {
            return 'Unknown City';
        } else {
            return $geoXML->geoplugin_city;
        }
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's country code
     * @return SimpleXMLElement[]|string
     *          Return visitor's country code | unknown country code
     */
    function getCountryCode()
    {
        $ip = $this->getIP();
        $geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
        if ($geoXML->geoplugin_countryCode == '') {
            return 'Unknown Country Code';
        } else {
            return $geoXML->geoplugin_countryCode;
        }

    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@phpnmysql.com>
     * @description     The function is used to get the visitor's continent
     * @return string
     *          Return visitor's continent | unknown continent
     */
    function getContinent()
    {
        $continent = 'Unknown Continent';
        $continent_array = array(
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'NA' => 'North America',
            'SA' => 'South America',
            'OC' => 'Oceania',
        );
        $ip = $this->getIP();
        $geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
        $continentCode = $geoXML->geoplugin_continentCode;

        foreach ($continent_array as $code => $continentName) {
            if ($continentCode == $code) {
                $continent = $continentName;
            }
        }
        return $continent;
    }
}