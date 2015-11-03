<?php
/**
 * Created on 17-10-2011 22:01:45
 *
 * @author Tomasz Gajewski
 * @package common
 */
class PostChecker
{
	// -------------------------------------------------------------------------
	private static $variable = null;
	// -------------------------------------------------------------------------
	private function __construct()
	{
	}
	// -------------------------------------------------------------------------
	private function __clone()
	{
	}
	// -------------------------------------------------------------------------
	static function get($key)
	{
		if(is_null(self::$variable))
		{
			PostChecker::checkPost();
		}
		if(isset(self::$variable[$key]))
		{
			return self::$variable[$key];
		}
		else
		{
			return null;
		}
	}
	// -------------------------------------------------------------------------
	static function set($key, $value)
	{
		if(is_null(self::$variable))
		{
			PostChecker::checkPost();
		}
		self::$variable[$key] = $value;
	}
	// -------------------------------------------------------------------------
	/**
	 * Metoda dokonuje sprawdzenia przesłanych danych pod kątem złośliwej
	 * zawartosci
	 */
	public static function checkPost()
	{
		$daneG = self::preCheckVal($_GET);
		$daneP = self::preCheckVal($_POST);

		if(is_array($daneG) && is_array($daneP))
		{
			$dane = array_merge($daneG, $daneP);
		}
		else
		{
			if(is_array($daneG))
			{
				$dane = $daneG;
			}
			else
			{
				if(is_array($daneP))
				{
					$dane = $daneP;
				}
				else
				{
					$dane = array();
				}
			}
		}
		self::$variable = $dane;
		self::logRequest();
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return boolean
	 */
	protected static function logRequest()
	{
		if(!is_null(User::getCurrent()))
		{
			$l = Log::get();
			$l->setAction(self::get("action"));
			$l->setDate(date(PHP_DATETIME_FORMAT));
			$l->setIdUser(User::getCurrent()->getIdUser());
			$l->setIp($_SERVER["REMOTE_ADDR"]);
			if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				$tmp = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
				$l->setIp(trim(current($tmp)));
			}
			$l->setVariable(var_export(self::$variable, true));
			return $l->save();
		}
		else
		{
			return false;
		}
	}
	// -------------------------------------------------------------------------
	protected static function preCheckVal($array)
	{
		$retval = array();
		foreach($array as $name => $val)
		{
			$retval[$name] = self::checkVal($val);
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected static function checkVal($napis)
	{
		$retval = "";
		if(!is_array($napis))
		{
			$retval = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $napis);
			$retval = htmlspecialchars($napis, ENT_QUOTES, "UTF-8");
			$retval = trim($retval);
		}
		else
		{
			foreach($napis as $klucz => $wartosc)
			{
				$retval[$klucz] = self::checkVal($wartosc);
			}
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>