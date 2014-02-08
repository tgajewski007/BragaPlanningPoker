<?php
/**
 * Created on 16-10-2011 13:13:32
 *
 * @author Tomasz Gajewski
 * @package enmarket
 * error prefix
 */
class Perms extends BaseAction
{
	// -------------------------------------------------------------------------
	public $uzytkownik;
	public $modul;
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var Perm
	 */
	static $instance =null;
	// -------------------------------------------------------------------------
	function __construct()
	{
		if(isset($_SESSION["logedUserId"]))
		{
			try
			{
				$this->uzytkownik = Uzytkownik::get($_SESSION["logedUserId"]);
				return;
			}
			catch(Exception $e)
			{
				$this->uzytkownik = null;
				self::logout();
			}
		}
		elseif(isset($_COOKIE[CookieName::UZYTKOWNIKID]))
		{
			try
			{
				$this->uzytkownik = Uzytkownik::get($_COOKIE[CookieName::UZYTKOWNIKID]);
				$this->uzytkownik->updateLastSuccessLogin();
				self::setLoggedIn($this->uzytkownik);
				return;
			}
			catch(Exception $e)
			{
				$this->uzytkownik = null;
				self::logout();
			}
		}

		$tmp = $this->login();
		if(!is_null($tmp))
		{
			session_regenerate_id();
			$_SESSION["logedUserId"] = $tmp->getIdUzytkownik();
			$this->uzytkownik = $tmp;
			if(Promocja::isSaNieuruchomione($this->uzytkownik))
			{
				addMsg("Są nie nieuruchomione promocję. Sprawdź zakładkę Moje aktywności");
			}
			if(count($this->uzytkownik->getSklepsForUzytkownik()) > 0)
			{
				header("Location: /" . WebAction::PANEL . "/");
				exit();
			}
		}
	}
	// -------------------------------------------------------------------------
	public function doAction()
	{
		return false;
	}
	// -------------------------------------------------------------------------
	static function setLoggedIn(Uzytkownik $u)
	{
		global $perm;
		$perm->uzytkownik = $u;
		$_SESSION["logedUserId"] = $u->getIdUzytkownik();
	}
	// -------------------------------------------------------------------------
	protected function login()
	{
		if(isset($_POST["u"]))
		{
			$c = new PostChecker(new GLog());
			$c->checkPost($this);
			if(isset($this->post["u"]) and $this->post["p"])
			{
				return Uzytkownik::login($this->post["u"], $this->post["p"]);
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	// -------------------------------------------------------------------------
	static function logout()
	{
		session_destroy();
		setcookie(CookieName::UZYTKOWNIKID, null, 0, "/");
		header("Location: /");
		die();
	}
	// -------------------------------------------------------------------------
}
// =============================================================================
function startSession()
{
	session_start();
	global $perm;
	$perm = new Perms();
}
// =============================================================================
function checkAccess()
{
	if(Uzytkownik::getCurrent()->getIdUzytkownik() == Uzytkownik::NOBODY)
	{
		$l = new DefaultLayout();
		$f = new LoginForm();
		$l->out($f->out());
		die();
	}
}
// =============================================================================
?>