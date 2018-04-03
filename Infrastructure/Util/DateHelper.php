<?php
namespace Infrastructure\Util;

class DateHelper
{
    /**
     *
     * @param type $format Ex: d/m/Y, Y-m-d H:i:s
     * @param type $add Ex: P10D - adiciona 10 dias, PT10H30S - 10 hora e 30 segundos, P7Y5M4DT4H3M2S
     * @param \DateTime $date / Formato exemplo: 2000-01-01, default: now
     * @return type
     */
    public function dateFormat($format = 'd/m/Y', $add="", $date = 'now'){
        $date = new \DateTime($date, new \DateTimeZone(env('APP_TIMEZONE','+00:00')));
        if($add){
            $date->add(new \DateInterval($add));
        }
        return $date->format($format);
    }
}
