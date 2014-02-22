<?php
/**
 * Created on 22 lut 2014 17:08:18
 * error prefix
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class StartLayout extends PublicLayout
{
	// -------------------------------------------------------------------------
	protected function getContent($content)
	{
		$retval = Tags::div($this->getMenu(), "id='MenuBox'");
		$retval .= Tags::div($content, "id='MainBox'");
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getMenu()
	{
		$retval = Tags::span("welcome: " . User::getCurrent()->getName());
		$retval .= Tags::span(" | ");
		$retval .= Tags::ajaxLink("?action=GetSettings","settings");
		$retval .= Tags::span(" | ");
		$retval .= Tags::ajaxLink("?action=LogOut","logout");
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>