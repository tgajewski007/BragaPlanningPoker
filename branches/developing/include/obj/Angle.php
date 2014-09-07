<?php
/**
 * Created on 4 wrz 2014 08:16:55
 * author Tomasz Gajewski
 * package frontoffice
 * error prefix
 */
class Angle
{
	// -------------------------------------------------------------------------
	static function getAngles($iloscGraczy)
	{
		switch($iloscGraczy)
		{
			case 7:
				return self::getAngleFor7Players();
				break;
			case 8:
				return self::getAngleFor8Players();
				break;
			case 9:
				return self::getAngleFor9Players();
				break;
			case 10:
				return self::getAngleFor10Players();
				break;
			default:
				return self::getCalculateAngle($iloscGraczy);
				break;
		}
	}
	// -------------------------------------------------------------------------
	private static function getAngleFor7Players()
	{
		$retval[0] = 0;
		$retval[1] = 51;
		$retval[2] = 103;
		$retval[3] = 164;
		$retval[4] = 196;
		$retval[5] = 257;
		$retval[6] = 309;
		return $retval;
	}
	// -------------------------------------------------------------------------
	private static function getAngleFor8Players()
	{
		$retval[0] = 0;
		$retval[1] = 25;
		$retval[2] = 90;
		$retval[3] = 155;
		$retval[4] = 180;
		$retval[5] = 205;
		$retval[6] = 270;
		$retval[7] = 335;
		return $retval;
	}
	// -------------------------------------------------------------------------
	private static function getAngleFor9Players()
	{
		$retval[0] = 0;
		$retval[1] = 20;
		$retval[2] = 80;
		$retval[3] = 135;
		$retval[4] = 172;
		$retval[5] = 188;
		$retval[6] = 225;
		$retval[7] = 280;
		$retval[8] = 340;
		return $retval;
	}
	// -------------------------------------------------------------------------
	private static function getAngleFor10Players()
	{
		$retval[0] = 0;
		$retval[1] = 20;
		$retval[2] = 68;
		$retval[3] = 112;
		$retval[4] = 160;
		$retval[5] = 180;
		$retval[6] = 200;
		$retval[7] = 248;
		$retval[8] = 292;
		$retval[9] = 340;
		return $retval;
	}
	// -------------------------------------------------------------------------
	private static function getCalculateAngle($iloscGraczy)
	{
		$retval = array();
		for($i = 0;$i < $iloscGraczy;$i++)
		{
			$retval[$i] = $i *(360 / $iloscGraczy);
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>