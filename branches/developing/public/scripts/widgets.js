/**
 * 
 */
function confirmUI(question, callback)
{
	var dialog = new String();
	dialog = '<div id="dialog-confirm" title="Pytanie"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + question
	        + '</p></div>';
	$("body:first").append(dialog);
	$("#dialog-confirm").dialog({
	    resizable : false,
	    height : 170,
	    modal : true,
	    closeOnEscape : true,
	    close : function()
	    {
		    $(this).dialog("destroy");
		    $("#dialog-confirm").remove();
	    },
	    buttons : {
	        "Tak" : function()
	        {
		        execute(callback);
		        $(this).dialog("close");
	        },
	        "Nie" : function()
	        {
		        $(this).dialog("close");
	        }
	    }
	});

}