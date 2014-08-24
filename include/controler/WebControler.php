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
			case "InsTask":
				$this->insertTask();
				break;
			case "NewTask":
				$this->newTaskForm();
				break;
			// ----------------------------
			case "SetCard":
				$this->setCard();
				break;
			// ----------------------------
			case "GetTableContent":
				$this->getTableRefresh();
				break;
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
	private function getTableRefresh()
	{
		$retval = "";
		$t = Table::getCurrent();
		$numer = 0;
		if(Game::isAllPlayersSetCard($t))
		{
			foreach($t->getPlayersForTable() as $p)/* @var $p Player */
			{
				$g = Game::getForPlayerInTable($p, $t);
				$retval .= $this->getPlayerItem($p, $g->getCard(), true, $numer);
				$numer++;
			}
		}
		else
		{
			foreach($t->getPlayersForTable() as $p)/* @var $p Player */
			{
				$c = Game::getForPlayerInTable($p, $t)->getCard();
				if($p->getIdUser() == User::getCurrent()->getIdUser())
				{
					if($c->getIdCard() > 0)
					{
						$retval .= $this->getPlayerItem($p, $c, true, $numer);
					}
					else
					{
						$retval .= $this->getPlayerItem($p, Card::get(), false, $numer);
					}
				}
				else
				{
					if($c->getIdCard() > 0)
					{
						$retval .= $this->getPlayerItem($p, Card::get(), true, $numer);
					}
					else
					{
						$retval .= $this->getPlayerItem($p, Card::get(), false, $numer);
					}
				}
				$numer++;
			}
		}

		$this->r->addChange($retval, "#PlayingTable");
	}
	// -------------------------------------------------------------------------
	private function getPlayerItem(Player $p, Card $c, $enabled, $numer)
	{
		$retval = Tags::p($p->getUser()->getName(), "class='b c PlayerPlaceName'");
		$retval .= Tags::p($p->getUser()->getEmail(), "class='r i PlayerPlaceEmail'");
		$retval .= Tags::span("", "style='background-image: url(\"" . $p->getUser()->getAvatarUrl() . "\");' class='r i PlayerPlaceAvatar zLewej'");
		if($enabled)
		{
			$retval .= Tags::span($c->getTag(), "class='PlayerPlaceCard'");
		}
		else
		{
			$retval .= Tags::span(Tags::span($c->getTag(), "class='ui-state-disabled'"), "class='PlayerPlaceCard'");
		}

		$point = $this->getPointOfSuperEclipsa($numer);
		$left = $point->x;
		$top = $point->y;
		return Tags::div($retval, "class='PlayerPlace' style='top:" . $top . "px;left:" . $left . "px;'");
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Point
	 */
	private function getPointOfSuperEclipsa($numer)
	{
		$retval = new Point();
		static $countOfPlayers = null;
		if(empty($countOfPlayers))
		{
			$countOfPlayers = Table::getCurrent()->getPlayersForTable()->count();
		}
		$xAmplituda = 800 / 2;
		$yAmplituda = 350 / 2;
		$nMarker = 3;

		$degree = deg2rad((360 / $countOfPlayers * $numer) + 90);

		$cos = cos($degree);
		$sin = sin($degree);

		$cosSign = $cos >= 0 ? 1 : -1;
		$sinSign = $sin >= 0 ? 1 : -1;

		$retval->x = (0.9 * $xAmplituda * $cosSign * (pow(abs($cos), (2 / $nMarker)))) + $xAmplituda;
		$retval->y = (0.9 * $yAmplituda * $sinSign * (pow(abs($sin), (2 / $nMarker)))) + $yAmplituda;

		return $retval;
	}
	// -------------------------------------------------------------------------
	private function insertTask()
	{
		$t = Task::get();
		$t->setSubject(PostChecker::get("subject"));
		$t->setUrl(PostChecker::get("url"));
		$t->setIdTable(Table::getCurrent()->getIdTable());
		if($t->save())
		{
			addMsg("Task saved");
			Table::getCurrent()->setIdTask($t->getIdTask());
			if(Table::getCurrent()->save())
			{
				addMsg("Table task actualized");
				$this->refreshTaskInfo();
			}
		}
	}
	// -------------------------------------------------------------------------
	private function refreshTaskInfo()
	{
		$retval = Tags::ajaxLink("?action=GetTask", icon("ui-icon-wrench"), "Change task");
		$retval .= Tags::a(Task::getCurrent()->getSubject(), "href='" . Task::getCurrent()->getUrl() . "' target='_blank'");
		$this->r->addChange($retval, "#TaskBox");
	}
	// -------------------------------------------------------------------------
	private function newTaskForm()
	{
		$t = Task::get();
		$f = new TaskForm($t);
		$retval = $f->out();
		$retval .= getFormSubmitRow(submitButton("Create") . hiddenField("action", "InsTask"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("New task", $retval);
	}
	// -------------------------------------------------------------------------
	private function setCard()
	{
		try
		{
			$c = Card::get(PostChecker::get("arg1"));
			$g = Table::getCurrent()->getCurrentGame();
			if(Game::isAllPlayersSetCard(Table::getCurrent()))
			{
				addAlert("PP:20202 Change card is unaviable. All card played");
			}
			else
			{

				$g->setIdCard($c->getIdCard());
				if($g->save())
				{
					addMsg("Card " . $c->getName() . " played ok");
					$this->getTableRefresh();
				}
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
				if(is_null(Task::getCurrent()->getIdTask()))
				{
					$tmp = Tags::ajaxLink("?action=NewTask", "New task...");
					$this->r->addChange($tmp, "#TaskBox");
				}
				else
				{
					$this->refreshTaskInfo();
					$retval .= $this->getPlayerTable();
				}
				$this->r->addChange($retval);
				$this->getTableRefresh();
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
		return Tags::div("", "id='PlayingTable'") . Tags::script("startRefreshTable();");
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