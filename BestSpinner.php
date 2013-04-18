<?php
/**
 * Thebestspinner Library test
 *
 * @author  Ekrem Büyükkaya <ebuyukkaya@gmail.com> <ekrembk.com>
 * @package Thebestspinner Library
 */
class BestSpinner
{
	/** 
     * Kelime limiti (API tarafından belirleniyor)
     */
	public $kelime_limit = 500;

	/**
	 * Spin edilecek cümle
	 */
	public $yazi = null;


	public function __construct($yazi = false)
	{
		if (!$yazi)
			$this->yazi = $yazi;
		else
			return false;
	}

	public function spin()
	{
		// Yazı girilmemiş veya geçersiz
		if(is_null($this->yazi))
			return false;

		// Bağlantıyı kur
	}
}