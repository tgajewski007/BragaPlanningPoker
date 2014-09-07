<?php
/**
 * Created on 7 wrz 2014 14:34:38
 * author Tomasz Gajewski
 * package frontoffice
 * error prefix
 *
 */
class SelectCard extends DropDownListField
{
	// -------------------------------------------------------------------------
	function __construct(Card $karta)
	{
		foreach (Card::getAll() as $c)/* @var $c Card */
		{
			$this->addItem(new WidgetItem($c->getName(), $c->getIdCard()));
		}
		$this->setSelected($karta->getIdCard());
		$this->setName("idcard");
	}
	// -------------------------------------------------------------------------
}
?>