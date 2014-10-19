<?php
/**
 * Created on 19-10-2014 21:35:18
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:103
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class GameDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idGame = null;
	protected $idPlayer = null;
	protected $idTable = null;
	protected $idCard = null;
	protected $idTask = null;
	protected $date = null;
	protected $status = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idGame
	 */
	protected function __construct($idGame = null)
	{
		if(!is_null($idGame))
		{
			if(!$this->retrieve($idGame))
			{
				throw new Exception("PP:10301 " . DB_SCHEMA . ".game(" . $idGame . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idGame
	 * @return Game
	 */
	static function get($idGame = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idGame))
		{
			if(!isset(self::$instance[$idGame]))
			{
				self::$instance[$idGame] = new Game($idGame);
			}
			return self::$instance[$idGame];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Game();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Game $game)
	{
		$key = array_search($game,self::$instance,true);
		if($key !== false)
		{
			if($key !== $game->getIdGame())
			{
				unset(self::$instance[$key]);
				self::$instance[$game->getIdGame()] = $game;
			}
		}
		else
		{
			self::$instance[$game->getIdGame()] = $game;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Game
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idgame");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Game();
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
	protected function setIdGame($idGame)
	{
		if(is_numeric($idGame))
		{
			$this->idGame = round($idGame,0);
		}
		else
		{
			$this->idGame = null;
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
	public function setDate($date)
	{
		if(empty($date))
		{
			$this->date = null;
		}
		else
		{
			$this->date = date(PHP_DATETIME_FORMAT,strtotime($date));
		}
	}
	// -------------------------------------------------------------------------
	public function setStatus($status)
	{
		$this->status = $status;
	}
	// -------------------------------------------------------------------------
	public function getIdGame()
	{
		return $this->idGame;
	}
	// -------------------------------------------------------------------------
	public function getIdPlayer()
	{
		return $this->idPlayer;
	}
	// -------------------------------------------------------------------------
	public function getIdTable()
	{
		return $this->idTable;
	}
	// -------------------------------------------------------------------------
	public function getIdCard()
	{
		return $this->idCard;
	}
	// -------------------------------------------------------------------------
	public function getIdTask()
	{
		return $this->idTask;
	}
	// -------------------------------------------------------------------------
	public function getDate()
	{
		return $this->date;
	}
	// -------------------------------------------------------------------------
	public function getStatus()
	{
		return $this->status;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdGame();
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
	 * @return Task
	 */
	public function getTask()
	{
		return Task::get($this->getIdTask());
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
	 * Method read object of class Game you can read all of atrib by get...() function
	 * select record from table game
	 * @return boolean
	 */
	protected function retrieve($idGame)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idgame = :IDGAME ";
		$db->setParam("IDGAME", $idGame);
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
	 * Methods add object of class Game
	 * insert record into table game
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".game(idplayer, idtable, idcard, idtask, date, status) ";
		$sql .= "VALUES(:IDPLAYER, :IDTABLE, :IDCARD, :IDTASK, :DATE, :STATUS) ";
		$db->setParam("IDPLAYER",$this->getIdPlayer());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("IDCARD",$this->getIdCard());
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("DATE",$this->getDate());
		$db->setParam("STATUS",$this->getStatus());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdGame($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10302 Dodanie rekordu do tablicy game nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Game
	 * update record in table game
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".game ";
		$sql .= "SET idplayer = :IDPLAYER ";
		$sql .= " , idtable = :IDTABLE ";
		$sql .= " , idcard = :IDCARD ";
		$sql .= " , idtask = :IDTASK ";
		$sql .= " , date = :DATE ";
		$sql .= " , status = :STATUS ";
		$sql .= "WHERE idgame = :IDGAME ";
		$db->setParam("IDGAME",$this->getIdGame());
		$db->setParam("IDPLAYER",$this->getIdPlayer());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("IDCARD",$this->getIdCard());
		$db->setParam("IDTASK",$this->getIdTask());
		$db->setParam("DATE",$this->getDate());
		$db->setParam("STATUS",$this->getStatus());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10303 Zmiana rekordu w tablicy game nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Game
	 * removed are record from table game
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idgame = :IDGAME ";
		$db->setParam("IDGAME", $this->getIdGame());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10304 Delete record from table game fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Game from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdGame($db->f("idgame"));
		$this->setIdPlayer($db->f("idplayer"));
		$this->setIdTable($db->f("idtable"));
		$this->setIdCard($db->f("idcard"));
		$this->setIdTask($db->f("idtask"));
		$this->setDate($db->f("date"));
		$this->setStatus($db->f("status"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Game
	 * @return Collection &lt;Game&gt; 
	 */
	public static function getAllByCard(CardDAO $card)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idcard = :IDCARD ";
		$db->setParam("IDCARD", $card->getIdCard());
		$db->query($sql);
		return new Collection($db, Game::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Game
	 * @return Collection &lt;Game&gt; 
	 */
	public static function getAllByTask(TaskDAO $task)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idtask = :IDTASK ";
		$db->setParam("IDTASK", $task->getIdTask());
		$db->query($sql);
		return new Collection($db, Game::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Game
	 * @return Collection &lt;Game&gt; 
	 */
	public static function getAllByTable(TableDAO $table)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $table->getIdTable());
		$db->query($sql);
		return new Collection($db, Game::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Game
	 * @return Collection &lt;Game&gt; 
	 */
	public static function getAllByPlayer(PlayerDAO $player)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$db->setParam("IDPLAYER", $player->getIdPlayer());
		$db->query($sql);
		return new Collection($db, Game::get());
	}
	// -------------------------------------------------------------------------
}
?>