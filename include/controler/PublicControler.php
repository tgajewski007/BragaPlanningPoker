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
			// -------------------------------------
			case "CreateAccout":
				$this->createAccout();
				break;
			case "GetRegisterForm":
				$this->getRegisterForm();
				break;
			// -------------------------------------
			case "":
			default :
				$this->makeWorArea();
				break;
// 				addAlert("PP:20101 " . PostChecker::get("action") . " not supported");
// 				break;
		}
		$this->setLayOut(new PublicLayout());
		$this->page();
	}
	// -------------------------------------------------------------------------
	private function createAccout()
	{
		$u = User::get();
		if($this->isPasswordOK())
		{
			$u->setUserName(PostChecker::get("username"));
			$u->setName(PostChecker::get("name"));
			$u->setEmail(PostChecker::get("email"));
			$u->setAvatarUrl(PostChecker::get("avatar_url"));
			$u->setPassword(PostChecker::get("pass1"));
			if($u->save())
			{
				addMsg("Welcome");
				Perms::setLoggedIn($u);
				header("Location: /");
				exit();
			}
		}
	}
	// -------------------------------------------------------------------------
	private function isPasswordOK()
	{
		$retval = true;
		$pass1 = PostChecker::get("pass1");
		$pass2 = PostChecker::get("pass2");
		if($pass1 != $pass2)
		{
			addAlert("PP:20101 Passwords are not the same");
			$retval = false;
		}
		if(mb_strlen($pass1) < Perms::PASSWORD_MINIMAL_LENGTH)
		{
			addAlert("PP:20101 Passwords are too short (min: " . Perms::PASSWORD_MINIMAL_LENGTH . " character)");
			$retval = false;
		}

		return $retval;
	}
	// -------------------------------------------------------------------------
	private function getRegisterForm()
	{
		$retval = getFormRow("Username", textField("username", "", true));
		$retval .= getFormRow("Fullname", textField("name", "", true));
		$retval .= getFormRow("Email", textField("email"));
		$retval .= getFormRow("Avatar url", textField("avatar_url"));
		$retval .= getFormRow("Password", passwordField("pass1", "", true));
		$retval .= getFormRow("Retype password", passwordField("pass2", "", true));

		$retval .= getFormSubmitRow(submitButton("Register") . hiddenField("action", "CreateAccout"));
		$retval = Tags::formularzNonAjax($retval);
		$this->r->popUpWin("create accout", $retval);
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