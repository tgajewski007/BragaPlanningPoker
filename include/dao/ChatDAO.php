<?php
/**
 * Created on 21-04-2014 22:24:22
 * @author Tomasz Gajewski
 * @package PHPPlanningPoker
 * error prefix PP:102
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class ChatDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idChat = null;
	protected $idUser = null;
	protected $idTable = null;
	protected $message = null;
	protected $date = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idChat
	 */
	protected function __construct($idChat = null)
	{
		if(!is_null($idChat))
		{
			if(!$this->retrieve($idChat))
			{
				throw new Exception("PP:10201 " . DB_SCHEMA . ".chat(" . $idChat . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idChat
	 * @return Chat
	 */
	static function get($idChat = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idChat))
		{
			if(!isset(self::$instance[$idChat]))
			{
				self::$instance[$idChat] = new Chat($idChat);
			}
			return self::$instance[$idChat];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Chat();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Chat $chat)
	{
		$key = array_search($chat,self::$instance,true);
		if($key !== false)
		{
			if($key !== $chat->getIdChat())
			{
				unset(self::$instance[$key]);
				self::$instance[$chat->getIdChat()] = $chat;
			}
		}
		else
		{
			self::$instance[$chat->getIdChat()] = $chat;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Chat
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idchat");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Chat();
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
	protected function setIdChat($idChat)
	{
		if(is_numeric($idChat))
		{
			$this->idChat = round($idChat,0);
		}
		else
		{
			$this->idChat = null;
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
	public function setMessage($message)
	{
		if(empty($message))
		{
			$this->message = null;
		}
		else
		{
			$this->message = mb_substr($message,0,255);
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
	public function getIdChat()
	{
		return $this->idChat;
	}
	// -------------------------------------------------------------------------
	public function getIdUser()
	{
		return $this->idUser;
	}
	// -------------------------------------------------------------------------
	public function getIdTable()
	{
		return $this->idTable;
	}
	// -------------------------------------------------------------------------
	public function getMessage()
	{
		return $this->message;
	}
	// -------------------------------------------------------------------------
	public function getDate()
	{
		return $this->date;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdChat();
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
	 * @return Table
	 */
	public function getTable()
	{
		return Table::get($this->getIdTable());
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Chat you can read all of atrib by get...() function
	 * select record from table chat
	 * @return boolean
	 */
	protected function retrieve($idChat)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".chat ";
		$sql .= "WHERE idchat = :IDCHAT ";
		$db->setParam("IDCHAT", $idChat);
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
	 * Methods add object of class Chat
	 * insert record into table chat
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".chat(iduser, idtable, message, date) ";
		$sql .= "VALUES(:IDUSER, :IDTABLE, :MESSAGE, :DATE) ";
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("MESSAGE",$this->getMessage());
		$db->setParam("DATE",$this->getDate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdChat($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10202 Dodanie rekordu do tablicy chat nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Chat
	 * update record in table chat
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".chat ";
		$sql .= "SET iduser = :IDUSER ";
		$sql .= " , idtable = :IDTABLE ";
		$sql .= " , message = :MESSAGE ";
		$sql .= " , date = :DATE ";
		$sql .= "WHERE idchat = :IDCHAT ";
		$db->setParam("IDCHAT",$this->getIdChat());
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("IDTABLE",$this->getIdTable());
		$db->setParam("MESSAGE",$this->getMessage());
		$db->setParam("DATE",$this->getDate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10203 Zmiana rekordu w tablicy chat nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Chat
	 * removed are record from table chat
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".chat ";
		$sql .= "WHERE idchat = :IDCHAT ";
		$db->setParam("IDCHAT", $this->getIdChat());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10204 Delete record from table chat fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Chat from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdChat($db->f("idchat"));
		$this->setIdUser($db->f("iduser"));
		$this->setIdTable($db->f("idtable"));
		$this->setMessage($db->f("message"));
		$this->setDate($db->f("date"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Chat
	 * @return Collection &lt;Chat&gt; 
	 */
	public static function getAllByUser(UserDAO $user)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".chat ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER", $user->getIdUser());
		$db->query($sql);
		return new Collection($db, Chat::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  Chat
	 * @return Collection &lt;Chat&gt; 
	 */
	public static function getAllByTable(TableDAO $table)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".chat ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$db->setParam("IDTABLE", $table->getIdTable());
		$db->query($sql);
		return new Collection($db, Chat::get());
	}
	// -------------------------------------------------------------------------
}
?>