<?php
/**
 * Created on 19-10-2014 12:32:08
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:107
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class PrivacyStatusDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idPrivacyStatus = null;
	protected $name = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idPrivacyStatus
	 */
	protected function __construct($idPrivacyStatus = null)
	{
		if(!is_null($idPrivacyStatus))
		{
			if(!$this->retrieve($idPrivacyStatus))
			{
				throw new Exception("PP:10701 " . DB_SCHEMA . ".privacy_status(" . $idPrivacyStatus . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idPrivacyStatus
	 * @return PrivacyStatus
	 */
	static function get($idPrivacyStatus = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idPrivacyStatus))
		{
			if(!isset(self::$instance[$idPrivacyStatus]))
			{
				self::$instance[$idPrivacyStatus] = new PrivacyStatus($idPrivacyStatus);
			}
			return self::$instance[$idPrivacyStatus];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new PrivacyStatus();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(PrivacyStatus $privacyStatus)
	{
		$key = array_search($privacyStatus,self::$instance,true);
		if($key !== false)
		{
			if($key !== $privacyStatus->getIdPrivacyStatus())
			{
				unset(self::$instance[$key]);
				self::$instance[$privacyStatus->getIdPrivacyStatus()] = $privacyStatus;
			}
		}
		else
		{
			self::$instance[$privacyStatus->getIdPrivacyStatus()] = $privacyStatus;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return PrivacyStatus
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idprivacy_status");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new PrivacyStatus();
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
	protected function setIdPrivacyStatus($idPrivacyStatus)
	{
		if(is_numeric($idPrivacyStatus))
		{
			$this->idPrivacyStatus = round($idPrivacyStatus,0);
		}
		else
		{
			$this->idPrivacyStatus = null;
		}
	}
	// -------------------------------------------------------------------------
	public function setName($name)
	{
		if(empty($name))
		{
			$this->name = null;
		}
		else
		{
			$this->name = mb_substr($name,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function getIdPrivacyStatus()
	{
		return $this->idPrivacyStatus;
	}
	// -------------------------------------------------------------------------
	public function getName()
	{
		return $this->name;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdPrivacyStatus();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Table
	 * @return Collection &lt;Table&gt; 
	 */
	public function getTablesForPrivacyStatus()
	{
		return Table::getAllByPrivacyStatus($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class PrivacyStatus you can read all of atrib by get...() function
	 * select record from table privacy_status
	 * @return boolean
	 */
	protected function retrieve($idPrivacyStatus)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".privacy_status ";
		$sql .= "WHERE idprivacy_status = :IDPRIVACY_STATUS ";
		$db->setParam("IDPRIVACY_STATUS", $idPrivacyStatus);
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
	 * Methods add object of class PrivacyStatus
	 * insert record into table privacy_status
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".privacy_status(name) ";
		$sql .= "VALUES(:NAME) ";
		$db->setParam("NAME",$this->getName());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdPrivacyStatus($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10702 Dodanie rekordu do tablicy privacy_status nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class PrivacyStatus
	 * update record in table privacy_status
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".privacy_status ";
		$sql .= "SET name = :NAME ";
		$sql .= "WHERE idprivacy_status = :IDPRIVACYSTATUS ";
		$db->setParam("IDPRIVACYSTATUS",$this->getIdPrivacyStatus());
		$db->setParam("NAME",$this->getName());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10703 Zmiana rekordu w tablicy privacy_status nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class PrivacyStatus
	 * removed are record from table privacy_status
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".privacy_status ";
		$sql .= "WHERE idprivacy_status = :IDPRIVACY_STATUS ";
		$db->setParam("IDPRIVACY_STATUS", $this->getIdPrivacyStatus());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10704 Delete record from table privacy_status fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class PrivacyStatus from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdPrivacyStatus($db->f("idprivacy_status"));
		$this->setName($db->f("name"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
}
?>