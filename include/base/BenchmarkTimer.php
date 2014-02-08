<?php
/**
 * Created on 14-03-2011 21:30:51
 * @author Tomasz Gajewski
 * @package frontoffice
 *
 */
require_once "Benchmark/Timer.php";
class BenchmarkTimer
{
	// -------------------------------------------------------------------------
	static $instance;
	private $timer;
	private $saveStats = true;
	// -------------------------------------------------------------------------
	private function __construct()
	{
	}
	// -------------------------------------------------------------------------
	private function __clone()
	{
	}
	// -------------------------------------------------------------------------
	static function instance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new BenchmarkTimer();
			self::$instance->timer = new Benchmark_Timer();
			self::$instance->timer->start();
		}
		return self::$instance;
	}
	// -------------------------------------------------------------------------
	static function setMark($mark)
	{
		$timer = self::instance()->timer;
		self::instance()->saveStats = false;
		$timer->setMarker(getRandomString(4) . " " . $mark);
	}
	// -------------------------------------------------------------------------
	static function saveStatistic()
	{
		if(!self::instance()->saveStats)
		{
			$timer = self::instance()->timer;
			AddTimerInfo($timer->getOutput(true, "plain"));
			self::instance()->saveStats = true;
		}
	}
	// -------------------------------------------------------------------------
}
// =============================================================================
function addTimerInfo($text)
{
	$h = fopen(INSTALL_DIRECTORY . "log/Timer(" . date(PHP_DATE_FORMAT) . ").log", "a");
	if(isset($_POST["action"]))
	{
		$action = $_POST["action"];
	}
	elseif(isset($_GET["action"]))
	{
		$action = $_GET["action"];
	}
	else
	{
		$action = "null";
	}
	fwrite($h, "===================== " . date(PHP_DATETIME_FORMAT) . " :ACTION: " . $action . " =====================\r\n");
	fwrite($h, $text);
	fwrite($h, "\r\n", 2);
	fclose($h);
}
// =============================================================================
BenchmarkTimer::instance();
// =============================================================================
?>