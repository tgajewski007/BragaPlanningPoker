<?php
/**
 * Created on 09-02-2014 11:22:58
 * @author Tomasz Gajewski
 * @package PHPPlanningPoker
 * error prefix PP:110
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class UserDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idUser = null;
	protected $userName = null;
	protected $userNameHash = null;
	protected $password = null;
	protected $email = null;
	protected $lastLogin = null;
	protected $passTruePhase = null;
	protected $avatarUrl = null;
	protected $god = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	protected $chatsForUser = null;
	protected $logsForUser = null;
	protected $playersForUser = null;
	// -------------------------------------------------------------------------
	/**
	 * @param string $idUser
	 */
	protected function __construct($idUser = null)
	{
		if(!is_null($idUser))
		{
			if(!$this->retrieve($idUser))
			{
				throw new Exception("PP:11001 " . DB_SCHEMA . ".user(" . $idUser . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idUser
	 * @return User
	 */
	static function get($idUser = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(!empty($idUser))
		{
			if(!isset(self::$instance[$idUser]))
			{
				self::$instance[$idUser] = new User($idUser);
			}
			return self::$instance[$idUser];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new User();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(User $user)
	{
		$key = array_search($user,self::$instance,true);
		if($key !== false)
		{
			if($key !== $user->getIdUser())
			{
				unset(self::$instance[$key]);
				self::$instance[$user->getIdUser()] = $user;
			}
		}
		else
		{
			self::$instance[$user->getIdUser()] = $user;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return User
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("iduser");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new User();
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
	public function setUserName($userName)
	{
		if(empty($userName))
		{
			$this->userName = null;
		}
		else
		{
			$this->userName = mb_substr($userName,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setUserNameHash($userNameHash)
	{
		if(empty($userNameHash))
		{
			$this->userNameHash = null;
		}
		else
		{
			$this->userNameHash = mb_substr($userNameHash,0,40);
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
	public function setEmail($email)
	{
		if(empty($email))
		{
			$this->email = null;
		}
		else
		{
			$this->email = mb_substr($email,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setLastLogin($lastLogin)
	{
		if(empty($lastLogin))
		{
			$this->lastLogin = null;
		}
		else
		{
			$this->lastLogin = date(PHP_DATETIME_FORMAT,strtotime($lastLogin));
		}
	}
	// -------------------------------------------------------------------------
	public function setPassTruePhase($passTruePhase)
	{
		if(empty($passTruePhase))
		{
			$this->passTruePhase = null;
		}
		else
		{
			$this->passTruePhase = mb_substr($passTruePhase,0,32);
		}
	}
	// -------------------------------------------------------------------------
	public function setAvatarUrl($avatarUrl)
	{
		if(empty($avatarUrl))
		{
			$this->avatarUrl = null;
		}
		else
		{
			$this->avatarUrl = mb_substr($avatarUrl,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setGod($god)
	{
		if(is_numeric($god))
		{
			$this->god = round($god,0);
		}
		else
		{
			$this->god = null;
		}
	}
	// -------------------------------------------------------------------------
	public function getIdUser()
	{
		return $this->idUser;
	}
	// -------------------------------------------------------------------------
	public function getUserName()
	{
		return $this->userName;
	}
	// -------------------------------------------------------------------------
	public function getUserNameHash()
	{
		return $this->userNameHash;
	}
	// -------------------------------------------------------------------------
	public function getPassword()
	{
		return $this->password;
	}
	// -------------------------------------------------------------------------
	public function getEmail()
	{
		return $this->email;
	}
	// -------------------------------------------------------------------------
	public function getLastLogin()
	{
		return $this->lastLogin;
	}
	// -------------------------------------------------------------------------
	public function getPassTruePhase()
	{
		return $this->passTruePhase;
	}
	// -------------------------------------------------------------------------
	public function getAvatarUrl()
	{
		return $this->avatarUrl;
	}
	// -------------------------------------------------------------------------
	public function getGod()
	{
		return $this->god;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdUser();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Chat
	 * @return Collection &lt;Chat&gt; 
	 */
	public function getChatsForUser()
	{
		if(is_null($this->chatsForUser))
		{
			$this->chatsForUser = Chat::getAllByUser($this);
		}
		return $this->chatsForUser;
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Log
	 * @return Collection &lt;Log&gt; 
	 */
	public function getLogsForUser()
	{
		if(is_null($this->logsForUser))
		{
			$this->logsForUser = Log::getAllByUser($this);
		}
		return $this->logsForUser;
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Player
	 * @return Collection &lt;Player&gt; 
	 */
	public function getPlayersForUser()
	{
		if(is_null($this->playersForUser))
		{
			$this->playersForUser = Player::getAllByUser($this);
		}
		return $this->playersForUser;
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class User you can read all of atrib by get...() function
	 * select record from table user
	 * @return boolean
	 */
	protected function retrieve($idUser)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".user ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER", $idUser);
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
	 * Methods add object of class User
	 * insert record into table user
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".user(iduser, user_name, user_name_hash, password, email, last_login, pass_true_phase, avatar_url, god) ";
		$sql .= "VALUES(:IDUSER, :USERNAME, :USERNAMEHASH, :PASSWORD, :EMAIL, :LASTLOGIN, :PASSTRUEPHASE, :AVATARURL, :GOD) ";
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("USERNAME",$this->getUserName());
		$db->setParam("USERNAMEHASH",$this->getUserNameHash());
		$db->setParam("PASSWORD",$this->getPassword());
		$db->setParam("EMAIL",$this->getEmail());
		$db->setParam("LASTLOGIN",$this->getLastLogin());
		$db->setParam("PASSTRUEPHASE",$this->getPassTruePhase());
		$db->setParam("AVATARURL",$this->getAvatarUrl());
		$db->setParam("GOD",$this->getGod());
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
			AddAlert("PP:11002 Dodanie rekordu do tablicy user nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class User
	 * update record in table user
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".user ";
		$sql .= "SET user_name = :USERNAME ";
		$sql .= " , user_name_hash = :USERNAMEHASH ";
		$sql .= " , password = :PASSWORD ";
		$sql .= " , email = :EMAIL ";
		$sql .= " , last_login = :LASTLOGIN ";
		$sql .= " , pass_true_phase = :PASSTRUEPHASE ";
		$sql .= " , avatar_url = :AVATARURL ";
		$sql .= " , god = :GOD ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER",$this->getIdUser());
		$db->setParam("USERNAME",$this->getUserName());
		$db->setParam("USERNAMEHASH",$this->getUserNameHash());
		$db->setParam("PASSWORD",$this->getPassword());
		$db->setParam("EMAIL",$this->getEmail());
		$db->setParam("LASTLOGIN",$this->getLastLogin());
		$db->setParam("PASSTRUEPHASE",$this->getPassTruePhase());
		$db->setParam("AVATARURL",$this->getAvatarUrl());
		$db->setParam("GOD",$this->getGod());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11003 Zmiana rekordu w tablicy user nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class User
	 * removed are record from table user
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".user ";
		$sql .= "WHERE iduser = :IDUSER ";
		$db->setParam("IDUSER", $this->getIdUser());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11004 Delete record from table user fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class User from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdUser($db->f("iduser"));
		$this->setUserName($db->f("user_name"));
		$this->setUserNameHash($db->f("user_name_hash"));
		$this->setPassword($db->f("password"));
		$this->setEmail($db->f("email"));
		$this->setLastLogin($db->f("last_login"));
		$this->setPassTruePhase($db->f("pass_true_phase"));
		$this->setAvatarUrl($db->f("avatar_url"));
		$this->setGod($db->f("god"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
}
?>