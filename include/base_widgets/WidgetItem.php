<?php
/**
 * Created on 13 lip 2013 12:21:56
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix
 */
class WidgetItem
{
	// -------------------------------------------------------------------------
	protected $desc;
	protected $val;
	protected $customAttrib;
	// -------------------------------------------------------------------------
	function __construct($desc, $val, $custromAttrib = null)
	{
		$this->desc = $desc;
		$this->val = $val;
		$this->customAttrib = $custromAttrib;
	}
	// -------------------------------------------------------------------------
	public function getDesc()
	{
		return $this->desc;
	}
	// -------------------------------------------------------------------------
	public function getVal()
	{
		return $this->val;
	}
	// -------------------------------------------------------------------------
	public function getCustomAttrib()
	{
		return $this->customAttrib;
	}
	// -------------------------------------------------------------------------
}
?>