<?php
/**
 *
 * @package enmarket
 * @author Tomasz.Gajewski
 * Created on 2010-06-16 14:24:41
 * klasa gromadząca statyczne metody tworzące tragi HTML
 * error prefix
 */
class Tags extends GTags
{
	static function formNonAjax($innerHTML, $attributes = "action='' method='post' onsubmit='return BeforeSubmit(this)'")
	{
		return Tags::form($innerHTML, $attributes);
	}
	// -------------------------------------------------------------------------
	static function formularz($innerHTML)
	{
		return Tags::form($innerHTML, "action='' class='formularz' method='post' onsubmit='return ajax.go(this)'");
	}
	// -------------------------------------------------------------------------
	static function fileFormularz($innerHTML)
	{
		return Tags::form($innerHTML . self::iframe("", "name='FileFrame' src='about:blank' onload='AfterUploadFile(this)' class='h'"), "action='./' target='FileFrame' method='post' onsubmit='if(BeforeSubmit(this)){ajax.ShowMarker();}else{return false;}' enctype='multipart/form-data'");
	}
	// -------------------------------------------------------------------------
	static function downloadFormularz($innerHTML)
	{
		return Tags::form($innerHTML . self::iframe("", "id='downloadFileFrame' name='downloadFileFrame' src='about:blank' onload='AfterUploadFile(this)' class='h'"), "action='./' target='downloadFileFrame' method='post' onsubmit='return BeforeSubmit(this)'");
	}
	// -------------------------------------------------------------------------
	static function formularzNonAjax($innerHTML)
	{
		return Tags::formNonAjax($innerHTML);
	}
	// -------------------------------------------------------------------------
	static function ajaxLink($href, $content, $tooltip = null)
	{
		if(null != $tooltip)
		{
			return self::a($content, "onclick='return ajax.go(this)' href='/" . $href . "' " . ToolTip($tooltip));
		}
		else
		{
			return self::a($content, "onclick='return ajax.go(this)' href='/" . $href . "'");
		}
	}
	// -------------------------------------------------------------------------
}

?>
