<?php
/**
 * Created on 22-09-2010 09:07:11
 * @package common
 */
abstract class BaseAction
{
	/**
	 *
	 * @var Retval
	 */
	public $r;
	// -------------------------------------------------------------------------
	function __construct()
	{
		$this->r = new Retval();
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Retval;
	 */
	abstract public function doAction();
	// -------------------------------------------------------------------------
	public function import(BaseAction $actionObject)
	{
		$this->r = $actionObject->r;
	}
	// -------------------------------------------------------------------------
}
?>