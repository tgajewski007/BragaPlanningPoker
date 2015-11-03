<?php
/**
 * Created on 15 sie 2013 14:53:51
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix
 */
class TimeField extends Field
{
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->attrib = null;
		$this->onBlur .= "CheckTime(this,".var_export($this->required,true).");";
		if($this->required)
		{
			if(null == $this->selected)
			{
				$this->classString .= " " . Field::CLASS_ERROR;
			}
		}
		$this->onFocus .= "\$(this).addClass(\"ui-state-highlight\");";
		$this->onBlur .= "\$(this).removeClass(\"ui-state-highlight\");";
		$this->addAttrib("id",$this->id);
		$this->addAttrib("name",$this->name);
		$this->addAttrib("maxlength",5);
		$this->addAttrib("class",$this->classString);
		$this->addAttrib("value",substr($this->selected,0,5));
		$this->addAttrib("tabindex",$this->tabOrder);
		$this->addEvents();
		$this->addCustomAttrib();
		$retval = Tags::input($this->attrib);
		$retval .= Tags::script("\$(\"#".$this->id."\").watermark(\"GG:MM\");");
		return Tags::div($retval,"style='width:222px'");
	}
	// -------------------------------------------------------------------------
}
?>