<?php
/**
 *
 * @package common
 * @author Tomasz.Gajewski
 * @abstract Created on 2009-04-06 10:40:13
 * klasa odpowiedzialna za pętle komunikatów oraz wstępne sprawdzenie
 * przychodzących danych
 */
abstract class Action extends BaseAction
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var GLayout
	 */
	protected $layOut;
	// -------------------------------------------------------------------------
	public function __destruct()
	{
		if(class_exists("BenchmarkTimer", true))
		{
			BenchmarkTimer::saveStatistic();
		}
	}
	// -------------------------------------------------------------------------
	protected function setLayOut(GLayout $layOut)
	{
		$this->layOut = $layOut;
	}
	// -------------------------------------------------------------------------
	protected function prePage()
	{
		return true;
	}
	// -------------------------------------------------------------------------
	protected function postPage()
	{
		return true;
	}
	// -------------------------------------------------------------------------
	final protected function page()
	{
		$this->prePage();
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			if(!headers_sent())
			{
				header("Content-type: text/xml; charset-utf-8");
				echo $this->r->getAjax();
			}
			exit();
		}
		else
		{
			$this->layOut->out($this->r->getPage());
		}
		$this->postPage();
	}
	// -------------------------------------------------------------------------
}
?>