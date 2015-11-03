<?php
/**
 * Created on 4 lut 2014 09:23:53
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
			case "UpdProfile":
				$this->updateProfile();
				break;
			case "GetProfile":
				$this->getProfile();
				break;
			// ----------------------------
			case "MakeMePO":
				$this->makeMeProductOwner();
				break;
			case "MakeMeBanco":
				$this->makeMeBanco();
				break;
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
			case "GetTaskLog":
				$this->getTaskLogForm();
				break;
			case "GetCurrentTask":
				$this->getCurrentTaskForm();
				break;
			case "UpdTask":
				$this->updateTask();
				break;
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
			case "SelectTable":
				$this->getUpFromTable();
				$this->refreshTableList();
				break;
			// ----------------------------
			case "GetTableContent":
				$this->refreshTable();
				break;
			case "GetTableDirect":
				$this->getTableDirect();
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
				$this->getUpFromTable();
				$this->logout();
				break;
			// ----------------------------
			case "":
				$this->makeWorkArea();
				break;
			default :
				addAlert("PP:20201 " . PostChecker::get("action") . " not supported");
				break;
		}
		$this->setLayOut(new StartLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function updateProfile()
	{
		$u = User::getCurrent();
		$u->setName(PostChecker::get("name"));
		$u->setEmail(PostChecker::get("email"));
		$u->setAvatarUrl(PostChecker::get("avatar_url"));
		if($u->save())
		{
			addMsg("Update successfull");
			$this->r->closePopUp();
		}
	}
	// -------------------------------------------------------------------------
	private function getProfile()
	{
		$f = new UserForm(User::getCurrent());
		$retval = $f->out();
		$retval .= getFormSubmitRow(submitButton("Update") . hiddenField("action", "UpdProfile"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("Profile", $retval);
	}
	// -------------------------------------------------------------------------
	private function makeMeProductOwner()
	{
		foreach(Player::getAllByTable(Table::getCurrent()) as $p)/* @var $p Player */
		{
			if($p->getIdRole() == Role::PRODUCT_OWNER)
			{
				$p->setIdRole(Role::DEVELOPER);
				$p->save();
			}
		}
		Player::getCurrent()->setIdRole(Role::PRODUCT_OWNER);
		Player::getCurrent()->save();
		$this->refreshTable();
	}
	// -------------------------------------------------------------------------
	private function makeMeBanco()
	{
		foreach(Player::getAllByTable(Table::getCurrent()) as $p)/* @var $p Player */
		{
			if($p->getIdRole() == Role::BANCO)
			{
				$p->setIdRole(Role::DEVELOPER);
				$p->save();
			}
		}
		Player::getCurrent()->setIdRole(Role::BANCO);
		Player::getCurrent()->save();
		$this->refreshTable();
	}
	// -------------------------------------------------------------------------
	private function getUpFromTable()
	{
		if(!is_null(Table::getCurrent()->getIdTable()))
		{
			Player::getCurrent()->getUpFromTable();
			$this->refreshTable();
		}
	}
	// -------------------------------------------------------------------------
	private function sitDownToTable()
	{
		try
		{
			$t = Table::get(PostChecker::get("arg1"));
			Player::getCurrent()->sitDownToTable($t);
			$this->refreshTable();
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
		$this->refreshTable();
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
	private function refreshTable()
	{
		$this->refreshTaskInfo();
		$retval = "";
		$table = Player::getCurrent()->getTable();
		$numer = 0;
		$angle = Angle::getAngles($table->getPlayersForTable()->count());
		if(Game::isAllPlayersSetCard($table))
		{
			foreach($table->getPlayersForTable() as $p)/* @var $p Player */
			{
				if($p->getIdRole() != Role::OBSERVER)
				{
					$g = $p->getCurrentGame();
					$retval .= $this->getPlayerItem($p, $g->getCard(), true, $angle[$numer]);
					$numer++;
				}
			}
			$retval .= $this->getTableSummary();
		}
		else
		{
			foreach($table->getPlayersForTable() as $p)/* @var $p Player */
			{
				if($p->getIdRole() != Role::OBSERVER)
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
		}
		
		$this->r->addChange($retval . $this->getChairMenu(), "#PlayingTable");
	}
	// -------------------------------------------------------------------------
	private function getChairMenu()
	{
		if(Player::getCurrent()->getIdRole() == Role::OBSERVER)
		{
			$href = "?action=SitDownToTable&amp;arg1=" . Player::getCurrent()->getIdTable();
			$content = "Sit down to table";
		}
		else
		{
			$href = "?action=GetUpFromTable";
			$content = "Get up from table";
		}
		$retval = Tags::span(Tags::ajaxLink($href, $content), "class='b Cinzel' style='position:absolute;top:0px; left:0px '");
		if(Player::getCurrent()->getIdRole() != Role::BANCO)
		{
			$href = "?action=MakeMeBanco";
			$content = "Make me Banco";
			$retval .= Tags::span(Tags::ajaxLink($href, $content), "class='b Cinzel' style='position:absolute;top:16px; left:0px '");
		}
		if(Player::getCurrent()->getIdRole() != Role::PRODUCT_OWNER)
		{
			$href = "?action=MakeMePO";
			$content = "Make me Product Owner";
			$retval .= Tags::span(Tags::ajaxLink($href, $content), "class='b Cinzel' style='position:absolute;top:32px; left:0px '");
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function getTableSummary()
	{
		$retval = Tags::p("Table summary", "class='c b Cinzel''");
		
		$cardBox = Task::getCurrent()->getMedianCard()->getTag();
		$cardTaskBox = Task::getCurrent()->getCard()->getTag();
		$actions = "";
		if(Player::getCurrent()->getRole()->getIdRole() == Role::BANCO)
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
		return Tags::div($retval, "class='PlayerPlace " . $this->getClassForPlayerPlace($p) . "' style='top:" . $top . "px;left:" . $left . "px;'");
	}
	// -------------------------------------------------------------------------
	private function getClassForPlayerPlace(Player $p)
	{
		if($p->getIdRole() == Role::BANCO)
		{
			return "BankoPlace";
		}
		elseif($p->getIdRole() == Role::PRODUCT_OWNER)
		{
			return "ProductOwnerPlace";
		}
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
	private function refreshTaskInfo()
	{
		$retval = "";
		$href = "";
		if(Task::getCurrent()->getUrl() != "")
		{
			$href = "href='" . Task::getCurrent()->getUrl() . "' target='_blank' ";
		}
		if(is_null(Task::getCurrent()->getIdCard()))
		{
			$retval .= Tags::a("Task: " . Task::getCurrent()->getSubject(), $href . "");
		}
		else
		{
			$retval .= Tags::a("Task: " . Task::getCurrent()->getSubject(), $href . "class='s'");
		}
		$this->r->addChange($retval, "#TaskBox");
	}
	// -------------------------------------------------------------------------
	private function getTaskLogForm()
	{
		$table = Player::getCurrent()->getTable();
		$taskLogForm = new TaskLogForm($table);
		$retval = $taskLogForm->out();
		$this->r->popUpWin("Task log", $retval);
	}
	// -------------------------------------------------------------------------
	private function getCurrentTaskForm()
	{
		$t = Player::getCurrent()->getTable()->getTask();
		$f = new TaskForm($t);
		$retval = $f->out();
		$retval .= getFormSubmitRow(submitButton("Update") . hiddenField("action", "UpdTask"));
		$retval = Tags::formularz($retval);
		$this->r->popUpWin("New task", $retval);
	}
	// -------------------------------------------------------------------------
	private function newTaskForm()
	{
		if(Player::getCurrent()->canCreateTask())
		{
			$t = Task::get();
			$f = new TaskForm($t);
			$retval = $f->out();
			$retval .= getFormSubmitRow(submitButton("Create") . hiddenField("action", "InsTask"));
			$retval = Tags::formularz($retval);
			$this->r->popUpWin("New task", $retval);
		}
		else
		{
			addAlert("PP:20202 Your role precludes the creation of task");
		}
	}
	// -------------------------------------------------------------------------
	private function updateTask()
	{
		if(Player::getCurrent()->canCreateTask())
		{
			$task = Player::getCurrent()->getTable()->getTask();
			$task->setSubject(PostChecker::get("subject"));
			$task->setUrl(PostChecker::get("url"));
			if($task->save())
			{
				addMsg("Task saved");
				$this->r->closePopUp();
			}
		}
		else
		{
			addAlert("PP:20203 Your role precludes the creation of task");
		}
	}
	// -------------------------------------------------------------------------
	private function insertTask()
	{
		if(Player::getCurrent()->canCreateTask())
		{
			$task = Task::get();
			$task->setSubject(PostChecker::get("subject"));
			$task->setUrl(PostChecker::get("url"));
			$task->setIdTable(Player::getCurrent()->getIdTable());
			if($task->save())
			{
				addMsg("Task saved");
				Player::getCurrent()->getTable()->setIdTask($task->getIdTask());
				if(Player::getCurrent()->getTable()->save())
				{
					Game::initByPlayer(Player::getCurrent());
					PostChecker::set("arg1", Table::getCurrent()->getIdTable());
					$this->getTable();
					$this->r->closePopUp();
				}
			}
		}
		else
		{
			addAlert("PP:20204 Your role precludes the creation of task");
		}
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
				addAlert("PP:20205 Change card is unaviable. All card played");
			}
			else
			{
				if($g->getPlayer()->isPlaying())
				{
					$g->setIdCard($c->getIdCard());
					if($g->save())
					{
						addMsg("Card " . $c->getName() . " played ok");
						$this->refreshTable();
					}
				}
				else
				{
					addAlert("PP:20206 You can't play card when not sitting at the table");
				}
			}
		}
		catch(Exception $e)
		{
			addAlert($e->getMessage());
		}
	}
	// -------------------------------------------------------------------------
	private function getTableDirect()
	{
		try
		{
			$t = Table::get(PostChecker::get("arg1"));
			$this->makeWorkArea();
			$this->r->addPage(Tags::script("\$(document).ready(function(){ajax.get(\"?action=GetTable&arg1=" . $t->getIdTable() . "\");});"));
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
			Table::setCurrent($t);
			if($t->isCanSee())
			{
				Player::getCurrent()->sitDownToTable($t);
				if(is_null($t->getIdTask()))
				{
					$this->newTaskForm();
				}
				else
				{
					$this->prepareTable();
					$this->getPlayerCards();
					$this->refreshTable();
				}
			}
		}
		catch(Exception $e)
		{
			addAlert($e->getMessage());
		}
	}
	// -------------------------------------------------------------------------
	private function getPlayerCards()
	{
		$retval = "";
		foreach(Card::getAll() as $c)/* @var $c Card */
		{
			$retval .= Tags::a($c->getTag(), "class='cardInHand' onclick='selectCard(this);' onmouseout='inHandCard(this);' onmouseover='focusCard(this);'");
		}
		$this->r->addChange($retval, "#PlayerCards");
	}
	// -------------------------------------------------------------------------
	private function prepareTable()
	{
		$this->r->addChange(Tags::div("", "id='PlayingTable'") . Tags::div("", "id='PlayerCards'") . Tags::script("startRefreshTable();"));
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
			$this->r->closePopUp();
			Table::setCurrent($t);
			Player::getCurrent()->setIdRole(Role::BANCO);
			Player::getCurrent()->sitDownToTable($t);
			PostChecker::set("arg1", $t->getIdTable());
			$this->sendEmailWithTableInfoToCreator($t);
			$this->getTable();
		}
	}
	// -------------------------------------------------------------------------
	private function sendEmailWithTableInfoToCreator(Table $t)
	{
		$m = new Poczta();
		$m->addTo(User::getCurrent()->getEmailAddress());
		$message = "Hi " . User::getCurrent()->getName() . Tags::br();
		$message .= "just created a new " . $t->getPrivacyStatus()->getName() . " table " . $t->getName() . Tags::br();
		$message .= "for fast open table just click " . Tags::a("here", "href='" . BASE_URL . "?action=GetTableDirect&arg1=" . $t->getIdTable() . "'") . Tags::br();
		$m->setMessage($message);
		$m->sendMails();
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
	private function getIconForTable(Table $t)
	{
		if($t->getIdPrivacyStatus() == PrivacyStatus::STATUS_PRIVATE)
		{
			$icon = icon("ui-icon-bullet");
		}
		elseif($t->getIdPrivacyStatus() == PrivacyStatus::STATUS_PROTECTED)
		{
			$icon = icon("ui-icon-radio-on");
		}
		else
		{
			$icon = icon("ui-icon-radio-off");
		}
		return $icon;
	}
	// -------------------------------------------------------------------------
	private function getAviableTableList()
	{
		$retval = Tags::p(Tags::ajaxLink("?action=NewTable", icon("ui-icon-circle-plus") . "Create new table"), "class='Cinzel'");
		foreach(Table::getAllForCurrentUser() as $t) /* @var $t Table */
		{
			$icon = $this->getIconForTable($t);
			$retval .= Tags::p(Tags::ajaxLink("?action=GetTable&amp;arg1=" . $t->getIdTable(), $icon . $t->getName()), "class='Cinzel'");
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	private function refreshTableList()
	{
		$this->r->addChange($this->getAviableTableList());
	}
	// -------------------------------------------------------------------------
	private function makeWorkArea()
	{
		$this->r->addPage($this->getAviableTableList());
	}
	// -------------------------------------------------------------------------
}
?>