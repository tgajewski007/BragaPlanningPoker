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
		// TODO: this method may be changed when record can not be deleted from
		// table
		return $this->destroy();
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
}
?>