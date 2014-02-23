<?php
/**
 * Created on 15-10-2011 21:02:43
 *
 * @author Tomasz Gajewski
 * @package common
 * error prefix EM:102
 */
// =============================================================================
function getFormRow($desc = "", $real = "")
{
	$retval = Tags::span($desc, "class='FormCellDesc'");
	$retval .= Tags::span($real, "class='FormCellReal'");
	return $retval;
}
// =============================================================================
function getFormSubmitRow($real = "")
{
	return Tags::span($real, "class='FormCellReal c '");
}
// =============================================================================
function getToolTip($komunikat)
{
	$komunikat = str_replace("\n", Tags::br(), $komunikat);
	$komunikat = str_replace("\r", "", $komunikat);
	$komunikat = str_replace("\"", "", $komunikat);
	$komunikat = str_replace("'", "", $komunikat);
	$komunikat = wordwrap($komunikat, 80, Tags::br());
	return "onmouseover='showToolTip(\"" . $komunikat . "\",event,this)'";
}
// =============================================================================
function getMsg()
{
	$retval = "";
	if(isset($_SESSION["info"]))
	{

		$wiadomosci = "";
		foreach($_SESSION["info"] as $value)
		{
			$id = "MSG" . getRandomString(5);
			$wiadomosci .= Tags::p($value->getOpis(), "class='clear' id='" . $id . "'");
			$wiadomosci .= Tags::script("$(\"#" . $id . "\").parent().parent().delay(5000).hide(\"slide\",{direction: \"up\"})");
		}
		unset($_SESSION["info"]);
		$title = icon("ui-icon-notice");
		$title .= "Info";
		$title .= Tags::span("", "class='ui-icon ui-icon-close hand' style='float:right;' onclick='\$(this).parent().parent().remove(); HideToolTip(); return false;' " . getToolTip("Zamknij"));
		$title = Tags::div($title, "class='ui-widget-header ui-corner-all ui-helper-clearfix' style='padding:2px'");
		$content = Tags::div($wiadomosci, "class='ui-corner-bottom ui-priority-primary clear' style='padding:8px'");
		$tmp = $title . $content;
		$retval .= Tags::div($tmp, " style='width:auto;margin-bottom:4px;padding:2px' class='ui-widget-content ui-state-highlight ui-corner-all'");
	}

	if(isset($_SESSION["warning"]))
	{

		$wiadomosci = "";
		foreach($_SESSION["warning"] as $value)
		{
			$id = "MSG" . getRandomString(5);
			$wiadomosci .= Tags::p(Tags::span(Tags::i($value->getNumer()), "style='float:right;font-size:75%;'") . $value->getOpis(), "class='clear' id='" . $id . "'");
			$wiadomosci .= Tags::script("$(\"#" . $id . "\").parent().parent().delay(5000).hide(\"slide\",{direction: \"up\"})");
		}
		unset($_SESSION["warning"]);
		$title = icon("ui-icon-info");
		$title .= "Ostrzeżenie";
		$title .= Tags::span("", "class='ui-icon ui-icon-close hand' style='float:right;' onclick='\$(this).parent().parent().remove(); HideToolTip(); return false;' " . getToolTip("Zamknij"));
		$title = Tags::div($title, "class='ui-widget-header ui-corner-all ui-helper-clearfix ui-state-error' style='padding:2px'");
		$content = Tags::div($wiadomosci, "class='ui-corner-bottom ui-priority-primary clear' style='padding:8px'");
		$tmp = $title . $content;
		$retval .= Tags::div($tmp, " style='width:auto;margin-bottom:4px;padding:2px' class='ui-widget-content ui-state-highlight ui-corner-all'");
	}

	if(isset($_SESSION["alert"]))
	{
		$wiadomosci = "";
		foreach($_SESSION["alert"] as $value)
		{
			$id = "MSG" . getRandomString(5);
			$wiadomosci .= Tags::p(Tags::span(Tags::i($value->getNumer()), "style='float:right;font-size:75%;'") . $value->getOpis(), "class='clear' id='" . $id . "'");
			$wiadomosci .= Tags::script("$(\"#" . $id . "\").parent().parent().delay(10000).hide(\"slide\",{direction: \"up\"})");
		}
		unset($_SESSION["alert"]);
		$title = icon("ui-icon-alert");
		$title .= "Alert";
		$title .= Tags::span("", "class='ui-icon ui-icon-close hand' style='float:right;' onclick='\$(this).parent().parent().remove(); HideToolTip(); return false;' " . getToolTip("Zamknij"));
		$title = Tags::div($title, "class='ui-widget-header ui-corner-all ui-helper-clearfix ui-state-highlight' style='padding:2px'");
		$content = Tags::div($wiadomosci, "class='ui-corner-bottom ui-priority-primary clear' style='padding:8px'");
		$tmp = $title . $content;
		$retval .= Tags::div($tmp, " style='margin-bottom:4px;padding:2px' class='ui-widget-content ui-state-error ui-corner-all'");
	}

	if(isset($_SESSION["sqlError"]))
	{
		$wiadomosci = "";
		foreach($_SESSION["sqlError"] as $value)
		{
			$wiadomosci .= Tags::p($value->getOpis());
		}
		unset($_SESSION["sqlError"]);
		if(DEBUG)
		{
			$title = icon("ui-icon-alert");
			$title .= "SQLError";
			$title .= Tags::span("", "class='ui-icon ui-icon-close hand' style='float:right;' onclick='\$(this).parent().parent().remove(); HideToolTip(); return false;' " . getToolTip("Zamknij"));
			$title = Tags::div($title, "class='ui-widget-header ui-corner-all ui-helper-clearfix ui-state-highlight' style='padding:2px'");
			$content = Tags::div($wiadomosci, "class='ui-corner-bottom ui-priority-primary clear' style='padding:8px'");
			$tmp = $title . $content;
			$retval .= Tags::div($tmp, " style='margin-bottom:4px;padding:2px' class='ui-widget-content ui-state-error ui-corner-all'");
		}
	}
	return $retval;
}
// =============================================================================
function commandButton($caption = "NoTitle", $onClick = "")
{
	return Tags::button($caption, "onclick='" . $onClick . "' style='margin:4px;padding:2px' onmouseover='\$(this).addClass(\"ui-state-hover\")' onmouseout='\$(this).removeClass(\"ui-state-hover\")' class='hand ui-button ui-state-default ui-corner-all'");
}
// =============================================================================
function submitButton($label = "Wyślij")
{
	return Tags::input("type='submit' style='margin:4px;padding:2px' onmouseover='\$(this).addClass(\"ui-state-hover\")' onmouseout='\$(this).removeClass(\"ui-state-hover\")' class='ui-button ui-state-default ui-corner-all hand' value='" . $label . "'");
}
// =============================================================================
function passwordField($name = "no_name", $value = "", $eequired = false)
{
	$txt = new TextField();
	$txt->setName($name);
	$txt->setRequired($eequired);
	$txt->setClassString(Field::CLASS_SIZE_FULL);
	$txt->setSelected($value);
	$txt->setType("password");
	$retval = $txt->out();

	return $retval;
}
// =============================================================================
function fileField($name = "no_name")
{
	return Tags::input("type='file' id='" . $name . "' name='" . $name . "'");
}
// =============================================================================
function hiddenField($name = "no_name", $value = "")
{
	return Tags::input("type='hidden' id='" . $name . "' name='" . $name . "' value='" . $value . "'");
}
// =============================================================================
function checkBoxField($name = "no_name", $checked = false)
{
	$f = new CheckBoxField();
	$f->setName($name);
	$f->setSelected($checked);
	return $f->out();
}
// =============================================================================
function integerField($name = "no_name", $value = "", $required = true)
{
	$f = new IntegerField();
	$f->setName($name);
	$f->setSelected($value);
	$f->setRequired($required);

	return $f->out();
}
// =============================================================================
function dateField($name = "no_name", $value = "", $required = false)
{
	$d = new DateField();
	$d->setName($name);
	$d->setRequired($required);
	$d->setSelected($value);
	return $d->out();
}
// =============================================================================
function timeField($name = "no_name", $value = "", $required = false)
{
	$t = new TimeField();
	$t->setName($name);
	$t->setRequired($required);
	$t->setSelected($value);
	return $t->out();
}
// =============================================================================
function floatField($name = "no_name", $value = "", $required = true)
{
	$f = new FloatField();
	$f->setName($name);
	$f->setSelected($value);
	$f->setRequired($required);
	return $f->out();
}
// =============================================================================
function emailField($name = "no_name", $value = "", $eequired = false, $tabOrder = null)
{
	$txt = new TextField();
	$txt->setName($name);
	$txt->setRequired($eequired);
	$txt->setClassString(Field::CLASS_SIZE_FULL);
	$txt->setSelected($value);
	$txt->setOnBlur("parseEmail(this);");
	$txt->setTabOrder($tabOrder);
	$retval = $txt->out();
	return $retval;
}
// =============================================================================
function textField($name = "no_name", $value = "", $eequired = false, $multiline = false, $maxLenght = 255, $tabOrder = 0)
{
	if($multiline)
	{
		$txt = new MemoField();
		$txt->setName($name);
		$txt->setTabOrder($tabOrder);
		$txt->setMaxLength($maxLenght);
		$txt->setRequired($eequired);
		$txt->setClassString(Field::CLASS_SIZE_FULL);
		$txt->setSelected($value);
		$retval = $txt->out();
	}
	else
	{
		$txt = new TextField();
		$txt->setName($name);
		$txt->setTabOrder($tabOrder);
		$txt->setMaxLength($maxLenght);
		$txt->setRequired($eequired);
		$txt->setClassString(Field::CLASS_SIZE_FULL);
		$txt->setSelected($value);
		$retval = $txt->out();
	}
	return $retval;
}
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