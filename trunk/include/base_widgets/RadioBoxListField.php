<?php
/**
 * Created on 23 lut 2014 19:00:05
 * error prefix
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class RadioBoxListField extends DropDownListField
{
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->attrib = null;
		$retval = "";
		foreach($this->dane as $value)/* @var $value WidgetItem */
		{
			if($value->getVal() == $this->selected)
			{
				$selected = " checked='checked' ";
			}
			else
			{
				$selected = "";
			}
			$retval .= Tags::input("type='radio' name='" . $this->name . "' id='" . $this->name . "_" . $value->getVal() . "' value='" . $value->getVal() . "' class='" . self::CLASS_OPTION . "' " . $selected . " " . $value->getCustomAttrib());
			$retval .= Tags::label($value->getDesc(), "for='" . $this->name . "_" . $value->getVal() . "'");
		}

		return Tags::div($retval, "id='" . $this->name . "'") . Tags::script("$( \"#" . $this->name . "\" ).buttonset();");
	}
	// -------------------------------------------------------------------------
}
?>