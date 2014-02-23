<?php
/**
 * Created on 22 lut 2014 13:19:17
 * error prefix
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class PublicLayout implements GLayout
{
	// -------------------------------------------------------------------------
	public function out($content = null)
	{
		$retval = $this->getHeader();
		$retval .= $this->getContent($content);
		$retval .= $this->getFooter();
		$retval .= Tags::div(getMsg(), "id='MsgBox'");
		Page::make($retval);
	}
	// -------------------------------------------------------------------------
	protected function getHeader()
	{
		return Tags::div(Tags::p(Tags::a("Planning Poker Online","href='/'")),"id='Header' class='Cinzel'");
	}
	// -------------------------------------------------------------------------
	protected function getContent($content)
	{
		return Tags::div($content,"id='PublicMainBox'");
	}
	// -------------------------------------------------------------------------
	protected function getFooter()
	{
		$retval = Tags::a("Contact","href='/wiki/contacts.html'");
		$retval .= Tags::span(" | ");
		$retval .= Tags::a("About","href='/wiki/about.html'");
		$retval .= Tags::span(" | ");
		$retval .= Tags::a("Copyright &amp; Licence","href='/wiki/licence.html'");
		$retval = Tags::p($retval);
		$retval = Tags::div($retval,"id='Footer'  class='Cinzel'");
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>