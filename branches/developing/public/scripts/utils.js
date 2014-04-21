// -----------------------------------------------------------------------------
function focusCard(sender)
{
	$(sender).stop(true, false).delay(200).animate(
	{
		"top" : "0px"
	}, 500);
}
// -----------------------------------------------------------------------------
function inHandCard(sender)
{
	$(sender).stop(true, false).animate(
	{
		"top" : "75px"
	}, 200);
}
// -----------------------------------------------------------------------------
function selectCard(sender)
{
	var url = "?action=SetCard&arg1=" + $(sender).find("span:first").attr("data-idcard");
	ajax.get(url, true);
}
// -----------------------------------------------------------------------------
