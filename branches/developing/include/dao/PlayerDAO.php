<?php
/**
 * Created on 09-02-2014 11:22:58
 * @author Tomasz Gajewski
 * @package PHPPlanningPoker
 * error prefix PP:105
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class PlayerDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idPlayer = null;
	protected $idTable = null;
	protected $idRole = null;
	protected $idUser = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	protected $gamesForPlayer = null;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idPlayer
	 */
	protected function __construct($idPlayer = null)
	{
		if(!is_null($idPlayer))
		{
			if(!$this->retrieve($idPlayer))
			{
				throw new Exception("PP:10501 " . DB_SCHEMA . ".player(" . $idPlayer . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idPlayer
	 * @return Player
	 */
	static function get($idPlayer = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idPlayer))
		{
			if(!isset(self::$instance[$idPlayer]))
			{
				self::$instance[$idPlayer] = new Player($idPlayer);
			}
			return self::$instance[$idPlayer];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Player();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Player $player)
	{
		$key = array_search($player,self::$instance,true);
		if($key !== false)
		{
			if($key !== $player->getIdPlayer())
			{
				unset(self::$instance[$key]);
				self::$instance[$player->getIdPlayer()] = $player;
			}
		}
		else
		{
			self::$instance[$player->getIdPlayer()] = $player;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Player
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idplayer");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Player();
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
	protected function setIdPlayer($idPlayer)
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
	public function setIdRole($idRole)
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
	public function getIdRole()
	{
		return $this->idRole;
	}
	// -------------------------------------------------------------------------
	public function getIdUser()
	{
		return $this->idUser;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdPlayer();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Game
	 * @return Collection &lt;Game&gt; 
	 */
	public function getGamesForPlayer()
	{
		if(is_null($this->gamesForPlayer))
		{
			$this->gamesForPlayer = Game::getAllByPlayer($this);
		}
		return $this->gamesForPlayer;
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
	 * @return Role
	 */
	public function getRole()
	{
		return Role::get($this->getIdRole());
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
	 * Method read object of class Player you can read all of atrib by get...() function
	 * select record from table player
	 * @return boolean
	 */
	protected function retrieve($idPlayer)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$db->setParam("IDPLAYER", $idPlayer);
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
	 * Methods add object of class Player
	 * insert record into table player
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".player(idtable, idrole, iduser) ";
		$sql .= "VALUES(:IDTABLE, :IDROLE, :IDUSER) ";
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("IDROLE",$this->getIdRole());
		$db->setParam("IDUSER",$this->getIdUser());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdPlayer($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10502 Dodanie rekordu do tablicy player nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Player
	 * update record in table player
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".player ";
		$sql .= "SET idtable = :IDTABLE ";
		$sql .= " , idrole = :IDROLE ";
		$sql .= " , iduser = :IDUSER ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$db->setParam("IDPLAYER",$this->getIdPlayer());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("IDROLE",$this->getIdRole());
		$db->setParam("IDUSER",$this->getIdUser());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10503 Zmiana rekordu w tablicy player nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Player
	 * removed are record from table player
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$db->setParam("IDPLAYER", $this->getIdPlayer());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10504 Delete record from table player fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Player from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdPlayer($db->f("idplayer"));
		$this->setIdTable($db->f("idtable"));
		$this->setIdRole($db->f("idrole"));
		$this->setIdUser($db->f("iduser"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Player
	 * @return Collection &lt;Player&gt; 
	 */
	public static function getAllByTable(TableDAO $table)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $table->getIdTable());
		$db->query($sql);
		return new Collection($db, Player::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Player
	 * @return Collection &lt;Player&gt; 
	 */
	public static function getAllByRole(RoleDAO $role)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE idrole = :IDROLE ";
		$db->setParam("IDROLE", $role->getIdRole());
		$db->query($sql);
		return new Collection($db, Player::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Player
	 * @return Collection &lt;Player&gt; 
	 */
	public static function getAllByUser(UserDAO $user)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER", $user->getIdUser());
		$db->query($sql);
		return new Collection($db, Player::get());
	}
	// -------------------------------------------------------------------------
}
?>