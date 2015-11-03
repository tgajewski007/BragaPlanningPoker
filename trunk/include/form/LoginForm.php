<?php
/**
 * Created on 22 lut 2014 15:40:57
 * error prefix
 * @author Tomasz Gajewski
 * @package frontoffice
 */
class LoginForm extends Field
{
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = Tags::div(Tags::ajaxLink("?action=GetRegisterForm", "create accout"), "class='zLewej Cinzel'");
		$retval .= Tags::span("Email:") . Tags::span(textField("u"));
		$retval .= Tags::span("Password:") . Tags::span(passwordField("p"));
		$retval .= submitButton("login");
		$retval = Tags::formularzNonAjax($retval);

		$retval = Tags::div($retval, "id='LoginBox'");
		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>