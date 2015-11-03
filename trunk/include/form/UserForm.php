<?php
/**
 * Created on 26 paź 2014 17:56:21
 * error prefix
 * @author Tomasz Gajewski
 * @package frontoffice
  */
class UserForm extends Field
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var User
	 */
	private $user = null;
	// -------------------------------------------------------------------------
	function __construct(User $u)
	{
		$this->user = $u;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = getFormRow("Username", $this->user->getUserName());
		$retval .= getFormRow("Fullname", textField("name", $this->user->getName(), true));
		$retval .= getFormRow("Email", textField("email",$this->user->getEmail()));
		$retval .= getFormRow("Avatar url", textField("avatar_url",$this->user->getAvatarUrl()));

		return $retval;
	}
	// -------------------------------------------------------------------------
}