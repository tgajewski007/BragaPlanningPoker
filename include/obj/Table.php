<?php
/**
 * Created on 04-02-2014 08:20:35
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:108
 * Generated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * {please complete documentation}
 */
class Table extends TableDAO implements DAO
{
	// -------------------------------------------------------------------------
	protected $passwordNonHashed = null;
	// -------------------------------------------------------------------------
	public function isCanSee()
	{
		// TODO: dorobić zarządzanie prawami
		return true;
	}
	// -------------------------------------------------------------------------
	public function getTasksForLog($page)
	{
		return Task::getAllForLogPaged($this, $page);
	}
	// -------------------------------------------------------------------------
	public function setPasswordNonHashed($pass)
	{
		if($pass == "")
		{
			$this->passwordNonHashed = null;
		}
		else
		{
			$this->passwordNonHashed = $pass;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods validate data before save
	 * @return boolean
	 */
	protected function check()
	{
		$retval = true;
		if($this->getIdPrivacyStatus() != PrivacyStatus::STATUS_PUBLIC)
		{
			if($this->getPassword() == "")
			{
				addAlert("PP:10810 Password is required for status: " . $this->getPrivacyStatus()->getName());
				$retval = false;
			}
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function hashPass()
	{
		if(!is_null($this->passwordNonHashed))
		{
			$this->setPassword(getHashPass($this->passwordNonHashed, $this->getIdTable()));
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method saves the object of the classTable
	 * @return boolean
	 */
	public function save()
	{
		$this->hashPass();
		if($this->check())
		{
			if($this->isReaded())
			{
				return $this->update();
			}
			else
			{
				$this->setIdTable(Guid::get());
				$this->setStartDate(date(PHP_DATETIME_FORMAT));
				return $this->create();
			}
		}
		else
		{
			return false;
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes an object of class Table
	 * @return boolean
	 */
	public function kill()
	{
		$this->setCloseDate(PHP_DATETIME_FORMAT);
		return $this->save();
	}
	// -------------------------------------------------------------------------
	/**
	 * This method returns a collection of objects
	 * @return Collection &lt;Table&gt;
	 */
	public static function getAll()
	{
		// TODO: this is example of method selecting multi rec from table
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".table ";
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
	/**
	 * Methods return colection of Table
	 * @return Collection &lt;Table&gt;
	 */
	public static function getAllForCurrentUser()
	{
		$db = new DB();
		$sql = "SELECT t.* ";
		$sql .= "FROM " . DB_SCHEMA . ".table t ";
		$sql .= "LEFT OUTER JOIN " . DB_SCHEMA . ".player p ON p.idtable = t.idtable AND p.iduser = :IDUSER ";
		$sql .= "WHERE ( ";
		$sql .= "( idprivacy_status = :PUBLIC) ";
		$sql .= "OR ( idprivacy_status = :PROTECTED AND p.idrole = :BANCO )";
		$sql .= "OR ( idprivacy_status = :PRIVATE AND p.idrole = :BANCO )";
		$sql .= ") ";
		$sql .= "AND close_date IS NULL ";
		$db->setParam("PUBLIC", PrivacyStatus::STATUS_PUBLIC);
		$db->setParam("PROTECTED", PrivacyStatus::STATUS_PROTECTED);
		$db->setParam("PRIVATE", PrivacyStatus::STATUS_PRIVATE);
		$db->setParam("BANCO", Role::BANCO);
		$db->setParam("IDUSER", User::getCurrent()->getIdUser());
		$db->query($sql);
		return new Collection($db, Table::get());
	}
	// -------------------------------------------------------------------------
	static function getCurrent()
	{
		if(isset($_SESSION[SessionName::CURRENT_TABLE]))
		{
			return self::get($_SESSION[SessionName::CURRENT_TABLE]);
		}
		else
		{
			return self::get();
		}
	}
	// -------------------------------------------------------------------------
	static function setCurrent(Table $t)
	{
		$_SESSION[SessionName::CURRENT_TABLE] = $t->getIdTable();
	}
	// -------------------------------------------------------------------------
	public function cleanCurrentGame()
	{
		foreach(Game::getAllByTask(Task::getCurrent()) as $g) /* @var $g Game */
		{
			$g->setIdCard(null);
			$g->save();
		}
	}
	// -------------------------------------------------------------------------
}
?>