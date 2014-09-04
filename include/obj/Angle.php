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
			case 1:
				return array(
						0);
				break;
			case 2:
				return array(
						0,
						90);
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
	private static function getAngleFor9Players()
	{
		$retval[0] = 0;
		$retval[1] = 40;
		$retval[2] = 80;
		$retval[3] = 120;
		$retval[4] = 160;
		$retval[5] = 200;
		$retval[6] = 240;
		$retval[7] = 280;
		$retval[8] = 320;
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