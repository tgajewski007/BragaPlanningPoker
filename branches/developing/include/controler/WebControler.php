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
			case "SetCard":
				$this->setCard();
				break;
			// ----------------------------
			case "GetTable":
				$this->getTable();
				break;
			case "InsTable":
				$this->insertTable();
				break;
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
	private function setCard()
	{
		try
		{
			$c = Card::get(PostChecker::get("arg1"));
			$g = Table::getCurrent()->getCurrentGame();
			$g->setIdCard($c->getIdCard());
			if($g->save())
			{
				addMsg("Card played ok");
			}
		}
		catch(Exception $e)
		{
			addAlert($e->getMessage());
		}
	}
	// -------------------------------------------------------------------------
	private function getTable()
	{
		try
		{
			$t = Table::get(PostChecker::get("arg1"));
			if($t->isCanSee())
			{
				Player::sitDownToTable($t);
				$retval = $this->getTableForm();
				$retval .= $this->getPlayerTable();
				$this->r->addChange($retval);
			}
		}
		catch(Exception $e)
		{
			addAlert($e->getMessage());
		}
	}
	// -------------------------------------------------------------------------
	private function getPlayerTable()
	{
		$retval = "";
		foreach(Card::getAll() as $c)/* @var $c Card */
		{
			$retval .= Tags::a($c->getTag(), "class='cardInHand' onclick='selectCard(this);' onmouseout='inHandCard(this);' onmouseover='focusCard(this);'");
		}
		return Tags::div($retval, "id='PlayerTable'");
	}
	// -------------------------------------------------------------------------
	private function getTableForm()
	{
		return Tags::div("", "id='PlayingTable'");
	}
	// -------------------------------------------------------------------------
	private function insertTable()
	{
		$t = Table::get();
		$t->setName(PostChecker::get("name"));
		$t->setPasswordNonHashed(PostChecker::get("password"));
		$t->setIdPrivacyStatus(PostChecker::get("idprivacy_status"));
		if($t->save())
		{
			$this->refreshTableList();
		}
	}
	// -------------------------------------------------------------------------
	private function getNewTableForm()
	{
		$t = Table::get();
		$f = new TableForm($t);
		$retval = $f->out();
		$retval .= getFormSubmitRow(submitButton("Create") . hiddenField("action", "InsTable"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("New table", $retval);
	}
	// -------------------------------------------------------------------------
	private function getAviableTableList()
	{
		$retval = Tags::p(Tags::ajaxLink("?action=NewTable", icon("ui-icon-bullet") . "Create new table"), "class='Cinzel'");
		foreach(Table::getAllByPrivacyStatus(PrivacyStatus::get(PrivacyStatus::STATUS_PUBLIC)) as $t) /* @var $t Table */
		{
			$retval .= Tags::p(Tags::ajaxLink("?action=GetTable&amp;arg1=" . $t->getIdTable(), icon("ui-icon-bullet") . $t->getName()), "class='Cinzel'");
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function refreshTableList()
	{
		$this->r->addChange($this->getAviableTableList());
	}
	// -------------------------------------------------------------------------
	private function makeWorArea()
	{
		$this->r->addPage($this->getAviableTableList());
	}
	// -------------------------------------------------------------------------
}
?>