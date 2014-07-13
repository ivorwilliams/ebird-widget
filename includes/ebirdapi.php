<?php
/**
 * A wrapper class for eBird API
 *
 * This is a wrapper class for Ebird API version 1.1
 *
 * PHP version 5.3
 *
 * @category APIWrapper
 * @package  Ebird
 * @author   Dr. Tarique Sani <tarique@sanisoft.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/sanisoft/ebird-api
 */

namespace NagpurBirds;

/**
 * The main class for eBird API access
 *
 * @category APIWrapper
 * @package  Ebird
 * @author   Dr. Tarique Sani <tarique@sanisoft.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     https://github.com/sanisoft/ebird-api
 *
 */
class EbirdAPI
{
    /**
     * Will hold error code.
     *
     * @var mixed
     */
    public $error = FALSE;

    /**
     * Will hold error message.
     *
     * @var string
     */
    public $errorMsg = "";


    /**
     * Returns the most recent sighting date and specific location for each species of
     * bird reported within the number of days specified by the "back" parameter and
     * reported in the specified area.
     *
     * @param double $lat     Latitude of the place where search is being made
     * @param double $lng     Longitude of the place where search is being made
     * @param array  $options All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNearbyObservations
     *
     * @return array
     */
    public function recentNearByObservations($lat, $lng, $options=array())
    {
        $url = "/obs/geo/recent";
        $options['lat'] = $lat;
        $options['lng'] = $lng;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNearByObservations()


    /**
     * Returns the most recent sighting date and specific location for a specific species of
     * bird reported within the number of days specified by the "back" parameter and
     * reported in the specified area.
     *
     * @param double $lat     Latitude of the place where search is being made
     * @param double $lng     Longitude of the place where search is being made
     * @param string $specie  Scientific name of the specie of interest
     * @param array  $options All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNearbyObservationsOfASpecies
     *
     * @return array
     */
    public function recentNearbyObservationsOfASpecies($lat, $lng, $specie, $options=array())
    {
        $url = "/obs/geo_spp/recent";
        $options['lat'] = $lat;
        $options['lng'] = $lng;
        $options['sci'] = $specie;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNearbyObservationsOfASpecies()


    /**
     * Returns the most recent sighting date and specific location for each species of bird reported
     * within the number of days specified by the "back" parameter and reported at birding hotspots.
     *
     * @param string $hotspotID Hotspot ID
     * @param array  $options   All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsAtHotspots
     *
     * @return array
     */
    public function recentObservationsAtHotspot($hotspotID, $options=array())
    {
        $url = "/obs/hotspot/recent";
        $options['r'] = $hotspotID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsAtHotspot()


    /**
     * Returns the most recent sighting date and specific location for the requested species of bird reported
     * within the number of days specified by the "back" parameter and reported at birding hotspots.
     *
     * @param string $hotspotID Hotspot ID
     * @param string $specie    Scientific name of the specie of interest
     * @param array  $options   All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsOfASpeciesAtHotspots
     *
     * @return array
     */
    public function recentObservationsOfASpeciesAtHotspots($hotspotID, $specie, $options=array())
    {
        $url = "/obs/hotspot_spp/recent";
        $options['r']   = $hotspotID;
        $options['sci'] = $specie;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsOfASpeciesAtHotspots()


    /**
     * Returns a list of recent observations at birding locations.
     *
     * @param string $locationID Location ID
     * @param array  $options    All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsAtLocations
     *
     * @return array
     */
    public function recentObservationsAtLocations($locationID, $options=array())
    {
        $url = "/obs/loc/recent";
        $options['r'] = $locationID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsAtLocations()


    /**
     * Returns the most recent sighting date and specific location for the requested species of bird reported
     * within the number of days specified by the "back" parameter and reported at birding hotspots.
     *
     * @param string $locationID Location ID
     * @param string $specie     Scientific name of the specie of interest
     * @param array  $options    All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsOfASpeciesAtLocations
     *
     * @return array
     */
    public function recentObservationsOfASpeciesAtLocations($locationID, $specie, $options=array())
    {
        $url = "/obs/loc_spp/recent";
        $options['r']   = $locationID;
        $options['sci'] = $specie;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsOfASpeciesAtLocations()


    /**
     * Returns a list of all bird species seen within a region, along with their most
     * recent sighting date and specific location.
     *
     * @param string $regionID Region Code
     * @param array  $options  All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsInARegion
     *
     * @return array
     */
    public function recentObservationsInARegion($regionID, $options=array())
    {
        $url = "/obs/region/recent";
        $options['r'] = $regionID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsInARegion()


    /**
     * Returns the most recent sighting date and specific location for the requested species of bird reported
     * within the number of days specified by the "back" parameter and reported at birding hotspots.
     *
     * @param string $regionID Location ID
     * @param string $specie   Scientific name of the specie of interest
     * @param array  $options  All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentObservationsOfASpeciesInARegion
     *
     * @return array
     */
    public function recentObservationsOfASpeciesInARegion($regionID, $specie, $options=array())
    {
        $url = "/obs/region_spp/recent";
        $options['r']   = $regionID;
        $options['sci'] = $specie;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentObservationsOfASpeciesInARegion()


    /**
     * Returns all recent observations of notable bird species near a given area.
     *
     * @param double $lat     Latitude of the place where search is being made
     * @param double $lng     Longitude of the place where search is being made
     * @param array  $options All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNearbyNotableObservations
     *
     * @return array
     */
    public function recentNearByNotableObservations($lat, $lng, $options=array())
    {
        $url = "/notable/geo/recent";
        $options['lat'] = $lat;
        $options['lng'] = $lng;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNearByNotableObservations()


    /**
     * Returns the most recent sighting date and specific location for notable species of bird reported
     * within the number of days specified by the "back" parameter and reported at birding hotspots.
     *
     * @param string $hotspotID Hotspot ID
     * @param array  $options   All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNotableObservationsAtHotspots
     *
     * @return array
     */
    public function recentNotableObservationsAtHotspots($hotspotID, $options=array())
    {
        $url = "/notable/hotspot/recent";
        $options['r'] = $hotspotID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNotableObservationsAtHotspots()


    /**
     * Returns a list of recent notable observations at birding location.
     *
     * @param string $locationID Location ID
     * @param array  $options    All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNotableObservationsAtLocations
     *
     * @return array
     */
    public function recentNotableObservationsAtLocations($locationID, $options=array())
    {
        $url = "/notable/loc/recent";
        $options['r'] = $locationID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNotableObservationsAtLocations()


    /**
     * Returns all recent observations of notable bird species in a given area.
     *
     * @param string $regionID Region ID
     * @param array  $options  All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-RecentNotableObservationsInARegion
     *
     * @return array
     */
    public function recentNotableObservationsInARegion($regionID, $options=array())
    {
        $url = "/notable/region/recent";
        $options['r']   = $regionID;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end recentNotableObservationsInARegion()


    /**
     * Returns the nearest N locations (specified with the maxResults parameter) with observations of a species.
     *
     * @param double $lat     Latitude of the place where search is being made
     * @param double $lng     Longitude of the place where search is being made
     * @param string $specie  Scientific name of the specie of interest
     * @param array  $options All other available options
     *
     * @link https://confluence.cornell.edu/display/CLOISAPI/eBird-1.1-NearestLocationsWithObservationsOfASpecies
     *
     * @return array
     */
    public function nearestLocationsWithObservationsOfASpecies($lat, $lng, $specie, $options=array())
    {
        $url = "/nearest/geo_spp/recent";
        $options['lat'] = $lat;
        $options['lng'] = $lng;
        $options['sci'] = $specie;

        $data = $this->__curlit($url, $options);

        return $data;

    }//end nearestLocationsWithObservationsOfASpecies()


    /**
     * Does the cURL calls
     *
     * @param string $url     URL of the API to be called
     * @param array  $options All other options for building the query
     *
     * @return array
     */
    private function __curlit($url, $options)
    {

        $options['fmt'] = 'json';

        $query = http_build_query($options);

        $ch = curl_init();
        $url = 'http://ebird.org/ws1.1/data'.$url.'?'.$query;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);


        $data = curl_exec($ch);

        //Send the data back and have some other function check for error?
        if ($data === FALSE) {

            $this->error = curl_error($ch);

        } elseif (stripos($data, 'errorMsg')) {
            $errors = json_decode($data);
            $this->errorMsg = $errors[0]->errorMsg;
            $this->error    = $errors[0]->errorCode;

            return;
        }

        // 4. free up the curl handle
        curl_close($ch);

        return $data;

    }//end __curlit()


}//end class
