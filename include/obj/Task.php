<?php
/**
 * Created on 04-02-2014 08:20:35
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:109
 * Generated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * {please complete documentation}
 */
class Task extends TaskDAO implements DAO
{
	// -------------------------------------------------------------------------
	/**
	 * Methods validate data before save
	 * @return boolean
	 */
	protected function check()
	{
		// TODO: add special validate
		return true;
	}
	// -------------------------------------------------------------------------
	/**
	 * Method saves the object of the classTask
	 * @return boolean
	 */
	public function save()
	{
		$this->setIdPlayer(Player::getCurrent()->getIdPlayer());
		$this->setLastUpdate(PHP_DATETIME_FORMAT);
		if($this->check())
		{
			if($this->isReaded())
			{
				return $this->update();
			}
			else
			{
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
	 * Method removes an object of class Task
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
	 * @return Collection &lt;Task&gt;
	 */
	public static function getAll()
	{
		// TODO: this is example of method selecting multi rec from table
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".task ";
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
	public function getMediumCardValue()
	{
		$db = new DB();
		$sql = "SELECT Avg(c.value) ";
		$sql .= "FROM " . DB_SCHEMA . ".game g ";
		$sql .= "INNER JOIN " . DB_SCHEMA . ".card c ON c.idcard = g.idcard ";
		$sql .= "WHERE idtask = :IDTASK ";
		$sql .= "AND g.status = :OPEN ";
		$db->setParam("IDTASK", $this->getIdTask());
		$db->setParam("OPEN", Game::OPEN);
		$db->query($sql);
		if($db->nextRecord())
		{
			return round($db->f(0), 1);
		}
		else
		{
			return "0.0";
		}
	}
	// -------------------------------------------------------------------------
	public static function getAllForLogPaged(Table $table, $page)
	{
		$db = new DB();
		$sql = "SELECT SQL_CALC_FOUND_ROWS * ";
		$sql .= "FROM " . DB_SCHEMA . ".task ";
		$sql .= "WHERE idtable = :IDTABLE ";
		$sql .= "ORDER BY idtask DESC ";
		$db->setParam("IDTABLE", $table->getIdTable());
		$db->setLimit(($page - 1) * PAGELIMIT);
		
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
	public function getMedianCard()
	{
		return Card::getMedianCardForTask($this);
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Task
	 */
	public static function getCurrent()
	{
		return Player::getCurrent()->getTable()->getTask();
	}
	// -------------------------------------------------------------------------
}
?>