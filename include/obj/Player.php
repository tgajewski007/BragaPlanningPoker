<?php
/**
 * Created on 04-02-2014 08:20:35
 *
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:105
 * Generated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * {please complete documentation}
 */
class Player extends PlayerDAO implements DAO
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
	public static function retriveByTable(Table $t)
	{
		$db = new DB();
		$sql = "SELECT * FROM " . DB_SCHEMA . ".player ";
		$sql .= "WHERE iduser = :IDUSER ";
		$sql .= "AND idtable = :IDTABLE ";
		$sql .= "ORDER BY idplayer DESC ";
		$sql .= "LIMIT 1 ";
		$db->setParam("IDUSER", User::getCurrent()->getIdUser());
		$db->setParam("IDTABLE", $t->getIdTable());
		$db->query($sql);
		if($db->nextRecord())
		{
			return self::getByDataSource($db);
		}
		else
		{
			throw new PlayerException("PP:10510 No table found");
		}
	}
	// -------------------------------------------------------------------------
	/**
	 * Method saves the object of the classPlayer
	 * @return boolean
	 */
	public function save()
	{
		// TODO: please set atrib independens of clients ex lastupdate
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
	 * Method removes an object of class Player
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
	 * @return Collection &lt;Player&gt;
	 */
	public static function getAll()
	{
		// TODO: this is example of method selecting multi rec from table
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".player ";
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Player
	 */
	public static function getCurrent()
	{
		return self::get($_SESSION[SessionName::CURRENT_PLAYER]);
	}
	// -------------------------------------------------------------------------
	public static function sitDownToTable(Table $t)
	{
		try
		{
			$p = self::retriveByTable($t);
		}
		catch(Exception $e)
		{
			$p = self::get();
			$p->setIdUser(User::getCurrent()->getIdUser());
			$p->setIdTable($t->getIdTable());
			$p->setIdRole(Role::getCurrent()->getIdRole());
			if(!$p->save())
			{
				throw new PlayerException("PP:10511 Can't create Player");
			}
		}
		Table::setCurrent($t);
		$_SESSION[SessionName::CURRENT_PLAYER] = $p->getIdPlayer();
	}
	// -------------------------------------------------------------------------
	public static function getUpFromTable()
	{
		self::getCurrent()->kill();
		unset($_SESSION[SessionName::CURRENT_PLAYER]);
	}
	// -------------------------------------------------------------------------
}
?>