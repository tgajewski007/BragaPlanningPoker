<?php
/**
 * Created on 30-10-2014 20:42:41
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:112
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class WikiDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idWiki = null;
	protected $url = null;
	protected $title = null;
	protected $content = null;
	protected $lastUpdate = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idWiki
	 */
	protected function __construct($idWiki = null)
	{
		if(!is_null($idWiki))
		{
			if(!$this->retrieve($idWiki))
			{
				throw new Exception("PP:11201 " . DB_SCHEMA . ".wiki(" . $idWiki . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idWiki
	 * @return Wiki
	 */
	static function get($idWiki = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idWiki))
		{
			if(!isset(self::$instance[$idWiki]))
			{
				self::$instance[$idWiki] = new Wiki($idWiki);
			}
			return self::$instance[$idWiki];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Wiki();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Wiki $wiki)
	{
		$key = array_search($wiki,self::$instance,true);
		if($key !== false)
		{
			if($key !== $wiki->getIdWiki())
			{
				unset(self::$instance[$key]);
				self::$instance[$wiki->getIdWiki()] = $wiki;
			}
		}
		else
		{
			self::$instance[$wiki->getIdWiki()] = $wiki;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Wiki
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idwiki");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Wiki();
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
	protected function setIdWiki($idWiki)
	{
		if(is_numeric($idWiki))
		{
			$this->idWiki = round($idWiki,0);
		}
		else
		{
			$this->idWiki = null;
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
			$this->url = mb_substr($url,0,45);
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
	public function getIdWiki()
	{
		return $this->idWiki;
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
	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdWiki();
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Wiki you can read all of atrib by get...() function
	 * select record from table wiki
	 * @return boolean
	 */
	protected function retrieve($idWiki)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".wiki ";
		$sql .= "WHERE idwiki = :IDWIKI ";
		$db->setParam("IDWIKI", $idWiki);
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
	 * Methods add object of class Wiki
	 * insert record into table wiki
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".wiki(url, title, content, last_update) ";
		$sql .= "VALUES(:URL, :TITLE, :CONTENT, :LASTUPDATE) ";
		$db->setParam("URL",$this->getUrl());
		$db->setParam("TITLE",$this->getTitle());
		$db->setParam("CONTENT",$this->getContent());
		$db->setParam("LASTUPDATE",$this->getLastUpdate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdWiki($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11202 Insert record into table wiki fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Wiki
	 * update record in table wiki
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".wiki ";
		$sql .= "SET url = :URL ";
		$sql .= " , title = :TITLE ";
		$sql .= " , content = :CONTENT ";
		$sql .= " , last_update = :LASTUPDATE ";
		$sql .= "WHERE idwiki = :IDWIKI ";
		$db->setParam("IDWIKI",$this->getIdWiki());
		$db->setParam("URL",$this->getUrl());
		$db->setParam("TITLE",$this->getTitle());
		$db->setParam("CONTENT",$this->getContent());
		$db->setParam("LASTUPDATE",$this->getLastUpdate());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11203 Update record in table wiki fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Wiki
	 * removed are record from table wiki
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".wiki ";
		$sql .= "WHERE idwiki = :IDWIKI ";
		$db->setParam("IDWIKI", $this->getIdWiki());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:11204 Delete record from table wiki fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Wiki from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdWiki($db->f("idwiki"));
		$this->setUrl($db->f("url"));
		$this->setTitle($db->f("title"));
		$this->setContent($db->f("content"));
		$this->setLastUpdate($db->f("last_update"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
}
?>