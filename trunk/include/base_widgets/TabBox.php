<?php
/**
 * Created on 2009-05-18 10:33:17 klasa generująca pole za zakładkami razem z
 * boxem w środku
 *
 * @author Tomasz.Gajewski
 */
class TabBox
{
	private $boxId;
	private $tabs;
	private $item;
	private $ajax;
	private $minHeight;
	private $defaultTab;
	// -------------------------------------------------------------------------
	public function __construct()
	{
		$this->tabs = array();
		$this->item = 0;
		$this->ajax = "onclick='return ajax.go(this)'";
		$this->boxId = "";
		$this->minHeight = 300;
		$this->defaultTab = 1;
	}
	// -------------------------------------------------------------------------
	public function setDefaultTab($id)
	{
		$this->defaultTab = $id;
	}
	// -------------------------------------------------------------------------
	public function disableAjax()
	{
		$this->ajax = "";
	}
	// -------------------------------------------------------------------------
	public function setMinHeight($height)
	{
		$this->minHeight = intval($height);
	}
	// -------------------------------------------------------------------------
	public function setBoxId($id)
	{
		$this->boxId = "id='" . $id . "'";
	}
	// -------------------------------------------------------------------------
	public function out($activeId = "1", $text = "")
	{
		$tabOk = false;
		foreach($this->tabs as $value)
		{
			if($value["ID"] == $activeId)
			{
				$tabOk = true;
			}
		}
		if(!$tabOk)
		{
			$activeId = $this->defaultTab;
		}
		$retval = "";
		if($this->item > 0)
		{
			// rozpoczynający pusty tab
			for($i = 0;$i < $this->item;$i++)
			{
				if($activeId == $this->tabs[$i]["ID"])
				{
					$retval .= $this->menuActive($this->tabs[$i]["Desc"], $this->tabs[$i]["HRef"]);
				}
				else
				{
					$retval .= $this->menuPassive($this->tabs[$i]["Desc"], $this->tabs[$i]["HRef"]);
				}
			}
			$retval .= Tags::div($text, "class='' " . $this->boxId . " style='clear:both;padding:0px 4px;min-height:" . strval($this->minHeight) . "px;'");
			$retval = Tags::div($retval, "class='ui-widget-content ui-corner-all' style='padding-top:4px'");
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	public function addTab($id, $opis, $href)
	{
		$this->tabs[$this->item]["ID"] = $id;
		$this->tabs[$this->item]["Desc"] = $opis;
		$this->tabs[$this->item]["HRef"] = $href;
		$this->item++;
	}
	// -------------------------------------------------------------------------
	private function menuPassive($opis, $href)
	{
		$retval = Tags::p(Tags::a($opis, "class='link' " . $this->ajax . " href='" . $href . "' onmouseout='\$(this).parent().removeClass(\"ui-state-hover\")' onmouseover='\$(this).parent().addClass(\"ui-state-hover\")'"), "class='c ui-widget-content ui-corner-top ui-state-default' style='margin:2px;padding:5px;float:left'");
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function menuActive($opis, $href)
	{
		$retval = Tags::p(Tags::a($opis, "class='link' " . $this->ajax . " href='" . $href . "'"), "class='c ui-widget-content ui-corner-top ui-state-active' style='margin:2px;padding:5px;float:left'");
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>