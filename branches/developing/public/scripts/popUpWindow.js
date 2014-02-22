// =============================================================================
jQuery.fn.center = function()
{
	this.css("top", Math.max(0, ($(window).height() - this.outerHeight()) / 2) + "px");
	this.css("left", Math.max(0, ($(window).width() - this.outerWidth()) / 2) + "px");
	return this;
};
// =============================================================================
function PopUpWindow(idContener)
{
	var idContener = idContener;
	PopUpWindow.prototype.create = function(title)
	{
		return create(title);
	};
	PopUpWindow.prototype.close = function()
	{
		return close();
	};
	// -------------------------------------------------------------------------
	function create(title)
	{
		if (!$("#" + idContener).length)
		{
			var contentBox = "<span id='" + idContener + "' onload='$(\".WindowBox\").center();' class='WindowBoxContent' />";
			var closeButton = "<span class='ui-icon ui-icon-close zPrawej hand' onclick='closeWindow(\"" + idContener + "\")' />";
			var titleBox = "<div class='BoxTitle WindowBoxTitle' >" + title + closeButton + "</div>";
			var winSource = "<div class='WindowBox'>" + titleBox + contentBox + "</div>";
			$("body").append(winSource);
		}
		$(".WindowBox").draggable();
		setTimeout(function()
		{
			$(".WindowBox").center();
		}, 1);
		$(window).resize(function()
		{
			$(".WindowBox").center();
		});
	}
	// -------------------------------------------------------------------------
	function close()
	{
		$("#" + idContener).parent().remove();
		$("#snow_" + idContener).remove();
	}
	// -------------------------------------------------------------------------
}
// =============================================================================
function closeWindow(idContener)
{
	var w = new PopUpWindow(idContener);
	return w.close();
}
// =============================================================================
