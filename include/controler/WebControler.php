<?php
/**
 * Created on 4 lut 2014 09:23:53
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix PP:202
 *
 */
class WebControler extends Action
{
	// -------------------------------------------------------------------------
	public function doAction()
	{
		switch (PostChecker::get("action"))
		{
			case "":
				$this->makeWorArea();
				break;
			default:
				addAlert("PP:20201 " . PostChecker::get("action") . " nie jest obsługiwane");
				break;
		}
		$this->setLayOut(new StartLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function makeWorArea()
	{
		$this->r->addPage("welcome");
	}
	// -------------------------------------------------------------------------
}
?>