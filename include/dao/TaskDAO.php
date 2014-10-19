<?php
/**
 * Created on 19-10-2014 21:35:18
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:110
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class TaskDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idTask = null;
	protected $subject = null;
	protected $url = null;
	protected $idCard = null;
	protected $idTable = null;
	protected $lastUpdate = null;
	protected $idPlayer = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idTask
	 */
	protected function __construct($idTask = null)
	{
		if(!is_null($idTask))
		{
			if(!$this->retrieve($idTask))
			{
				throw new Exception("PP:11001 " . DB_SCHEMA . ".task(" . $idTask . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idTask
	 * @return Task
	 */
	static function get($idTask = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idTask))
		{
			if(!isset(self::$instance[$idTask]))
			{
				self::$instance[$idTask] = new Task($idTask);
			}
			return self::$instance[$idTask];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Task();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Task $task)
	{
		$key = array_search($task,self::$instance,true);
		if($key !== false)
		{
			if($key !== $task->getIdTask())
			{
				unset(self::$instance[$key]);
				self::$instance[$task->getIdTask()] = $task;
			}
		}
		else
		{
			self::$instance[$task->getIdTask()] = $task;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Task
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idtask");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Task();
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
	protected function setIdTask($idTask)
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
	public function setSubject($subject)
	{
		if(empty($subject))
		{
			$this->subject = null;
		}
		else
		{
			$this->subject = mb_substr($subject,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setUrl($url)
	{
		if(empty($url))
		{
			$this->url = null;
		}
		else
		{
			$this->url = mb_substr($url,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setIdCard($idCard)
	{
		if(is_numeric($idCard))
		{
			$this->idCard = round($idCard,0);
		}
		else
		{
			$this->idCard = null;
		}
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
	public function setLastUpdate($lastUpdate)
	{
		if(empty($lastUpdate))
		{
			$this->lastUpdate = null;
		}
		else
		{
			$this->lastUpdate = date(PHP_DATETIME_FORMAT,strtotime($lastUpdate));
		}
	}
	// -------------------------------------------------------------------------
	public function setIdPlayer($idPlayer)
	{
		if(is_numeric($idPlayer))
		{
			$this->idPlayer = round($idPlayer,0);
		}
		else
		{
			$this->idPlayer = null;
		}
	}
	// -------------------------------------------------------------------------
	public function getIdTask()
	{
		return $this->idTask;
	}
	// -------------------------------------------------------------------------
	public function getSubject()
	{
		return $this->subject;
	}
	// -------------------------------------------------------------------------
	public function getUrl()
	{
		return $this->url;
	}
	// -------------------------------------------------------------------------
	public function getIdCard()
	{
		return $this->idCard;
	}
	// -------------------------------------------------------------------------
	public function getIdTable()
	{
		return $this->idTable;
	}
	// -------------------------------------------------------------------------
	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}
	// -------------------------------------------------------------------------
	public function getIdPlayer()
	{
		return $this->idPlayer;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdTask();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Game
	 * @return Collection &lt;Game&gt; 
	 */
	public function getGamesForTask()
	{
		return Game::getAllByTask($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Table
	 * @return Collection &lt;Table&gt; 
	 */
	public function getTablesForTask()
	{
		return Table::getAllByTask($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * @return Card
	 */
	public function getCard()
	{
		return Card::get($this->getIdCard());
	}
	// -------------------------------------------------------------------------
	/**
	 * @return Table
	 */
	public function getTable()
	{
		return Table::get($this->getIdTable());
	}
	// -------------------------------------------------------------------------
	/**
	 * @return Player
	 */
	public function getPlayer()
	{
		return Player::get($this->getIdPlayer());
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Task you can read all of atrib by get...() function
	 * select record from table task
	 * @return boolean
	 */
	protected function retrieve($idTask)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK", $idTask);
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
	 * Methods add object of class Task
	 * insert record into table task
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".task(subject, url, idcard, idtable, last_update, idplayer) ";
		$sql .= "VALUES(:SUBJECT, :URL, :IDCARD, :IDTABLE, :LASTUPDATE, :IDPLAYER) ";
		$db->setParam("SUBJECT",$this->getSubject());
		$db->setParam("URL",$this->getUrl());
		$db->setParam("IDCARD",$this->getIdCard());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("LASTUPDATE",$this->getLastUpdate());
		$db->setParam("IDPLAYER",$this->getIdPlayer());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdTask($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11002 Dodanie rekordu do tablicy task nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Task
	 * update record in table task
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".task ";
		$sql .= "SET subject = :SUBJECT ";
		$sql .= " , url = :URL ";
		$sql .= " , idcard = :IDCARD ";
		$sql .= " , idtable = :IDTABLE ";
		$sql .= " , last_update = :LASTUPDATE ";
		$sql .= " , idplayer = :IDPLAYER ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("SUBJECT",$this->getSubject());
		$db->setParam("URL",$this->getUrl());
		$db->setParam("IDCARD",$this->getIdCard());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("LASTUPDATE",$this->getLastUpdate());
		$db->setParam("IDPLAYER",$this->getIdPlayer());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11003 Zmiana rekordu w tablicy task nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Task
	 * removed are record from table task
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK", $this->getIdTask());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11004 Delete record from table task fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Task from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdTask($db->f("idtask"));
		$this->setSubject($db->f("subject"));
		$this->setUrl($db->f("url"));
		$this->setIdCard($db->f("idcard"));
		$this->setIdTable($db->f("idtable"));
		$this->setLastUpdate($db->f("last_update"));
		$this->setIdPlayer($db->f("idplayer"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Task
	 * @return Collection &lt;Task&gt; 
	 */
	public static function getAllByCard(CardDAO $card)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idcard = :IDCARD ";
		$db->setParam("IDCARD", $card->getIdCard());
		$db->query($sql);
		return new Collection($db, Task::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Task
	 * @return Collection &lt;Task&gt; 
	 */
	public static function getAllByTable(TableDAO $table)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $table->getIdTable());
		$db->query($sql);
		return new Collection($db, Task::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Task
	 * @return Collection &lt;Task&gt; 
	 */
	public static function getAllByPlayer(PlayerDAO $player)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$db->setParam("IDPLAYER", $player->getIdPlayer());
		$db->query($sql);
		return new Collection($db, Task::get());
	}
	// -------------------------------------------------------------------------
}
?>