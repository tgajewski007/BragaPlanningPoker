<?php
/**
 * Created on 04-02-2014 08:20:35
 *
 * @author Tomasz Gajewski
 * @package PlaningPoker
 * error prefix PP:101
 * Generated by SimplePHPDAOClassGenerator ver 2.2.0
 * https://sourceforge.net/projects/simplephpdaogen/
 * {please complete documentation}
 */
class Card extends CardDAO implements DAO
{
	// -------------------------------------------------------------------------
	const ZERO = 1;
	const HALF = 2;
	const ONE = 3;
	const TWO = 4;
	const THREE = 5;
	const FIVE = 6;
	const EIGHT = 7;
	const THIRTEEN = 8;
	const TWENTY = 9;
	const FORTY = 10;
	const ONE_HUNDRED = 11;
	const I_DONT_KNOW = 12;
	const COFFY_BREAK = 13;
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
	 * Method saves the object of the classCard
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
	public static function getBack()
	{
		return Tags::span("", "class='card sprite cardBack'");
	}
	// -------------------------------------------------------------------------
	public function getTag()
	{
		if(!isset($cardStyle))
		{
			static $cardStyle = array();
			$cardStyle[self::ZERO] = "cardZero";
			$cardStyle[self::HALF] = "cardHalf";
			$cardStyle[self::ONE] = "cardOne";
			$cardStyle[self::TWO] = "cardTwo";
			$cardStyle[self::THREE] = "cardThree";
			$cardStyle[self::FIVE] = "cardFive";
			$cardStyle[self::EIGHT] = "cardEight";
			$cardStyle[self::THIRTEEN] = "cardThirteen";
			$cardStyle[self::TWENTY] = "cardTwenty";
			$cardStyle[self::FORTY] = "cardForty";
			$cardStyle[self::ONE_HUNDRED] = "cardOneHudred";
			$cardStyle[self::I_DONT_KNOW] = "cardIDontKnow";
			$cardStyle[self::COFFY_BREAK] = "cardCoffyBreak";
			$cardStyle[null] = "cardBack";
		}
		return Tags::span("", "data-idcard='" . $this->getIdCard() . "' class='card sprite " . $cardStyle[$this->getIdCard()] . "' " . getToolTip($this->getName()));
	}
	// -------------------------------------------------------------------------
	/**
	 * Method removes an object of class Card
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
	 * @return Collection &lt;Card&gt;
	 */
	public static function getAll()
	{
		// TODO: this is example of method selecting multi rec from table
		$db = new DB();
		$sql = "SELECT * ";
		$sql .= "FROM " . DB_SCHEMA . ".card ";
		$db->query($sql);
		return new Collection($db, self::get());
	}
	// -------------------------------------------------------------------------
}
?>