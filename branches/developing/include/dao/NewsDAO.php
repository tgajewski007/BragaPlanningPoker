<?php
/**
 * Created on 19-10-2014 13:16:07
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:105
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class NewsDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idNews = null;
	protected $url = null;
	protected $title = null;
	protected $content = null;
	protected $userIduser = null;
	protected $createData = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idNews
	 */
	protected function __construct($idNews = null)
	{
		if(!is_null($idNews))
		{
			if(!$this->retrieve($idNews))
			{
				throw new Exception("PP:10501 " . DB_SCHEMA . ".news(" . $idNews . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idNews
	 * @return News
	 */
	static function get($idNews = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idNews))
		{
			if(!isset(self::$instance[$idNews]))
			{
				self::$instance[$idNews] = new News($idNews);
			}
			return self::$instance[$idNews];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new News();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(News $news)
	{
		$key = array_search($news,self::$instance,true);
		if($key !== false)
		{
			if($key !== $news->getIdNews())
			{
				unset(self::$instance[$key]);
				self::$instance[$news->getIdNews()] = $news;
			}
		}
		else
		{
			self::$instance[$news->getIdNews()] = $news;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return News
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idnews");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new News();
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
	protected function setIdNews($idNews)
	{
		if(is_numeric($idNews))
		{
			$this->idNews = round($idNews,0);
		}
		else
		{
			$this->idNews = null;
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
			$this->url = mb_substr($url,0,50);
		}
	}
	// -------------------------------------------------------------------------
	public function setTitle($title)
	{
		if(empty($title))
		{
			$this->title = null;
		}
		else
		{
			$this->title = mb_substr($title,0,255);
		}
	}
	// -------------------------------------------------------------------------
	public function setContent($content)
	{
		$this->content = $content;
	}
	// -------------------------------------------------------------------------
	public function setUserIduser($userIduser)
	{
		if(empty($userIduser))
		{
			$this->userIduser = null;
		}
		else
		{
			$this->userIduser = mb_substr($userIduser,0,32);
		}
	}
	// -------------------------------------------------------------------------
	public function setCreateData($createData)
	{
		if(empty($createData))
		{
			$this->createData = null;
		}
		else
		{
			$this->createData = date(PHP_DATE_FORMAT,strtotime($createData));
		}
	}
	// -------------------------------------------------------------------------
	public function getIdNews()
	{
		return $this->idNews;
	}
	// -------------------------------------------------------------------------
	public function getUrl()
	{
		return $this->url;
	}
	// -------------------------------------------------------------------------
	public function getTitle()
	{
		return $this->title;
	}
	// -------------------------------------------------------------------------
	public function getContent()
	{
		return $this->content;
	}
	// -------------------------------------------------------------------------
	public function getUserIduser()
	{
		return $this->userIduser;
	}
	// -------------------------------------------------------------------------
	public function getCreateData()
	{
		return $this->createData;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdNews();
	}
	// -------------------------------------------------------------------------
	/**
	 * @return User
	 */
	public function getUser()
	{
		return User::get($this->getUserIduser());
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class News you can read all of atrib by get...() function
	 * select record from table news
	 * @return boolean
	 */
	protected function retrieve($idNews)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".news ";
		$sql .= "WHERE idnews = :IDNEWS ";
		$db->setParam("IDNEWS", $idNews);
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
	 * Methods add object of class News
	 * insert record into table news
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".news(url, title, content, user_iduser, create_data) ";
		$sql .= "VALUES(:URL, :TITLE, :CONTENT, :USERIDUSER, :CREATEDATA) ";
		$db->setParam("URL",$this->getUrl());
		$db->setParam("TITLE",$this->getTitle());
		$db->setParam("CONTENT",$this->getContent());
		$db->setParam("USERIDUSER",$this->getUserIduser());
		$db->setParam("CREATEDATA",$this->getCreateData());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdNews($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10502 Dodanie rekordu do tablicy news nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class News
	 * update record in table news
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".news ";
		$sql .= "SET url = :URL ";
		$sql .= " , title = :TITLE ";
		$sql .= " , content = :CONTENT ";
		$sql .= " , user_iduser = :USERIDUSER ";
		$sql .= " , create_data = :CREATEDATA ";
		$sql .= "WHERE idnews = :IDNEWS ";
		$db->setParam("IDNEWS",$this->getIdNews());
		$db->setParam("URL",$this->getUrl());
		$db->setParam("TITLE",$this->getTitle());
		$db->setParam("CONTENT",$this->getContent());
		$db->setParam("USERIDUSER",$this->getUserIduser());
		$db->setParam("CREATEDATA",$this->getCreateData());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10503 Zmiana rekordu w tablicy news nie powiodło się");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class News
	 * removed are record from table news
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".news ";
		$sql .= "WHERE idnews = :IDNEWS ";
		$db->setParam("IDNEWS", $this->getIdNews());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10504 Delete record from table news fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class News from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdNews($db->f("idnews"));
		$this->setUrl($db->f("url"));
		$this->setTitle($db->f("title"));
		$this->setContent($db->f("content"));
		$this->setUserIduser($db->f("user_iduser"));
		$this->setCreateData($db->f("create_data"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of  News
	 * @return Collection &lt;News&gt; 
	 */
	public static function getAllByUser(UserDAO $user)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".news ";
		$sql .= "WHERE user_iduser = :USER_IDUSER ";
		$db->setParam("USER_IDUSER", $user->getIdUser());
		$db->query($sql);
		return new Collection($db, News::get());
	}
	// -------------------------------------------------------------------------
}
?>