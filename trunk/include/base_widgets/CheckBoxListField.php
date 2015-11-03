<?php
/**
 * Created on 28 sie 2013 20:50:10
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix
 */
class CheckBoxListField extends Field
{
	// -------------------------------------------------------------------------
	protected $dane = array();
	// -------------------------------------------------------------------------
	public function addItem(WidgetItem $item)
	{
		$this->dane[] = $item;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = "";
		foreach($this->dane as $value)/* @var $value WidgetItem */
		{
			$a = new CheckBoxField();
			$a->setName($this->name."[]");
			$a->setId($this->name."_".$value->getVal());
			$a->setSelected(isset($this->selected[$value->getVal()]));
			$a->setValue($value->getVal());
			$retval .= Tags::p($a->out().Tags::label($value->getDesc()));
		}
		return Tags::div($retval, "class='ui-widget-content ui-corner-all'");
	}
	// -------------------------------------------------------------------------
}
?>