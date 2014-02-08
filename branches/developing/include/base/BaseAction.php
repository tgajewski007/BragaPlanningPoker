<?php
/**
 * Created on 22-09-2010 09:07:11
 * @package common
 */
abstract class BaseAction
{
	public $action = null;
	public $arg1 = null;
	public $arg2 = null;
	public $arg3 = null;
	/**
	 *
	 * @var array
	 */
	public $post = null;
	/**
	 *
	 * @var boolean
	 */
	public $js = false;
	/**
	 *
	 * @var Retval
	 */
	public $r;
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Retval;
	 */
	abstract public function doAction();
	// -------------------------------------------------------------------------
	public function import(BaseAction $actionObject)
	{
		$this->action = $actionObject->action;
		$this->arg1 = $actionObject->arg1;
		$this->arg2 = $actionObject->arg2;
		$this->arg3 = $actionObject->arg3;
		$this->post = $actionObject->post;
		$this->js = $actionObject->js;
		$this->r = $actionObject->r;
	}
	// -------------------------------------------------------------------------
}
?>