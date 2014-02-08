<?php
/**
 * Created on 15-10-2011 21:02:43
 *
 * @author Tomasz Gajewski
 * @package common
 * error prefix EM:102
 */
// =============================================================================
function getmicrotime()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
// =============================================================================
function addAlert($text)
{
	addErrorLog($text);
	$m = Message::import(htmlspecialchars($text, ENT_QUOTES));
	if(!is_null($m))
	{
		$_SESSION["alert"][] = $m;
	}
}
// =============================================================================
function addSQLError($text)
{
	addErrorLog($text);
	$m = Message::import(htmlspecialchars($text, ENT_QUOTES));
	if(!is_null($m))
	{
		$_SESSION["sqlError"][] = $m;
	}
}
// =============================================================================
function addMsg($text)
{
	$m = Message::import(htmlspecialchars($text, ENT_QUOTES));
	if(!is_null($m))
	{
		$_SESSION["info"][] = $m;
	}
}
// =============================================================================
function addWarn($text)
{
	$m = Message::import(htmlspecialchars($text, ENT_QUOTES));
	if(!is_null($m))
	{
		$_SESSION["warning"][] = $m;
	}
}
// =============================================================================
function addErrorLog($text)
{
	if(is_object($text) or is_array($text))
	{
		$text = var_export($text, true);
	}
	$retval = date("Y-m-d H:i:s") . "," . $text;
	$h = fopen(INSTALL_DIRECTORY . "log/Error(".date(PHP_DATE_FORMAT).").log", "a");
	fwrite($h, $retval, mb_strlen($retval));
	fwrite($h, "\r\n", 2);
	fclose($h);
}
// =============================================================================
function addDebugInfo($Text)
{
	if(is_object($Text) or is_array($Text))
	{
		$Text = var_export($Text, true);
	}
	$retval = date("Y-m-d H:i:s") . "," . $Text;
	$h = fopen(INSTALL_DIRECTORY . "log/Debug.log", "a");
	fwrite($h, $retval, mb_strlen($retval));
	fwrite($h, "\r\n", 2);
	fclose($h);
}
// =============================================================================
function getRandomStringLetterOnly($dlugosc)
{
	$keychars = "abcdefghijklmnopqrstuvwxyz";
	$randkey = "";
	$max = strlen($keychars) - 1;
	for($i = 0;$i < $dlugosc;$i++)
	{
		$randkey .= substr($keychars, rand(0, $max), 1);
	}
	return $randkey;
}
// =============================================================================
function getRandomString($dlugosc)
{
	$keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randkey = "";
	$max = strlen($keychars) - 1;
	for($i = 0;$i < $dlugosc;$i++)
	{
		$randkey .= substr($keychars, rand(0, $max), 1);
	}
	return $randkey;
}
// =============================================================================
function plCharset($string)
{
	$string = mb_strtolower($string);
	$polskie = array(
			',',
			' ',
			' ',
			'ę',
			'Ę',
			'ó',
			'Ó',
			'Ą',
			'ą',
			'Ś',
			's',
			'ł',
			'Ł',
			'ż',
			'Ż',
			'Ź',
			'ź',
			'ć',
			'Ć',
			'ń',
			'Ń',
			'-',
			"'",
			"/",
			"?",
			'"',
			":",
			'ś',
			'!',
			'.',
			'&',
			'&amp;',
			'#',
			';',
			'[',
			']',
			'(',
			')',
			'`',
			'%',
			'”',
			'„',
			'…',
			'\\',
			">");
	$miedzyn = array(
			'-',
			'-',
			'-',
			'e',
			'e',
			'o',
			'o',
			'a',
			'a',
			's',
			's',
			'l',
			'l',
			'z',
			'z',
			'z',
			'z',
			'c',
			'c',
			'n',
			'n',
			'-',
			"",
			"-",
			"",
			"",
			"",
			's',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'-',
			'-');
	$string = str_replace($polskie, $miedzyn, $string);

	// usuń wszytko co jest niedozwolonym znakiem
	$string = preg_replace('/[^0-9a-z\-]+/', '', $string);

	// zredukuj liczbę myślników do jednego obok siebie
	$string = preg_replace('/[\-]+/', '-', $string);

	// usuwamy możliwe myślniki na początku i końcu
	$string = trim($string, '-');

	$string = stripslashes($string);

	// // na wszelki wypadek
	// $string = urlencode($string);

	return $string;
}
// =============================================================================
function formatMonney($kwota)
{
	return number_format($kwota, 2, ",", " ");
}
// =============================================================================
function formatBoolean($b)
{
	if($b)
		return "Tak";
	else
		return "Nie";
}
// =============================================================================
function formatText($text)
{
	return nl2br($text, true);
}
// =============================================================================
function sortByLength($a, $b)
{
	if($a == $b)
		return 0;
	return (mb_strlen($a) > mb_strlen($b) ? 1 : -1);
}
// =============================================================================
function reverseSortByLength($a, $b)
{
	if($a == $b)
		return 0;
	return (mb_strlen($a) > mb_strlen($b) ? -1 : 1);
}
// =============================================================================
function stripUrl($url)
{
	$url = preg_replace("/(https?:\/\/)/i", "", $url);
	return "http://" . $url;
}
// =============================================================================
function getMonthName($nr)
{
	$m[1] = "Styczeń";
	$m[2] = "Luty";
	$m[3] = "Marzec";
	$m[4] = "Kwiecień";
	$m[5] = "Maj";
	$m[6] = "Czerwiec";
	$m[7] = "Lipiec";
	$m[8] = "Sierpień";
	$m[9] = "Wrzesień";
	$m[10] = "Październik";
	$m[11] = "Listopad";
	$m[12] = "Grudzień";
	return $m[$nr];
}
// =============================================================================
function icon($icon = "", $float = "left")
{
	return Tags::span("", "class='ui-icon " . $icon . "' style='float:" . $float . "'");
}
// =============================================================================
function groupCollection(Collection $collection, $groupFunctionName)
{
	$retval = array();
	foreach($collection as $key => $value)
	{
		$groupKey = call_user_func(array(
				$value,
				$groupFunctionName));
		$retval[$groupKey][$key] = $value;
	}
	return $retval;
}
// =============================================================================
function getHashPass($pass, $guid)
{
	return hash(HASH_ALGORYTM, $pass . $guid);
}
// =============================================================================
function getCleanCDATAXml($text)
{
	$text = trim($text);
	$text = preg_replace('!\s+!', ' ', $text);
	$text = strip_tags($text, "<br><br/>");
	$text = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $text);
	$text = preg_replace("/(<br\s*\/?>\s*)+/i", "\n", $text);
	$text = html_entity_decode($text, ENT_QUOTES,'UTF-8');
	$text = html_entity_decode($text, ENT_QUOTES,'UTF-8');
	$text = htmlspecialchars($text, ENT_QUOTES,'UTF-8');
	return $text;
}
// =============================================================================
function getProperUrl($url)
{
	return htmlspecialchars(html_entity_decode(trim($url), ENT_QUOTES,'UTF-8'), ENT_QUOTES,'UTF-8');
}
// =============================================================================
?>