<?php
/**
 * Created on 21-04-2014 22:24:23
 * @author Tomasz Gajewski
 * @package PHPPlanningPoker
 * error prefix PP:108
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class RoleDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idRole = null;
	protected $name = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	protected $playersForRole = null;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idRole
	 */
	protected function __construct($idRole = null)
	{
		if(!is_null($idRole))
		{
			if(!$this->retrieve($idRole))
			{
				throw new Exception("PP:10801 " . DB_SCHEMA . ".role(" . $idRole . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idRole
	 * @return Role
	 */
	static function get($idRole = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idRole))
		{
			if(!isset(self::$instance[$idRole]))
			{
				self::$instance[$idRole] = new Role($idRole);
			}
			return self::$instance[$idRole];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Role();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Role $role)
	{
		$key = array_search($role,self::$instance,true);
		if($key !== false)
		{
			if($key !== $role->getIdRole())
			{
				unset(self::$instance[$key]);
				self::$instance[$role->getIdRole()] = $role;
			}
		}
		else
		{
			self::$instance[$role->getIdRole()] = $role;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Role
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idrole");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Role();
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
	protected function setIdRole($idRole)
	{
		if(is_numeric($idRole))
		{
			$this->idRole = round($idRole,0);
		}
		else
		{
			$this->idRole = null;
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
	public function getIdRole()
	{
		return $this->idRole;
	}
	// -------------------------------------------------------------------------
	public function getName()
	{
		return $this->name;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdRole();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Player
	 * @return Collection &lt;Player&gt; 
	 */
	public function getPlayersForRole()
	{
		if(is_null($this->playersForRole))
		{
			$this->playersForRole = Player::getAllByRole($this);
		}
		return $this->playersForRole;
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Role you can read all of atrib by get...() function
	 * select record from table role
	 * @return boolean
	 */
	protected function retrieve($idRole)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".role ";
		$sql .= "WHERE idrole = :IDROLE ";
		$db->setParam("IDROLE", $idRole);
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
	 * Methods add object of class Role
	 * insert record into table role
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".role(name) ";
		$sql .= "VALUES(:NAME) ";
		$db->setParam("NAME",$this->getName());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdRole($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10802 Dodanie rekordu do tablicy role nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Role
	 * update record in table role
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".role ";
		$sql .= "SET name = :NAME ";
		$sql .= "WHERE idrole = :IDROLE ";
		$db->setParam("IDROLE",$this->getIdRole());
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
			AddAlert("PP:10803 Zmiana rekordu w tablicy role nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Role
	 * removed are record from table role
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".role ";
		$sql .= "WHERE idrole = :IDROLE ";
		$db->setParam("IDROLE", $this->getIdRole());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10804 Delete record from table role fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Role from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdRole($db->f("idrole"));
		$this->setName($db->f("name"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
}
?>