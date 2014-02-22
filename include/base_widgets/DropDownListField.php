<?php
/**
 * Created on 10-06-2011 10:45:23
 *
 * @author Tomasz.Gajewski
 * @package system
 * error prefix
 */
class DropDownListField extends Field
{
	// -------------------------------------------------------------------------
	const CLASS_OPTION = "";
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
		$this->attrib = null;
		$retval = "";
		foreach($this->dane as $value)/* @var $value WidgetItem */
		{
			if($value->getVal() == $this->selected)
			{
				$selected = " selected='selected' ";
			}
			else
			{
				$selected = "";
			}
			$retval .= Tags::option($value->getDesc(), "value='" . $value->getVal() . "' class='" . self::CLASS_OPTION . "' " . $selected . " " . $value->getCustomAttrib());
		}

		$this->addAttrib("id", $this->id);
		$this->addAttrib("name", $this->name);
		$this->addAttrib("class", $this->classString);
		$this->addAttrib("tabindex", $this->tabOrder);
		$this->addEvents();
		$this->addCustomAttrib();
		return Tags::select($retval, $this->attrib);
	}
	// -------------------------------------------------------------------------
}
?>