<?php
/**
 * Created on 16-10-2011 13:13:32
 *
 * @author Tomasz Gajewski
 * @package enmarket
 * error prefix
 */
class Perms
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var User
	 */
	private $user = null;
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var Perms
	 */
	private static $instance = null;
	// -------------------------------------------------------------------------
	private function __construct()
	{
	}
	// -------------------------------------------------------------------------
	private function __clone()
	{
	}
	// -------------------------------------------------------------------------
	public function getCurrentUser()
	{
		return $this->user;
	}
	// -------------------------------------------------------------------------
	protected function setCurrentUser(User $u)
	{
		$this->user = $u;
	}
	// -------------------------------------------------------------------------
	/**
	 * @return Perms
	 */
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	// -------------------------------------------------------------------------
	/**
	 * Metoda sprawdza uprawnienia dostępu do żądanego zasobu
	 */
	public function check()
	{
		if(empty($_SESSION[SessionName::IDUZYTKOWNIK]))
		{
			$u = $this->login();
			if(is_null($u))
			{
				$this->goPublicSite();
			}
			else
			{
				$_SESSION[SessionName::IDUZYTKOWNIK] = $u->getIdUser();
				$this->setCurrentUser($u);
			}
		}
		else
		{
			try
			{
				$this->setCurrentUser(User::get($_SESSION[SessionName::IDUZYTKOWNIK]));
			}
			catch (Exception $e)
			{
				$this->goPublicSite();
			}
		}
	}
	// -------------------------------------------------------------------------
	protected function goPublicSite()
	{
		$d = new PublicControler();
		$d->doAction();
		exit();
	}
	// -------------------------------------------------------------------------
	protected function login()
	{
		if(!is_null(PostChecker::get("u")) && !is_null(PostChecker::get("p")))
		{
			return User::login(PostChecker::get("u"), PostChecker::get("p"));
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
		setcookie(CookieName::IDUZYTKOWNIK, null, 0, "/");
		header("Location: /");
		die();
	}
	// -------------------------------------------------------------------------
	static function openPage()
	{
		session_start();
		self::getInstance()->check();
	}
	// -------------------------------------------------------------------------
}
?>