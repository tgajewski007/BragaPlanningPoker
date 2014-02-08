<?php
/**
 * Created on 17-10-2011 22:01:45
 * @author Tomasz Gajewski
 * @package common
 *
 */
class PostChecker
{
	// -------------------------------------------------------------------------
	private static $instance = null;
	// -------------------------------------------------------------------------
	static function get($key)
	{
		if(isset(self::$instance[$key]))
		{
			return self::$instance[$key];
		}
		else
		{
			return null;
		}
	}
	// -------------------------------------------------------------------------
	static function set($key, $value)
	{
		self::$instance[$key] = $value;
	}
	// -------------------------------------------------------------------------
	protected $logObject = null;
	// -------------------------------------------------------------------------
	function __construct(GLog $l)
	{
		if(null != $l)
			$this->logObject = $l;
	}
	// -------------------------------------------------------------------------
	protected function logAction(BaseAction $objAction)
	{
		if(!is_null($this->logObject))
			$this->logObject->create($objAction);
	}
	// -------------------------------------------------------------------------
	public function checkPost(BaseAction $objAction)
	{
		$daneG = $this->preCheckVal($_GET, "GET");
		$daneP = $this->preCheckVal($_POST, "POST");

		if(is_array($daneG) and is_array($daneP))
		{
			$dane = array_merge($daneG, $daneP);
		}
		else if(is_array($daneG))
		{
			$dane = $daneG;
		}
		else if(is_array($daneP))
		{
			$dane = $daneP;
		}
		else
		{
			$dane = null;
		}

		$objAction->post = $dane;
		self::$instance = $dane;
		// ================= GET =================
		if(isset($dane["action"]))
		{
			$objAction->action = $dane["action"];
		}
		if(isset($dane["arg1"]))
		{
			$objAction->arg1 = $dane["arg1"];
		}
		if(isset($dane["arg2"]))
		{
			$objAction->arg2 = $dane["arg2"];
		}
		if(isset($dane["arg3"]))
		{
			$objAction->arg3 = $dane["arg3"];
		}
		if(isset($dane["js"]))
		{
			$objAction->js = true;
		}
		// ============================================
		if($objAction->action != "")
		{
			$this->logAction($objAction);
		}
	}
	// -------------------------------------------------------------------------
	protected function preCheckVal($array, $argName)
	{
		$retval = array();
		foreach($array as $name => $val)
		{
			$name = strtolower($name);
			$retval[$name] = $this->checkVal($val, $argName . "[" . $name . "]");
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function checkVal($napis, $argName)
	{
		$retval = "";
		if(!is_array($napis))
		{
			$retval = preg_replace('/[[:cntrl:]]/', '', $retval);
			$retval = htmlspecialchars($napis,ENT_QUOTES,"UTF-8");
			$retval = trim($retval);
		}
		else
		{
			foreach($napis as $klucz => $wartosc)
			{
				$klucz = strtolower($klucz);
				$retval[$klucz] = $this->checkVal($wartosc, $argName);
			}
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>