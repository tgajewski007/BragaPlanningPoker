<?php
/**
 * Created on 04-02-2014 08:20:35
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:109
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
	protected $href = null;
	protected $idCard = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	protected $gamesForTask = null;
	protected $tablesForSessionTask = null;
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
				throw new Exception("PP:10901 " . DB_SCHEMA . ".task(" . $idTask . ")  does not exists");
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
	public function setHref($href)
	{
		if(empty($href))
		{
			$this->href = null;
		}
		else
		{
			$this->href = mb_substr($href,0,255);
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
	public function getHref()
	{
		return $this->href;
	}
	// -------------------------------------------------------------------------
	public function getIdCard()
	{
		return $this->idCard;
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
		if(is_null($this->gamesForTask))
		{
			$this->gamesForTask = Game::getAllByTask($this);
		}
		return $this->gamesForTask;
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Table
	 * @return Collection &lt;Table&gt; 
	 */
	public function getTablesForSessionTask()
	{
		if(is_null($this->tablesForSessionTask))
		{
			$this->tablesForSessionTask = Table::getAllBySessionTask($this);
		}
		return $this->tablesForSessionTask;
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
		$sql  = "INSERT INTO " . DB_SCHEMA . ".task(subject, href, idcard) ";
		$sql .= "VALUES(:SUBJECT, :HREF, :IDCARD) ";
		$db->setParam("SUBJECT",$this->getSubject());
		$db->setParam("HREF",$this->getHref());
		$db->setParam("IDCARD",$this->getIdCard());
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
			AddAlert("PP:10902 Dodanie rekordu do tablicy task nie powiodło się");
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
		$sql .= " , href = :HREF ";
		$sql .= " , idcard = :IDCARD ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("SUBJECT",$this->getSubject());
		$db->setParam("HREF",$this->getHref());
		$db->setParam("IDCARD",$this->getIdCard());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10903 Zmiana rekordu w tablicy task nie powiodło się");
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
			AddAlert("PP:10904 Delete record from table task fail");
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
		$this->setHref($db->f("href"));
		$this->setIdCard($db->f("idcard"));
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
}
?>