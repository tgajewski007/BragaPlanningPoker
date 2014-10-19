<?php
/**
 * Created on 19-10-2014 13:16:07
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:109
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class TableDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idTable = null;
	protected $name = null;
	protected $startDate = null;
	protected $password = null;
	protected $idTask = null;
	protected $idPrivacyStatus = null;
	protected $closeDate = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param string $idTable
	 */
	protected function __construct($idTable = null)
	{
		if(!is_null($idTable))
		{
			if(!$this->retrieve($idTable))
			{
				throw new Exception("PP:10901 " . DB_SCHEMA . ".table(" . $idTable . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idTable
	 * @return Table
	 */
	static function get($idTable = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(!empty($idTable))
		{
			if(!isset(self::$instance[$idTable]))
			{
				self::$instance[$idTable] = new Table($idTable);
			}
			return self::$instance[$idTable];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Table();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Table $table)
	{
		$key = array_search($table,self::$instance,true);
		if($key !== false)
		{
			if($key !== $table->getIdTable())
			{
				unset(self::$instance[$key]);
				self::$instance[$table->getIdTable()] = $table;
			}
		}
		else
		{
			self::$instance[$table->getIdTable()] = $table;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Table
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idtable");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Table();
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
	public function setIdTable($idTable)
	{
		if(empty($idTable))
		{
			$this->idTable = null;
		}
		else
		{
			$this->idTable = mb_substr($idTable,0,32);
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
	public function setStartDate($startDate)
	{
		if(empty($startDate))
		{
			$this->startDate = null;
		}
		else
		{
			$this->startDate = date(PHP_DATETIME_FORMAT,strtotime($startDate));
		}
	}
	// -------------------------------------------------------------------------
	public function setPassword($password)
	{
		if(empty($password))
		{
			$this->password = null;
		}
		else
		{
			$this->password = mb_substr($password,0,40);
		}
	}
	// -------------------------------------------------------------------------
	public function setIdTask($idTask)
	{
		if(is_numeric($idTask))
		{
			$this->idTask = round($idTask,0);
		}
		else
		{
			$this->idTask = null;
		}
	}
	// -------------------------------------------------------------------------
	public function setIdPrivacyStatus($idPrivacyStatus)
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
	public function setCloseDate($closeDate)
	{
		if(empty($closeDate))
		{
			$this->closeDate = null;
		}
		else
		{
			$this->closeDate = date(PHP_DATETIME_FORMAT,strtotime($closeDate));
		}
	}
	// -------------------------------------------------------------------------
	public function getIdTable()
	{
		return $this->idTable;
	}
	// -------------------------------------------------------------------------
	public function getName()
	{
		return $this->name;
	}
	// -------------------------------------------------------------------------
	public function getStartDate()
	{
		return $this->startDate;
	}
	// -------------------------------------------------------------------------
	public function getPassword()
	{
		return $this->password;
	}
	// -------------------------------------------------------------------------
	public function getIdTask()
	{
		return $this->idTask;
	}
	// -------------------------------------------------------------------------
	public function getIdPrivacyStatus()
	{
		return $this->idPrivacyStatus;
	}
	// -------------------------------------------------------------------------
	public function getCloseDate()
	{
		return $this->closeDate;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdTable();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Chat
	 * @return Collection &lt;Chat&gt; 
	 */
	public function getChatsForTable()
	{
		return Chat::getAllByTable($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Game
	 * @return Collection &lt;Game&gt; 
	 */
	public function getGamesForTable()
	{
		return Game::getAllByTable($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Player
	 * @return Collection &lt;Player&gt; 
	 */
	public function getPlayersForTable()
	{
		return Player::getAllByTable($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Task
	 * @return Collection &lt;Task&gt; 
	 */
	public function getTasksForTable()
	{
		return Task::getAllByTable($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * @return PrivacyStatus
	 */
	public function getPrivacyStatus()
	{
		return PrivacyStatus::get($this->getIdPrivacyStatus());
	}
	// -------------------------------------------------------------------------
	/**
	 * @return Task
	 */
	public function getTask()
	{
		return Task::get($this->getIdTask());
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Table you can read all of atrib by get...() function
	 * select record from table table
	 * @return boolean
	 */
	protected function retrieve($idTable)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".table ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $idTable);
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
	 * Methods add object of class Table
	 * insert record into table table
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".table(idtable, name, start_date, password, idtask, idprivacy_status, close_date) ";
		$sql .= "VALUES(:IDTABLE, :NAME, :STARTDATE, :PASSWORD, :IDTASK, :IDPRIVACYSTATUS, :CLOSEDATE) ";
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("NAME",$this->getName());
		$db->setParam("STARTDATE",$this->getStartDate());
		$db->setParam("PASSWORD",$this->getPassword());
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("IDPRIVACYSTATUS",$this->getIdPrivacyStatus());
		$db->setParam("CLOSEDATE",$this->getCloseDate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10902 Dodanie rekordu do tablicy table nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Table
	 * update record in table table
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".table ";
		$sql .= "SET name = :NAME ";
		$sql .= " , start_date = :STARTDATE ";
		$sql .= " , password = :PASSWORD ";
		$sql .= " , idtask = :IDTASK ";
		$sql .= " , idprivacy_status = :IDPRIVACYSTATUS ";
		$sql .= " , close_date = :CLOSEDATE ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("NAME",$this->getName());
		$db->setParam("STARTDATE",$this->getStartDate());
		$db->setParam("PASSWORD",$this->getPassword());
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("IDPRIVACYSTATUS",$this->getIdPrivacyStatus());
		$db->setParam("CLOSEDATE",$this->getCloseDate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10903 Zmiana rekordu w tablicy table nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Table
	 * removed are record from table table
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".table ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $this->getIdTable());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10904 Delete record from table table fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Table from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdTable($db->f("idtable"));
		$this->setName($db->f("name"));
		$this->setStartDate($db->f("start_date"));
		$this->setPassword($db->f("password"));
		$this->setIdTask($db->f("idtask"));
		$this->setIdPrivacyStatus($db->f("idprivacy_status"));
		$this->setCloseDate($db->f("close_date"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Table
	 * @return Collection &lt;Table&gt; 
	 */
	public static function getAllByPrivacyStatus(PrivacyStatusDAO $privacyStatus)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".table ";
		$sql .= "WHERE idprivacy_status = :IDPRIVACY_STATUS ";
		$db->setParam("IDPRIVACY_STATUS", $privacyStatus->getIdPrivacyStatus());
		$db->query($sql);
		return new Collection($db, Table::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Table
	 * @return Collection &lt;Table&gt; 
	 */
	public static function getAllByTask(TaskDAO $task)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".table ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK", $task->getIdTask());
		$db->query($sql);
		return new Collection($db, Table::get());
	}
	// -------------------------------------------------------------------------
}
?>