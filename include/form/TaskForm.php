<?php
/**
 * Created on 21 kwi 2014 21:45:19
 * author Tomasz Gajewski
 * package frontoffice
 * error prefix
 */
class TaskForm extends Field
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var Task
	 */
	protected $task = null;
	// -------------------------------------------------------------------------
	function __construct(Task $t)
	{
		$this->task = $t;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = getFormRow("Subject", textField("subject", $this->task->getSubject(), true));
		$retval .= getFormRow("URL", textField("url", $this->task->getUrl()));
		$retval .= getFormRow("Esimate", $this->task->getCard()->getName());

		return $retval;
	}
	// -------------------------------------------------------------------------
}
?>