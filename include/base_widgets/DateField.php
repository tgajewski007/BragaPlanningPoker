<?php
/**
 *
 * @package backoffice
 * @author Tomasz.Gajewski
 * Created on 2008-07-14 12:27:37
 * klasa odpowiedzialna za wygenerowanie formatki wyboru daty
 */
class DateField extends Field
{
	// -------------------------------------------------------------------------
	protected $minValue = null;
	protected $maxValue = null;
	protected $minValueString = null;
	protected $maxValueString = null;
	protected $warn = false;
	// -------------------------------------------------------------------------
	public function enableWarn()
	{
		$this->warn = true;
	}
	// -------------------------------------------------------------------------
	public function setMinValue($minValue)
	{
		$this->minValue = $minValue;
		$this->minValueString = "minDate: new Date(" . substr($minValue, 0, 4) . ", " . (intval(substr($minValue, 5, 2)) - 1) . "," . substr($minValue, 8, 2) . "), ";
	}
	// -------------------------------------------------------------------------
	public function setMaxValue($maxValue)
	{
		$this->maxValue = $maxValue;
		$this->maxValueString = "maxDate: new Date(" . substr($maxValue, 0, 4) . ", " . (intval(substr($minValue, 5, 2)) - 1) . "," . substr($maxValue, 8, 2) . "), ";
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->attrib = null;
		$this->onBlur .= "CheckDate(this," . var_export($this->required, true) . ",\"" . $this->minValue . "\",\"" . $this->maxValue . "\");";

		if($this->required)
		{
			if(null == $this->selected)
			{
				$this->classString .= " " . Field::CLASS_ERROR;
			}
		}
		if($this->warn)
		{
			if(strlen($this->selected) > 0)
			{
				$this->addAttrib("style", "color:red");
			}
		}

		$this->onFocus .= "\$(this).addClass(\"ui-state-highlight\");";
		$this->onBlur .= "\$(this).removeClass(\"ui-state-highlight\");";
		$this->addAttrib("id", $this->id);
		$this->addAttrib("name", $this->name);
		$this->addAttrib("maxlength", 10);
		$this->addAttrib("class", $this->classString);
		$this->addAttrib("value", $this->selected);
		$this->addAttrib("tabindex", $this->tabOrder);
		$this->addEvents();
		$this->addCustomAttrib();
		$retval = Tags::input($this->attrib);

		$atrib = "class='hand' onclick='\$(\"#" . $this->id . "\").datepicker(\"show\");' " . ToolTip("Kliknij aby wybrać datę");
		$retval .= Tags::a(Icon("ui-icon-calendar", "right"), $atrib);
		$script = "\$(\"#" . $this->id . "\").watermark(\"RRRR-MM-DD\");";
		$script .= "\$(\"#" . $this->id . "\").datepicker(";
		$script .= "{showWeek: true," . $this->minValueString . $this->maxValueString . " ";
		$script .= "onClose: function(){CheckDate(\$(this)," . var_export($this->required, true) . ",\"" . $this->minValue . "\",\"" . $this->maxValue . "\",".var_export($this->warn, true).")}";
		$script .= "});";
		$retval .= Tags::script($script);
		return Tags::div($retval, "style='width:222px'");
	}
	// -------------------------------------------------------------------------
}
?>