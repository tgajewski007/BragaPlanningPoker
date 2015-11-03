<?php
/**
 * Created on 22 lut 2014 18:56:50
 * error prefix
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class TableForm extends Field
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var Table
	 */
	protected $table = null;
	// -------------------------------------------------------------------------
	function __construct(Table $t)
	{
		$this->table = $t;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = getFormRow("Table name", textField("name", $this->table->getName(), true));
		$retval .= getFormRow("Password", passwordField("password"));
		if(is_null($this->table->getIdPrivacyStatus()))
		{
			$w = new PrivacyStatusSelect(PrivacyStatus::STATUS_PROTECTED);
		}
		else
		{
			$w = new PrivacyStatusSelect($this->table->getIdPrivacyStatus());
		}
		$retval .= getFormRow("Privacy status", $w->out());

		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>