<?php
/**
 * Created on 08-04-2011 11:42:29
 * @author Tomasz.Gajewski
 * @package system
 * error prefix
 */
class TextField extends Field
{
	// -------------------------------------------------------------------------
	protected $maxLength = 255;
	protected $type = "text";
	protected $readOnly = false;
	// -------------------------------------------------------------------------
	public function setMaxLength($maxLength)
	{
		$this->maxLength = $maxLength;
	}
	// -------------------------------------------------------------------------
	public function setType($type)
	{
		$this->type = $type;
	}
	// -------------------------------------------------------------------------
	public function setReadOnly($readOnly = true)
	{
		$this->readOnly = $readOnly;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->onFocus .= "\$(this).select();";
		$this->attrib = null;
		if($this->readOnly)
		{
			$this->addAttrib("readonly", "readonly");
		}
		else
		{
			$this->onFocus .= "\$(this).addClass(\"widgetHighLight a ui-state-highlight\");";
			$this->onBlur .= "\$(this).removeClass(\"widgetHighLight a ui-state-highlight\");";
		}
		if($this->required)
		{
			$this->onKeyUp = "CzyNull(this);" . $this->onKeyUp;
			if($this->selected == "")
			{
				$this->classString .= " " . Field::CLASS_ERROR;
			}
		}

		$this->addAttrib("type", $this->type);
		$this->addAttrib("id", $this->id);
		$this->addAttrib("name", $this->name);
		$this->addAttrib("maxlength", $this->maxLength);
		$this->addAttrib("class", $this->classString);
		$this->addAttrib("value", $this->selected);
		$this->addAttrib("tabindex", $this->tabOrder);
		$this->addEvents();
		$this->addCustomAttrib();
		return Tags::input($this->attrib);
	}
	// -------------------------------------------------------------------------
}
?>