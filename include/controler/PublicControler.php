<?php
/**
 * Created on 22 lut 2014 12:54:40
 * error prefix PP:201
 *
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class PublicControler extends Action
{
	// -------------------------------------------------------------------------
	public function doAction()
	{
		switch(PostChecker::get("action"))
		{
			case "":
				$this->makeWorArea();
				break;
			default:
				addAlert("PP:20101 " . PostChecker::get("action") . " nie jest obsługiwane");
				break;
		}
		$this->setLayOut(new PublicLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function makeWorArea()
	{
		$f = new LoginForm();

		$this->r->addPage($f->out());
	}
	// -------------------------------------------------------------------------
}
?>