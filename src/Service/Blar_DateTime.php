<?php
namespace App\Service;

class Blar_DateTime extends \DateTime {

    /**
     * Return Date in ISO8601 format
     *
     * @return String
     */
    public function __toString() {
        return $this->format('Y-m-d H:i');
    }

    /**
     * Return difference between $this and $now
     *
     * @param Datetime|String $now
     * @return DateInterval
     */
    public function diff($now = 'NOW', $absolute=NULL){
        if(!($now instanceOf \DateTime)) {
            $now = new \DateTime($now);
        }
        return parent::diff($now);
    }

    /**
     * Return Age in Years
     *
     * @param Datetime|String $now
     * @return Integer
     */
    public function getAge($now = 'NOW') {
        return $this->diff($now)->format('%y');
    }
    public function getMessage($date,$date_i){
    	$year = $date->diff()->y;
		$mounth = $date->diff()->m;
		$day =  $date->diff()->d;
		$hours = $date->diff()->h;
		$minutes =$date->diff()->i;
		$secondes=$date->diff()->s;
    	if($year ==0 AND $mounth ==0 AND $day==0){
			if($hours==0 AND $minutes == 0){
				return 'il y a '.$secondes.' secondes';
			}
			else{
				if($hours==0){
					if($minutes==1){
						return 'il y a '.$minutes.' minute';
					}
					else{
						return 'il y a '.$minutes.' minutes';
					}
				}
				else{
					return 'il y a '.$hours.'h'.$minutes.'min';
				}
			}
		}
		else{
			return 'le '.$date_i->format('d/m/Y h:i');
		}
    }
}
