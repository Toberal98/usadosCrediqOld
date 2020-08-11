<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Geoip
{
function __construct()
{
$this->ci =& get_instance();

include_once(APPPATH."geoiplocali/geoiploc.php");

}

function get_country_code_by_ip($ip)
{
   $record = getCountryFromIP($ip);

   return $record;
}


}
?>