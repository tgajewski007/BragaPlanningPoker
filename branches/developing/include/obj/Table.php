<?php
/**
 * Created on 04-02-2014 08:20:35
 *
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
	 *
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
		else
		{
			$this->setPassword(null);
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method saves the object of the classTable
	 *
	 * @return boolean
	 */
	public function save()
	{
		if($this->check())
		{
			if($this->isReaded())
			{
				$this->hashPass();
				return $this->update();
			}
			else
			{
				$this->setIdTable(Guid::get());
				$this->hashPass();
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
	 *
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
	 *
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
	 * Methods return colection of  Table
	 * @return Collection &lt;Table&gt;
	 */
	public static function getAllByPrivacyStatus(PrivacyStatusDAO $privacyStatus)
	{
		$db = new DB();
		$sql  = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".table ";
		$sql .= "WHERE idprivacy_status = :IDPRIVACY_STATUS ";
		$sql .= "AND close_date IS NULL ";
		$db->setParam("IDPRIVACY_STATUS", $privacyStatus->getIdPrivacyStatus());
		$db->query($sql);
		return new Collection($db, Table::get());
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Game
	 */
	public function getCurrentGame()
	{
		return Game::getCurrent();
	}
	// -------------------------------------------------------------------------
	public static function setCurrent(Table $t)
	{
		$_SESSION[SessionName::CURRENT_TABLE] = $t->getIdTable();
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Table
	 */
	public static function getCurrent()
	{
		if(isset($_SESSION[SessionName::CURRENT_TABLE]))
		{
			return self::get($_SESSION[SessionName::CURRENT_TABLE]);
		}
		else
		{
			throw new TableException("PP:10810 Default table doesn't exists");
		}
	}
	// -------------------------------------------------------------------------
}
?>