<?php
/**
 * EB Spinner
 * 
 * İç içe spinleri de destekler.
 *
 * @author  Ekrem Büyükkaya
 * @package EB Spinner
 */
class EBSpinner 
{
    private $ayrac           = '|';
    private $spin_regexp     = '/\{(.+?)\}/s';
    private $yazi            = null;

    public function __construct($yazi) 
    {
        $this->yazi = $yazi;
    }

    public function calistir($yazi = false) 
    {
        if ($yazi == false)
            $yazi = $this->yazi;

        // Hiç yazı yok
        if (strpos($yazi, '{') === false)
            return $yazi;

        // İçinde spin yapılacak yer var mı
        if (preg_match($this->spin_regexp, $yazi, $cikti)):
            if (( $pos = mb_strrpos($cikti[1], '{' ) ) !== false)
                $cikti[1] = mb_substr($cikti[1], $pos + mb_strlen('{'));

            // Spin
            $parcalar = explode('|', $cikti[1]);
            $yazi     = $this->str_replace_first('{' . $cikti[1] . '}', $parcalar[ mt_rand( 0, count( $parcalar ) - 1 ) ], $yazi);

            // İç içe
            return $this->calistir($yazi);

        // Düz yazı
        else:
            return $yazi;
        
        endif;
    }

    private function str_replace_first($find, $replace, $string)
    {
        if(!is_array($find))
        {
            $find = array($find);
        }

        if(!is_array($replace))
        {
            $replace = array($replace);
        }

        foreach($find as $key => $value)
        {
            if(($pos = mb_strpos($string, $value)) !== false)
            {
                if(!isset($replace[$key]))
                {
                    $replace[$key] = '';
                }

                $string = mb_substr($string, 0, $pos).$replace[$key].mb_substr($string, $pos + mb_strlen($value));
            }
        }

        return $string;
    }

}