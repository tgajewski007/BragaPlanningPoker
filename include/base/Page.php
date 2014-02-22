<?php
/**
 * Created on 17-10-2011 18:22:59
 *
 * @author Tomasz Gajewski
 * @package enmarket
 * error prefix
 */
class Page
{
	// -------------------------------------------------------------------------
	const VERSION = "a";
	// -------------------------------------------------------------------------
	protected static function getHead()
	{
		$title = "Planning Poker Online";
		$retval = Tags::meta("http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"");
		$retval .= "<!--[if IE]>".Tags::meta("http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\"")."<![endif]-->";
		$retval .= Tags::title($title);
		$retval .= Tags::link("rel='shortcut icon' href='/img/favicon.ico'");
		if(PRODUCTION)
		{
			$retval .= Tags::link("rel='stylesheet' type='text/css' href='" . STATIC_URL . "css/style.css?" . self::VERSION . "'");
		}
		else
		{
			$retval .= Tags::link("rel='stylesheet' type='text/css' href='/style/style.css?" . self::VERSION . "'");
		}
		$retval .= self::getScripts();
		return Tags::head($retval);
	}
	// -------------------------------------------------------------------------
	protected static function getScripts()
	{
		$loadScript = "jsl.add('/scripts/ui/i18n/jquery.ui.datepicker-pl.min.js?" . self::VERSION . "');";
		$loadScript .= "jsl.add('/scripts/system.js?" . self::VERSION . "');";
		$loadScript .= "jsl.add('/scripts/utils.js?" . self::VERSION . "');";
		$loadScript .= "jsl.add('/scripts/popUpWindow.js?" . self::VERSION . "');";
		$loadScript .= "jsl.add('/scripts/widgets.js?" . self::VERSION . "');";
		$loadScript .= "jsl.load();";

		$retval = Tags::script("", "type='text/javascript' src='https://code.jquery.com/jquery-1.10.2.min.js'");
		$retval .= Tags::script("", "type='text/javascript' src='https://code.jquery.com/ui/1.10.4/jquery-ui.min.js'");
		$retval .= Tags::script("", "type='text/javascript' src='/scripts/ajax.js?" . self::VERSION . "'");
		$retval .= Tags::script("", "type='text/javascript' src='/scripts/jquery.tablesorter.min.js?" . self::VERSION . "'");
		$retval .= Tags::script("", "type='text/javascript' src='/scripts/jquery.watermark.min.js?" . self::VERSION . "'");
		$retval .= Tags::script("", "type='text/javascript' src='/scripts/jsl.min.js?" . self::VERSION . "'");
		$retval .= Tags::script($loadScript);
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected static function getDocType()
	{
		$retval = "<!DOCTYPE html>\n";
		$retval .= "<!-- generated: " . date("D, d M Y H:i:s") . " -->\n";
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected static function sendHttpHeaders()
	{
		header("Expires:" . date("D, d M Y H:i:s") . "");
		header("Cache-Control: no-transform; max-age=0; proxy-revalidate ");
		header("Cache-Control: no-cache; must-revalidate; no-store; post-check=0; pre-check=0 ");
		header("Pragma: no-cache");
		header("Content-Type: text/html; charset=UTF-8");
	}
	// -------------------------------------------------------------------------
	protected static function getGoogleAnalitics()
	{
		if(PRODUCTION)
		{
			return Tags::script("(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-4124265-4', 'enmarket.pl');ga('send', 'pageview');");
		}
	}
	// -------------------------------------------------------------------------
	static function make($bodyContent)
	{
		if(!headers_sent())
		{
			self::sendHttpHeaders();
			$page = self::getHead() . Tags::body($bodyContent . self::getGoogleAnalitics(), "id='Body'");
			$page = Tags::html($page);
			$page = self::getDocType() . $page;
			if(FORMAT_XML)
			{
				$doc = new DOMDocument();
				$doc->loadHTML($page);
				$doc->formatOutput = true;
				echo $doc->saveHTML();
			}
			else
			{
				echo $page;
			}
			flush();
		}
	}
	// -------------------------------------------------------------------------
}
?>