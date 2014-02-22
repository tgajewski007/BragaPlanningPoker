<?php
/**
 * Created on 4 lut 2014 09:23:53
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix PP:202
 */
class WebControler extends Action
{
	// -------------------------------------------------------------------------
	public function doAction()
	{
		switch(PostChecker::get("action"))
		{
			// ----------------------------
			case "NewTable":
				$this->getNewTableForm();
				break;
			// ----------------------------
			case "":
				$this->makeWorArea();
				break;
			default:
				addAlert("PP:20201 " . PostChecker::get("action") . " not supported");
				break;
		}
		$this->setLayOut(new StartLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function getNewTableForm()
	{
		$t = Table::get();
		$f = new TableForm($t);
		$this->r->popUpWin("New table", $f->out());
	}
	// -------------------------------------------------------------------------
	private function getAviableTableList()
	{
		$retval = Tags::p(Tags::ajaxLink("?action=NewTable", icon("ui-icon-bullet") . "Create new table"));
		foreach(Table::getAllByPrivacyStatus(PrivacyStatus::get(PrivacyStatus::STATUS_PUBLIC)) as $t) /* @var $t Table */
		{
			$retval .= Tags::p(Tags::ajaxLink("?action=GetTable", icon("ui-icon-bullet") . $t->getName()));
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function makeWorArea()
	{
		$this->r->addPage($this->getAviableTableList());
	}
	// -------------------------------------------------------------------------
}
?>