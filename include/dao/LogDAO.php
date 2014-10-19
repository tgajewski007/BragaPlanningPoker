<?php
/**
 * Created on 19-10-2014 12:32:08
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:104
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class LogDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idLog = null;
	protected $idUser = null;
	protected $date = null;
	protected $action = null;
	protected $variable = null;
	protected $ip = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idLog
	 */
	protected function __construct($idLog = null)
	{
		if(!is_null($idLog))
		{
			if(!$this->retrieve($idLog))
			{
				throw new Exception("PP:10401 " . DB_SCHEMA . ".log(" . $idLog . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idLog
	 * @return Log
	 */
	static function get($idLog = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idLog))
		{
			if(!isset(self::$instance[$idLog]))
			{
				self::$instance[$idLog] = new Log($idLog);
			}
			return self::$instance[$idLog];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Log();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Log $log)
	{
		$key = array_search($log,self::$instance,true);
		if($key !== false)
		{
			if($key !== $log->getIdLog())
			{
				unset(self::$instance[$key]);
				self::$instance[$log->getIdLog()] = $log;
			}
		}
		else
		{
			self::$instance[$log->getIdLog()] = $log;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Log
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idlog");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Log();
			self::$instance[$key]->setAllFromDB($db);
		}
		return self::$instance[$key];
	}
	// -------------------------------------------------------------------------
	protected function isReaded()
	{
		return $this->readed;
	}
	// -------------------------------------------------------------------------
	protected function setReaded()
	{
		$this->readed = true;
	}
	// -------------------------------------------------------------------------
	protected function setIdLog($idLog)
	{
		if(is_numeric($idLog))
		{
			$this->idLog = round($idLog,0);
		}
		else
		{
			$this->idLog = null;
		}
	}
	// -------------------------------------------------------------------------
	public function setIdUser($idUser)
	{
		if(empty($idUser))
		{
			$this->idUser = null;
		}
		else
		{
			$this->idUser = mb_substr($idUser,0,32);
		}
	}
	// -------------------------------------------------------------------------
	public function setDate($date)
	{
		if(empty($date))
		{
			$this->date = null;
		}
		else
		{
			$this->date = mb_substr($date,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setAction($action)
	{
		if(empty($action))
		{
			$this->action = null;
		}
		else
		{
			$this->action = mb_substr($action,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setVariable($variable)
	{
		$this->variable = $variable;
	}
	// -------------------------------------------------------------------------
	public function setIp($ip)
	{
		if(empty($ip))
		{
			$this->ip = null;
		}
		else
		{
			$this->ip = mb_substr($ip,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function getIdLog()
	{
		return $this->idLog;
	}
	// -------------------------------------------------------------------------
	public function getIdUser()
	{
		return $this->idUser;
	}
	// -------------------------------------------------------------------------
	public function getDate()
	{
		return $this->date;
	}
	// -------------------------------------------------------------------------
	public function getAction()
	{
		return $this->action;
	}
	// -------------------------------------------------------------------------
	public function getVariable()
	{
		return $this->variable;
	}
	// -------------------------------------------------------------------------
	public function getIp()
	{
		return $this->ip;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdLog();
	}
	// -------------------------------------------------------------------------
	/**
	 * @return User
	 */
	public function getUser()
	{
		return User::get($this->getIdUser());
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Log you can read all of atrib by get...() function
	 * select record from table log
	 * @return boolean
	 */
	protected function retrieve($idLog)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".log ";
		$sql .= "WHERE idlog = :IDLOG ";
		$db->setParam("IDLOG", $idLog);
		$db->query($sql);
		if($db->nextRecord())
		{
			$this->setAllFromDB($db);
			return true;
		}
		else
		{
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods add object of class Log
	 * insert record into table log
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".log(iduser, date, action, variable, ip) ";
		$sql .= "VALUES(:IDUSER, :DATE, :ACTION, :VARIABLE, :IP) ";
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("DATE",$this->getDate());
		$db->setParam("ACTION",$this->getAction());
		$db->setParam("VARIABLE",$this->getVariable());
		$db->setParam("IP",$this->getIp());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdLog($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10402 Dodanie rekordu do tablicy log nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Log
	 * update record in table log
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".log ";
		$sql .= "SET iduser = :IDUSER ";
		$sql .= " , date = :DATE ";
		$sql .= " , action = :ACTION ";
		$sql .= " , variable = :VARIABLE ";
		$sql .= " , ip = :IP ";
		$sql .= "WHERE idlog = :IDLOG ";
		$db->setParam("IDLOG",$this->getIdLog());
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("DATE",$this->getDate());
		$db->setParam("ACTION",$this->getAction());
		$db->setParam("VARIABLE",$this->getVariable());
		$db->setParam("IP",$this->getIp());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10403 Zmiana rekordu w tablicy log nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Log
	 * removed are record from table log
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".log ";
		$sql .= "WHERE idlog = :IDLOG ";
		$db->setParam("IDLOG", $this->getIdLog());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10404 Delete record from table log fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Log from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdLog($db->f("idlog"));
		$this->setIdUser($db->f("iduser"));
		$this->setDate($db->f("date"));
		$this->setAction($db->f("action"));
		$this->setVariable($db->f("variable"));
		$this->setIp($db->f("ip"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Log
	 * @return Collection &lt;Log&gt; 
	 */
	public static function getAllByUser(UserDAO $user)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".log ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER", $user->getIdUser());
		$db->query($sql);
		return new Collection($db, Log::get());
	}
	// -------------------------------------------------------------------------
}
?>