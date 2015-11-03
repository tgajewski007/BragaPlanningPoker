<?php
/**
 * Created on 17-05-2011 07:55:40
 * @author Tomasz.Gajewski
 * @package system
 * error prefix
 */
class FloatField extends Field
{
	// -------------------------------------------------------------------------
	protected $minValue = "null";
	protected $maxValue = "null";
	protected $precision = 2;
	protected $maxLength = 22;
	protected $type = "text";
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
	public function setMinValue($minValue)
	{
		$this->minValue = $minValue;
	}
	// -------------------------------------------------------------------------
	public function setMaxValue($maxValue)
	{
		$this->maxValue = $maxValue;
	}
	// -------------------------------------------------------------------------
	public function setPrecision($precision)
	{
		$this->precision = $precision;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->onFocus .= "\$(this).select();";
		$this->onFocus .= "\$(this).addClass(\"ui-state-highlight\");";
		$this->onBlur .= "\$(this).removeClass(\"ui-state-highlight\");";
		$this->attrib = null;
		$this->classString .= " r";
		if($this->required)
		{
			$this->onChange .= "if(CzyReal(this," . $this->minValue . "," . $this->maxValue . "," . $this->precision . ")){CzyNull(this);}";
			if("" == $this->selected)
			{
				$this->classString .= " " . Field::CLASS_ERROR;
			}
		}
		else
		{
			$this->onChange .= "CzyReal(this," . $this->minValue . "," . $this->maxValue . "," . $this->precision . ");";
		}

		if(null != $this->selected)
		{
			// sprawdzenie czy poza max / min
			if($this->maxValue != "null")
			{
				if($this->selected > $this->maxValue)
				{
					$this->classString .= " " . Field::CLASS_ERROR;
				}
			}
			elseif($this->minValue != "null")
			{
				if($this->selected < $this->minValue)
				{
					$this->classString .= " " . Field::CLASS_ERROR;
				}
			}
			$this->selected = number_format($this->selected, $this->precision, ".", "");
		}

		$this->addAttrib("type", $this->type);
		$this->addAttrib("id", $this->id);
		$this->addAttrib("name", $this->name);
		$this->addAttrib("class", $this->classString);
		$this->addAttrib("value", $this->selected);
		$this->addAttrib("tabindex", $this->tabOrder);
		$this->addAttrib("maxlength", $this->maxLength);
		$this->addEvents();
		$this->addCustomAttrib();
		return Tags::input($this->attrib);
	}
	// -------------------------------------------------------------------------
}
?>