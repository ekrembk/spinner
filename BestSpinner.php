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

	/**
	 * API Url
	 */
	public $api_url = 'http://thebestspinner.com/api.php';

	/**
	 * Login bilgileri
	 */
	public $login = null;

	/**
	 * Session ID
	 */
	public static $session_id = null;

	/**
	 * Hata
	 */
	public $hata = array();

	public function __construct($yazi = false, $api_kullanici = false, $api_sifre)
	{
		$this->yazi  = $yazi;
		$this->login = array(
				'username' => $api_kullanici,
				'password' => $api_sifre
			);
	}

	public function spin()
	{
		// Yazı girilmemiş veya geçersiz
		if(is_null($this->yazi))
			return false;

		// Giriş yapılmadıysa giriş yap
		$session_id = is_null(self::$session_id) ? $this->auth() : self::$session_id;
		// Geçersiz giriş, işlemleri durdur.
		if(!$session_id)
			return false;

		// Methodu uygula
		$data = array(
				'session' => self::$session_id,
				'action'  => 'replaceEveryonesFavorites',
				'format'  => 'php',
				'text'    => $this->yazi,
				'maxsyns' => 3,
				'quality' => 1
			);
		$dongu = $this->post($data);

		return empty($dongu['output']) ? false : $dongu['output'];
	}

	private function post($data)
	{
		$ch = curl_init($this->api_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$dongu = unserialize(curl_exec($ch));

		curl_close($ch);

		// Hata varsa kaydet
		if($dongu['success'] != 'true')
			$this->hata[] = $dongu['error'];

		return $dongu;
	}

	private function auth()
	{
		$data = array(
				'action'   => 'authenticate',
				'format'   => 'php',
				'username' => $this->login['username'],
				'password' => $this->login['password']
			);
		$dongu = $this->post($data);

		if(!empty($dongu['session'])):
			// Session ID kaydet
			self::$session_id = $dongu['session'];

			return true;
		else:
			// Giriş başarısız
			return false;
		endif;
	}
}