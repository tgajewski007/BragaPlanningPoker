<?php
/**
 * Created on 23 lut 2014 18:50:30
 * error prefix
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class PrivacyStatusSelect extends RadioBoxListField
{
	// -------------------------------------------------------------------------
	public function __construct($selected)
	{
		foreach (PrivacyStatus::getAll() as $p)/* @var $p PrivacyStatus */
		{
			$this->addItem(new WidgetItem($p->getName(), $p->getIdPrivacyStatus()));
		}
		$this->setSelected($selected);
		$this->setName("idprivacy_status");
	}
	// -------------------------------------------------------------------------
}
?>