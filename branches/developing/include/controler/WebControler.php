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
			case "GetUpFromTable":
				$this->getUpFromTable();
				break;
			case "SitDownToTable":
				$this->sitDownToTable();
				break;
			// ----------------------------
			case "CloseTaskStep2":
				$this->closeTask();
				break;
			case "CloseTask":
				$this->closeTaskForm();
				break;
			case "CleanTable":
				$this->cleanTable();
				break;
			case "PlayAgain":
				$this->getPlayAgainForm();
				break;
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
			case "LogOut":
				$this->logout();
				break;
			// ----------------------------
			case "":
				$this->makeWorArea();
				break;
			default :
				addAlert("PP:20201 " . PostChecker::get("action") . " not supported");
				break;
		}
		$this->setLayOut(new StartLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function getUpFromTable()
	{
		Player::getCurrent()->getUpFromTable();
		$this->getTableRefresh();
	}
	// -------------------------------------------------------------------------
	private function sitDownToTable()
	{
		try
		{
			$t = Table::get(PostChecker::get("arg1"));
			Player::getCurrent()->sitDownToTable($t);
			$this->getTableRefresh();
		}
		catch(Exception $e)
		{
			addAlert($e->getMessage());
		}
	}
	// -------------------------------------------------------------------------
	private function logout()
	{
		Perms::logout();
		header("Location: /");
		exit();
	}
	// -------------------------------------------------------------------------
	private function closeTask()
	{
		Task::getCurrent()->setIdCard(PostChecker::get("idcard"));
		Task::getCurrent()->save();
		$this->newTaskForm();
	}
	// -------------------------------------------------------------------------
	private function closeTaskForm()
	{
		$retval = getFormSubmitRow(Task::getCurrent()->getSubject());
		$w = new SelectCard(Task::getCurrent()->getMedianCard());
		$retval .= getFormRow("Estimated time", $w->out());
		$retval .= getFormSubmitRow(submitButton("Zapisz") . hiddenField("action", "CloseTaskStep2"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("Save esitmate time for task?", $retval);
	}
	// -------------------------------------------------------------------------
	private function cleanTable()
	{
		$this->r->closePopUp();
		Player::getCurrent()->getTable()->cleanCurrentGame();
		$this->getTableRefresh();
	}
	// -------------------------------------------------------------------------
	private function getPlayAgainForm()
	{
		$retval = getFormSubmitRow("Do U realy wan't clean table?");
		$retval .= getFormSubmitRow(submitButton("Clean") . hiddenField("action", "CleanTable"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("Question", $retval);
	}
	// -------------------------------------------------------------------------
	private function getTableRefresh()
	{
		$this->refreshTaskInfo();
		$retval = "";
		$t = Player::getCurrent()->getTable();
		$numer = 0;
		$angle = Angle::getAngles($t->getPlayersForTable()->count());
		if(Game::isAllPlayersSetCard($t))
		{
			foreach($t->getPlayersForTable() as $p)/* @var $p Player */
			{
				$g = $p->getCurrentGame();
				$retval .= $this->getPlayerItem($p, $g->getCard(), true, $angle[$numer]);
				$numer++;
			}
			$retval .= $this->getTableSummary();
		}
		else
		{
			foreach($t->getPlayersForTable() as $p)/* @var $p Player */
			{
				$c = $p->getCurrentGame()->getCard();
				if($p->getIdUser() == User::getCurrent()->getIdUser())
				{
					if($c->getIdCard() > 0)
					{
						$retval .= $this->getPlayerItem($p, $c, true, $angle[$numer]);
					}
					else
					{
						$retval .= $this->getPlayerItem($p, Card::get(), false, $angle[$numer]);
					}
				}
				else
				{
					if($c->getIdCard() > 0)
					{
						$retval .= $this->getPlayerItem($p, Card::get(), true, $angle[$numer]);
					}
					else
					{
						$retval .= $this->getPlayerItem($p, Card::get(), false, $angle[$numer]);
					}
				}
				$numer++;
			}
		}

		$this->r->addChange($retval . $this->getChairMenu(), "#PlayingTable");
	}
	// -------------------------------------------------------------------------
	private function getChairMenu()
	{
		if(Player::getCurrent()->getStatus() == Player::PLAY)
		{
			$href = "?action=GetUpFromTable";
			$content = "Get up from table";
		}
		elseif(Player::getCurrent()->getStatus() == Player::OBSERVE)
		{
			$href = "?action=SitDownToTable&amp;arg1=".Player::getCurrent()->getIdTable();
			$content = "Sit down to table";
		}
		else
		{
			$href = "#";
			$content = "UNKNOW STATUS";
		}
		$retval = Tags::span(Tags::ajaxLink($href, $content), "class='b Cinzel' style='position:absolute;top:0px; left:0px '");
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function getTableSummary()
	{
		$retval = Tags::p("Table summary", "class='c b Cinzel''");

		$cardBox = Task::getCurrent()->getMedianCard()->getTag();
		$cardTaskBox = Task::getCurrent()->getCard()->getTag();
		$actions = "";
		if(Player::getCurrent()->getRole()->getIdRole() == Role::SCRUM_MASTER)
		{
			$actions .= Tags::p(Tags::ajaxLink("?action=PlayAgain", "Clean table and play again?"), "class='b Cinzel'");
			$actions .= Tags::p(Tags::ajaxLink("?action=CloseTask", "Close / Next task"), "class='b Cinzel'");
		}
		$actions .= Tags::p("Medium time: " . Task::getCurrent()->getMediumCardValue() . " h", "class='b Cinzel'");
		$actions .= Tags::p("Median card: " . Task::getCurrent()->getMedianCard()->getName(), "class='b Cinzel'");
		$retval .= Tags::div($cardTaskBox, "class='TaskBox'");
		$retval .= Tags::div($actions, "class='ActionBox'");
		$retval .= Tags::div($cardBox, "class='CardBox'");
		$retval = Tags::div($retval, "id='TableSummary'");
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function getPlayerItem(Player $p, Card $c, $enabled, $angle)
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

		$point = $this->getPointOfSuperEclipsa($angle);
		$left = $point->x;
		$top = $point->y;
		return Tags::div($retval, "class='PlayerPlace' style='top:" . $top . "px;left:" . $left . "px;'");
	}
	// -------------------------------------------------------------------------
	/**
	 *
	 * @return Point
	 */
	private function getPointOfSuperEclipsa($angle)
	{
		$retval = new Point();
		$xAmplituda = 800 / 2;
		$yAmplituda = 350 / 2;
		$nMarker = 3;

		$degree = deg2rad($angle + 90);

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
		$t->setIdTable(Player::getCurrent()->getIdTable());
		if($t->save())
		{
			addMsg("Task saved");
			Player::getCurrent()->getTable()->setIdTask($t->getIdTask());
			if(Player::getCurrent()->getTable()->save())
			{
				$this->getTableRefresh();
				$this->r->closePopUp();
			}
		}
	}
	// -------------------------------------------------------------------------
	private function refreshTaskInfo()
	{
		$retval = Tags::ajaxLink("?action=GetTableContent", icon("ui-icon-refresh"));
		$retval .= Tags::ajaxLink("?action=GetTask", icon("ui-icon-wrench"), "Change task");
		if(is_null(Task::getCurrent()->getIdCard()))
		{
			$retval .= Tags::a(Task::getCurrent()->getSubject(), "href='" . Task::getCurrent()->getUrl() . "' target='_blank'");
		}
		else
		{
			$retval .= Tags::a(Task::getCurrent()->getSubject(), "href='" . Task::getCurrent()->getUrl() . "' target='_blank' class='s'");
		}
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
			$g = Player::getCurrent()->getCurrentGame();
			if(Game::isAllPlayersSetCard(Player::getCurrent()->getTable()))
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
				Player::getCurrent()->sitDownToTable($t);
				if(is_null(Player::getCurrent()->getCurrentGame()->getIdTask()))
				{
					$this->newTaskForm();
				}
				else
				{
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
			Player::getCurrent()->setIdRole(Role::SCRUM_MASTER);
			Player::getCurrent()->sitDownToTable($t);
			$this->refreshTableList();
			$this->r->closePopUp();
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