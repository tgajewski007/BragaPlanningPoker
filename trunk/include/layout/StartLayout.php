<?php
/**
 * Created on 22 lut 2014 17:08:18
 * error prefix
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class StartLayout extends PublicLayout
{
	// -------------------------------------------------------------------------
	protected function getContent($content)
	{
		$retval = Tags::div($this->getMenu(), "id='MenuBox' class='Cinzel'");
		$retval .= Tags::div($content, "id='MainBox'");
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getMenu()
	{
		$retval = Tags::div("menu" . $this->getMenuDropDown(), "onclick='\$(\"#DropDownMenu\").toggle()' class='hand inlineBlock zPrawe'");
		$retval .= Tags::span(" | ");
		$retval .= Tags::div("", "id='TaskBox'");
		$retval .= Tags::div("welcome: " . User::getCurrent()->getName(), "class='zPrawej'");
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getMenuDropDown()
	{
		$retval = Tags::li(Tags::ajaxLink("?action=GetProfile", "profile"));
		$retval .= Tags::li("Task " . $this->getTaskMenu());
		$retval .= Tags::li(Tags::ajaxLink("?action=SelectTable", "change&nbsp;table"));
		$retval .= Tags::li(Tags::a("logout", "href='?action=LogOut'"));
		$retval = Tags::ul($retval, "id='DropDownMenu' class='h'");
		$retval .= Tags::script("\$(\"#DropDownMenu\").menu()");
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getTaskMenu()
	{
		$retval = Tags::li(Tags::ajaxLink("?action=NewTask", "new"));
		$retval .= Tags::li(Tags::ajaxLink("?action=GetCurrentTask", "change"));
		$retval .= Tags::li(Tags::ajaxLink("?action=GetTaskLog", "task&nbsp;log"));
		$retval = Tags::ul($retval);
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>