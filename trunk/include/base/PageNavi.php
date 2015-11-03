<?php
/**
 * Created on 2 lis 2013 11:49:32
 *
 * @author Tomasz Gajewski
 * @package backoffice
 * error prefix EM:906
 */
class PageNavi
{
	// -------------------------------------------------------------------------
	protected $ajax = true;
	protected $href;
	protected $iloscRecordow;
	protected $itemsPerPage;
	protected $iloscStron;
	protected $strona;
	protected $previewText = "Poprzednia";
	protected $nextText = "Nastepna";
	protected $rozdzielacz = " | ";
	protected $boxClass = "PageNavi";
	protected $pageString = "%_PAGE_NO_STRING_%";

	// -------------------------------------------------------------------------
	public function setAjax($ajax)
	{
		$this->ajax = $ajax;
	}
	// -------------------------------------------------------------------------
	public function setHref($href)
	{
		$this->href = $href;
	}
	// -------------------------------------------------------------------------
	public function setIloscRecordow($iloscRecordow)
	{
		$this->iloscRecordow = $iloscRecordow;
	}
	// -------------------------------------------------------------------------
	public function setItemsPerPage($itemsPerPage)
	{
		$this->itemsPerPage = $itemsPerPage;
	}
	// -------------------------------------------------------------------------
	public function setIloscStron($iloscStron)
	{
		$this->iloscStron = $iloscStron;
	}
	// -------------------------------------------------------------------------
	public function setStrona($strona)
	{
		$this->strona = $strona;
	}
	// -------------------------------------------------------------------------
	public function setPreviewText($previewText)
	{
		$this->previewText = $previewText;
	}
	// -------------------------------------------------------------------------
	public function setNextText($nextText)
	{
		$this->nextText = $nextText;
	}
	// -------------------------------------------------------------------------
	public function setRozdzielacz($rozdzielacz)
	{
		$this->rozdzielacz = $rozdzielacz;
	}
	// -------------------------------------------------------------------------
	public function setBoxClass($boxClass)
	{
		$this->boxClass = $boxClass;
	}
	// -------------------------------------------------------------------------
	public function setPageString($pageString)
	{
		$this->pageString = $pageString;
	}
	// -------------------------------------------------------------------------
	public function getAjax()
	{
		return $this->ajax;
	}
	// -------------------------------------------------------------------------
	public function getHref()
	{
		return $this->href;
	}
	// -------------------------------------------------------------------------
	public function getIloscRecordow()
	{
		return $this->iloscRecordow;
	}
	// -------------------------------------------------------------------------
	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}
	// -------------------------------------------------------------------------
	public function getIloscStron()
	{
		return $this->iloscStron;
	}
	// -------------------------------------------------------------------------
	public function getStrona()
	{
		return $this->strona;
	}
	// -------------------------------------------------------------------------
	public function getPreviewText()
	{
		return $this->previewText;
	}
	// -------------------------------------------------------------------------
	public function getNextText()
	{
		return $this->nextText;
	}
	// -------------------------------------------------------------------------
	public function getRozdzielacz()
	{
		return $this->rozdzielacz;
	}
	// -------------------------------------------------------------------------
	public function getBoxClass()
	{
		return $this->boxClass;
	}
	// -------------------------------------------------------------------------
	public function getPageString()
	{
		return $this->pageString;
	}
	// -------------------------------------------------------------------------
	public function out()
	{
		$this->init();

		if($this->getIloscStron() > 1)
		{
			$retval = $this->getPreviewPage();
			if($this->getIloscStron() > 25)
			{
				$retval .= $this->getBodyFragment();
			}
			else
			{
				$retval .= $this->getBodyFull();
			}
			$retval .= $this->getNextPage();
			$retval = Tags::div($retval, "class='" . $this->getBoxClass() . "'");
			return $retval;
		}
	}
	// -------------------------------------------------------------------------
	protected function getBodyFragment()
	{
		$retval = "";
		if($this->getStrona() < 15)
		{
			$startDot = "";
			$endDot = "..." . $this->getRozdzielacz();
			$fromCount = 1;
			$endCount = 25;
		}
		elseif($this->getStrona() > ($this->getIloscStron() - 15))
		{
			$startDot = "..." . $this->getRozdzielacz();
			$endDot = "";
			$fromCount = $this->getIloscStron() - 25;
			$endCount = $this->getIloscStron();
		}
		else
		{
			$startDot = "..." . $this->getRozdzielacz();
			$endDot = "..." . $this->getRozdzielacz();
			$fromCount = $this->getStrona() - 12;
			$endCount = $this->getStrona() + 12;
		}
		$retval .= $startDot;
		for($a = $fromCount;$a <= $endCount;$a++)
		{
			if($a == $this->getStrona())
			{
				$retval .= Tags::span($a, "class='ui-state-highlight'");
			}
			else
			{
				$href = $this->getHrefTranslated($a);

				if($this->getAjax())
				{
					$retval .= Tags::ajaxLink($href, $a);
				}
				else
				{
					$retval .= Tags::a($a, "href='" . $href . "'");
				}
			}
			$retval .= $this->getRozdzielacz();
		}
		$retval .= $endDot;
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getBodyFull()
	{
		$retval = "";
		for($a = 1;$a <= $this->getIloscStron();$a++)
		{
			if($a != $this->getStrona())
			{
				$href = $this->getHrefTranslated($a);
				if($this->ajax)
				{
					$retval .= Tags::ajaxLink($href, $a);
				}
				else
				{
					$retval .= Tags::a($a, "href='" . $href . "'");
				}
			}
			else
			{
				$retval .= Tags::span($a, "class='ui-state-highlight'");
			}
			$retval .= $this->getRozdzielacz();
		}
		return $retval;
	}
	// -------------------------------------------------------------------------
	protected function getNextPage()
	{
		if($this->getStrona() != $this->getIloscStron())
		{
			$href = $this->getHrefTranslated($this->getStrona() + 1);
			if($this->getAjax())
			{
				return Tags::ajaxLink($href, $this->getNextText());
			}
			else
			{
				return Tags::a($this->getNextText(), "href='" . $href . "'");
			}
		}
		else
		{
			return Tags::span($this->getNextText());
		}
	}
	// -------------------------------------------------------------------------
	protected function getPreviewPage()
	{
		if($this->getStrona() != 1)
		{
			$href = $this->getHrefTranslated($this->getStrona() - 1);
			if($this->getAjax())
			{
				return Tags::ajaxLink($href, $this->getPreviewText()) . $this->getRozdzielacz();
			}
			else
			{
				return Tags::a($this->getPreviewText(), "href='" . $href . "'") . $this->getRozdzielacz();
			}
		}
		else
		{
			return Tags::span($this->getPreviewText()) . $this->getRozdzielacz();
		}
	}
	// -------------------------------------------------------------------------
	protected function getHrefTranslated($strona)
	{
		return $this->href . "&amp;page=" . $strona;
	}
	// -------------------------------------------------------------------------
	protected function init()
	{
		$this->setIloscStron(ceil($this->getIloscRecordow() / PAGELIMIT));
		$this->setStrona((int)PostChecker::get("page"));
		if($this->getStrona() == 0)
		{
			$this->setStrona(1);
		}
	}
	// -------------------------------------------------------------------------
}
?>