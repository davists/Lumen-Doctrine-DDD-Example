<?php
/**
 * Created by PhpStorm.
 * User: rz2
 * Date: 03/05/17
 * Time: 16:20
 */

namespace Infrastructure\Util;

class AccentsHelper
{
    public function removeAccents($str, $case = null, $slug = null)
    {
        // View table ASCII
        //for($i=0;$i<256;$i++)
        //	printf(" %d = %c\r\n", $i, $i);
        
        setlocale(LC_ALL, 'en_US.UTF8');
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $str = strtolower($str);
        if ($case) {
            $str = strtoupper($str);
        }
        
        // Codigo ASCII das vogais
        $aAscii['a'] = range(224, 230);
        $aAscii['e'] = range(232, 235);
        $aAscii['i'] = range(236, 239);
        $aAscii['o'] = array_merge(range(242, 246), array(240, 248));
        $aAscii['u'] = range(249, 252);
        
        // Codigo ASCII dos outros caracteres
        $aAscii['b'] = array(223);
        $aAscii['c'] = array(231);
        $aAscii['d'] = array(208);
        $aAscii['n'] = array(241);
        $aAscii['y'] = array(253, 255);
        
        foreach ($aAscii as $key => $val) {
            $accents = '';
            foreach ($val as $v) {
                $accents .= chr($v);
            }
            
            $aBuffer[$key] = '/[' . $accents . ']/mi';
        }
        
        $str = preg_replace(array_values($aBuffer), array_keys($aBuffer), $str);
        
        if ($slug) {
            $str = preg_replace('/[^a-z0-9]/mi', $slug, $str);
            $str = preg_replace('/' . $slug . '{2,}/mi', $slug, $str);
            $str = trim($str, $slug);
        }
        
        return $str;
    }
}

