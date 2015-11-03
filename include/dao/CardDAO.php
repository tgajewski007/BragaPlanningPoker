<?php
/**
 * Created on 30-10-2014 20:42:41
 * @author Tomasz Gajewski
 * @package Poker
 * error prefix PP:101
 * Genreated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/ 
 * Designed by schama CRUD http://wikipedia.org/wiki/CRUD
 * class generated automatically, please do not modify under pain of 
 * OVERWRITTEN WITHOUT WARNING 
 */
class CardDAO
{
	// -------------------------------------------------------------------------
	protected static $instance = array();
	// -------------------------------------------------------------------------
	protected $idCard = null;
	protected $name = null;
	protected $value = null;
	protected $readed = false;
	// -------------------------------------------------------------------------
	/**
	 * @param int $idCard
	 */
	protected function __construct($idCard = null)
	{
		if(!is_null($idCard))
		{
			if(!$this->retrieve($idCard))
			{
				throw new Exception("PP:10101 " . DB_SCHEMA . ".card(" . $idCard . ")  does not exists");
			}
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param int $idCard
	 * @return Card
	 */
	static function get($idCard = null)
	{
		if(count(self::$instance) > 100)
		{
			self::$instance = null;
		}
		if(is_numeric($idCard))
		{
			if(!isset(self::$instance[$idCard]))
			{
				self::$instance[$idCard] = new Card($idCard);
			}
			return self::$instance[$idCard];
		}
		else
		{
			return self::$instance["\$".count(self::$instance)] = new Card();
		}
	}
	// -------------------------------------------------------------------------
	protected static function updateFactoryIndex(Card $card)
	{
		$key = array_search($card,self::$instance,true);
		if($key !== false)
		{
			if($key !== $card->getIdCard())
			{
				unset(self::$instance[$key]);
				self::$instance[$card->getIdCard()] = $card;
			}
		}
		else
		{
			self::$instance[$card->getIdCard()] = $card;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * @param DataSource $db
	 * @return Card
	 */
	static function getByDataSource(DataSource $db)
	{
		$key = $db->f("idcard");
		if(!isset(self::$instance[$key]))
		{
			self::$instance[$key] = new Card();
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
	protected function setIdCard($idCard)
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
	public function setValue($value)
	{
		$this->value = $value;
	}
	// -------------------------------------------------------------------------
	public function getIdCard()
	{
		return $this->idCard;
	}
	// -------------------------------------------------------------------------
	public function getName()
	{
		return $this->name;
	}
	// -------------------------------------------------------------------------
	public function getValue()
	{
		return $this->value;
	}
	// -------------------------------------------------------------------------
	public function getKey()
	{
		return $this->getIdCard();
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Game
	 * @return Collection &lt;Game&gt; 
	 */
	public function getGamesForCard()
	{
		return Game::getAllByCard($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods returns colection of objects Task
	 * @return Collection &lt;Task&gt; 
	 */
	public function getTasksForCard()
	{
		return Task::getAllByCard($this);
	}
	// -------------------------------------------------------------------------
	/**
	 * Method read object of class Card you can read all of atrib by get...() function
	 * select record from table card
	 * @return boolean
	 */
	protected function retrieve($idCard)
	{
		$db = new DB();
		$sql  = "SELECT * FROM " . DB_SCHEMA . ".card ";
		$sql .= "WHERE idcard = :IDCARD ";
		$db->setParam("IDCARD", $idCard);
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
	 * Methods add object of class Card
	 * insert record into table card
	 * @return boolean
	 */
	protected function create()
	{
		$db = new DB();
		$sql  = "INSERT INTO " . DB_SCHEMA . ".card(name, value) ";
		$sql .= "VALUES(:NAME, :VALUE) ";
		$db->setParam("NAME",$this->getName());
		$db->setParam("VALUE",$this->getValue());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$this->setIdCard($db->getLastInsertID());
			$db->commit();
			self::updateFactoryIndex($this);
			$this->setReaded();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10102 Insert record into table card fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method change object of class Card
	 * update record in table card
	 * @return boolean
	 */
	protected function update()
	{
		$db = new DB();
		$sql  = "UPDATE " . DB_SCHEMA . ".card ";
		$sql .= "SET name = :NAME ";
		$sql .= " , value = :VALUE ";
		$sql .= "WHERE idcard = :IDCARD ";
		$db->setParam("IDCARD",$this->getIdCard());
		$db->setParam("NAME",$this->getName());
		$db->setParam("VALUE",$this->getValue());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10103 Update record in table card fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes object of class Card
	 * removed are record from table card
	 * @return boolean
	 */
	protected function destroy()
	{
		$db = new DB();
		$sql  = "DELETE FROM " . DB_SCHEMA . ".card ";
		$sql .= "WHERE idcard = :IDCARD ";
		$db->setParam("IDCARD", $this->getIdCard());
		$db->query($sql);
		if(1 == $db->getRowAffected())
		{
			$db->commit();
			return true;
		}
		else
		{
			$db->rollback();
			AddAlert("PP:10104 Delete record from table card fail");
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods set all atributes in object of class Card from object class DB
	 * @return void
	 */
	protected function setAllFromDB(DataSource $db)
	{
		$this->setIdCard($db->f("idcard"));
		$this->setName($db->f("name"));
		$this->setValue($db->f("value"));
		$this->setReaded();
	}
	// -------------------------------------------------------------------------
}
?>