<?php
/**
 * Created on 15-10-2011 13:54:44
 * @author Tomasz Gajewski
 * @package common
 * error prefix
 */
define("PRODUCTION", false);

define("DB_HOST", "localhost");
define("DB_SCHEMA", "plannigpoker");
define("DB_USER", "root");
define("DB_PASS", "1");

define("BAD_LOGIN_COUNT_LIMIT", 6);
define("HASH_ALGORYTM", "sha1");
define("VERSION", "0.0.18");
define("INSTALL_DIRECTORY", "o:/wwwroot/PHPPlaningPoker/");
define("LOG_DIRECTORY", INSTALL_DIRECTORY . "log/");
define("DEBUG", true);
define("FORMAT_XML", true);
define("PHP_DATE_FORMAT", "Y-m-d");
define("PHP_DATETIME_FORMAT", "Y-m-d H:i:s");

define("PAGELIMIT", 15);
define("STATIC_URL", "/");

define("BASE_URL", "http://poker/");

mb_internal_encoding("utf8");
// ini_set("max_execution_time", "0");
date_default_timezone_set("Europe/Warsaw");

// -----------------------------------------------------------------------------
function errorHandler($errno, $errstr, $errfile, $errline)
{
	switch($errno)
	{
		case E_ERROR:
			$file = "error_" . date("Ymd") . ".log";
			break;
		case E_WARNING:
			$file = "warn_" . date("Ymd") . ".log";
			break;
		case E_PARSE:
			$file = "parse_" . date("Ymd") . ".log";
			break;
		case E_NOTICE:
			$file = "notice_" . date("Ymd") . ".log";
			break;
		case E_CORE_ERROR:
			$file = "core_error_" . date("Ymd") . ".log";
			break;
		case E_CORE_WARNING:
			$file = "core_warn_" . date("Ymd") . ".log";
			break;
		case E_COMPILE_ERROR:
			$file = "compile_error_" . date("Ymd") . ".log";
			break;
		case E_COMPILE_WARNING:
			$file = "compile_warn_" . date("Ymd") . ".log";
			break;
		case E_USER_ERROR:
			$file = "user_error_" . date("Ymd") . ".log";
			break;
		case E_USER_WARNING:
			$file = "user_warn_" . date("Ymd") . ".log";
			break;
		case E_USER_NOTICE:
			$file = "user_notice_" . date("Ymd") . ".log";
			break;
		case E_STRICT:
			$file = "strict_" . date("Ymd") . ".log";
			break;
		case E_RECOVERABLE_ERROR:
			$file = "recoverable_error_" . date("Ymd") . ".log";
			break;
		case E_DEPRECATED:
			$file = "deprec_" . date("Ymd") . ".log";
			break;
		case E_USER_DEPRECATED:
			$file = "deprec_error_" . date("Ymd") . ".log";
			break;
		case E_ALL:
			$file = "all_error_" . date("Ymd") . ".log";
			break;
		default :
			$file = "unknow_" . date("Ymd") . ".log";
			break;
	}
	$retval = date(PHP_DATETIME_FORMAT);
	$retval .= ";" . $errno;
	$retval .= ";" . $errstr;
	$retval .= ";" . $errfile;
	$retval .= ";" . $errline;
	$retval .= "\n";
	
	$file = LOG_DIRECTORY . $file;
	$h = fopen($file, "a");
	fwrite($h, $retval, mb_strlen($retval));
	fclose($h);
	return false;
}
// -----------------------------------------------------------------------------
function exceptionHandler(Exception $exception)
{
	$file = "exception_" . date("Ymd") . ".log";
	$retval = date(PHP_DATETIME_FORMAT);
	$retval .= ";" . $exception->getCode();
	$retval .= ";" . $exception->getMessage();
	$retval .= ";" . $exception->getFile();
	$retval .= ";" . $exception->getLine();
	$retval .= "\n";
	$file = LOG_DIRECTORY . $file;
	$h = fopen($file, "a");
	fwrite($h, $retval, strlen($retval));
	fclose($h);
	return false;
}
// -----------------------------------------------------------------------------
if(DEBUG)
{
	set_error_handler("errorHandler");
	set_exception_handler("exceptionHandler");
}
?>