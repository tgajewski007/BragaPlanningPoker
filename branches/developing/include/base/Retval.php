<?php
/**
 *
 * @package common
 * @author Tomasz.Gajewski
 * Created on 2009-06-12 07:26:27
 * klasa opisująca dane zwracane do przeglądarki
 * zarówno w formie Ajax jak i w normalnym trybie
 */
class Retval
{
	private $page = "";
	private $ajax = "";
	// -------------------------------------------------------------------------
	public function Clear()
	{
		$this->page = "";
		$this->ajax = "";
	}
	// -------------------------------------------------------------------------
	public function addPage($retval)
	{
		$this->page .= $retval;
	}
	// -------------------------------------------------------------------------
	public function sustain($idContener = "#InputBox")
	{
		$id = str_replace("#", "", $idContener);
		$this->ajax .= Tags::customShortXML("sustain", "id='" . $id . "'");
	}
	// -------------------------------------------------------------------------
	public function remove($idContener = "#InputBox")
	{
		$this->ajax .= Tags::customShortXML("remove", "id='" . $idContener . "'");
	}
	// -------------------------------------------------------------------------
	public function closePopUp($idContener = "#InputBox")
	{
		$id = str_replace("#", "", $idContener);
		$this->ajax .= Tags::customShortXML("closePopUp", "id='" . $id . "'");
	}
	// -------------------------------------------------------------------------
	public function popUpWin($title, $retval, $idContener = "#InputBox")
	{
		$id = str_replace("#", "", $idContener);
		$this->ajax .= Tags::customShortXML("popup", "id='" . $id . "' title='" . $title . "'");
		$this->addChange($retval, $idContener);
	}
	// -------------------------------------------------------------------------
	public function changeAttrib($idContener, $Name, $Value)
	{
		$this->ajax .= Tags::customShortXML("atrybut", "id='" . $idContener . "' name='" . $Name . "' value='" . $Value . "'");
	}
	// -------------------------------------------------------------------------
	public function centerContener($idContener)
	{
		$this->changeAttrib($idContener, "ajax_centered", "0");
	}
	// -------------------------------------------------------------------------
	public function appendChange($retval, $idContener = "#MainBox")
	{
		$this->ajax .= Tags::custom("append", "<![CDATA[" . $retval . "]]>", "id='" . $idContener . "'");
	}
	// -------------------------------------------------------------------------
	public function addChange($retval, $idContener = "#MainBox")
	{
		$this->ajax .= Tags::custom("change", "<![CDATA[" . $retval . "]]>", "id='" . $idContener . "'", "");
		if($idContener == "MainBody")
		{
			$this->page = $retval;
		}
	}
	// -------------------------------------------------------------------------
	public function getPage()
	{
		return $this->page;
	}
	// -------------------------------------------------------------------------
	public function getAjax()
	{
		$msg = GetMsg();
		if(strlen($msg) > 0)
		{
			$this->addChange($msg, "#MsgBox");
		}
		$retval = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$retval .= Tags::custom("changes", $this->ajax, "date='" . date(PHP_DATETIME_FORMAT) . "'");
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>