<?php
/**
 * Created on 3 lis 2015 19:32:14
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class TaskLogForm extends Field
{
	// -------------------------------------------------------------------------
	/**
	 *
	 * @var Table
	 */
	protected $table = null;
	// -------------------------------------------------------------------------
	function __construct(Table $t)
	{
		$this->table = $t;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$retval = "";
		
		$page = PostChecker::get("page");
		if(is_null($page))
		{
			$page = 1;
		}
		$collectionTask = $this->table->getTasksForLog($page);
		
		$p = new PageNavi();
		$p->setIloscRecordow($collectionTask->count());
		$p->setItemsPerPage(PAGELIMIT);
		$p->setStrona($page);
		$p->setHref("?action=GetTaskLog");
		$p->setPreviewText("preview");
		$p->setNextText("next");
		
		$d = new DBGrid();
		$db = new CollectionDB($collectionTask);
		$i = 0;
		$db->addTranslate("getSubject", $i++, "Task");
		$db->addTranslate("getCard.getName", $i++, "Card");
		$d->setDataSource($db);
		$d->setLpCounter(($page - 1) * PAGELIMIT + 1);
		
		return $p->out() . $d->out(true) . $p->out();
	}
	// -------------------------------------------------------------------------
}
?>