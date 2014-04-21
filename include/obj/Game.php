<?php
/**
 * Created on 04-02-2014 08:20:35
 *
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:103
 * Generated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * {please complete documentation}
 */
class Game extends GameDAO implements DAO
{
	// -------------------------------------------------------------------------
	const OPEN = "OPEN";
	const CLOSE = "CLOSE";
	// -------------------------------------------------------------------------
	/**
	 * Methods validate data before save
	 *
	 * @return boolean
	 */
	protected function check()
	{
		// TODO: add special validate
		return true;
	}
	// -------------------------------------------------------------------------
	/**
	 * Method saves the object of the classGame
	 *
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
	 * Method removes an object of class Game
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
	 * @return Collection &lt;Game&gt;
	 */
	public static function getAll()
	{
		// TODO: this is example of method selecting multi rec from table
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".game ";
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
	public static function getGameForCurrentPlayer()
	{
		$game = new self();
		$db = new DB();
		$sql = "SELECT * FROM " . DB_SCHEMA . ".game ";
		$sql .= "WHERE idplayer = :IDPLAYER ";
		$sql .= "AND idtable = :IDTABLE ";
		$sql .= "ORDER BY idgame DESC ";
		$db->setParam("IDPLAYER", Player::getCurrent()->getIdPlayer());
		$db->setParam("IDTABLE", Player::getCurrent()->getIdTable());
		$db->setLimit(0, 1);
		$db->query($sql);
		if($db->nextRecord())
		{
			return self::getByDataSource($db);
		}
		else
		{
			$game = self::get();
			$game->setIdTable(Player::getCurrent()->getIdTable());
			$game->setIdTask(Task::getCurrent()->getIdTask());
			$game->setIdPlayer(Player::getCurrent()->getIdPlayer());
			if($game->save())
			{
				return $game;
			}
			else
			{
				throw new GameException("PP:10310 Can't save game");
			}
		}
	}
	// -------------------------------------------------------------------------
}
?>