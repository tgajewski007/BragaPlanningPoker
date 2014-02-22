// -----------------------------------------------------------------------------
function execute(fn)
{
	fn(); // execute function passed as a parameter
}
// -----------------------------------------------------------------------------
function CzyInt(Sender, minValue, maxValue)
{
	return CzyReal(Sender, minValue, maxValue, 0);
}
// -----------------------------------------------------------------------------
function OgraniczTextArea(sender, limit)
{
	if ($(sender).val().length > limit)
	{
		$(sender).val($(sender).val().substr(0, limit));
	}
	$(sender).parent().find('.charsRemaining').html('Pozostało ' + (limit - $(sender).val().length) + ' znaków');
}
// -----------------------------------------------------------------------------
function CzyReal(Sender, minValue, maxValue, precision)
{
	var napis = Sender.value;
	var errorClass = new String("widgetError");
	napis = ComaToPoint(napis);

	if (minValue == null)
	{
		minValue = 0;
	}

	if (maxValue == null)
	{
		maxValue = 99999999999999;
	}

	if (isNaN(napis))
	{

		$(Sender).addClass(errorClass.toString());
		addAlert("To pole wymaga danych liczbowych");
		return false;
	}
	else
	{
		if (napis != "")
		{
			var num = new Number(napis);
			if ((num < minValue) || (num > maxValue))
			{
				$(Sender).addClass(errorClass.toString());
				addAlert("Wpisana wartość musi być z zakresu: " + minValue + " - " + maxValue);
				return false;
			}
			else
			{
				$(Sender).removeClass(errorClass.toString());
				$(Sender).val(num.toFixed(precision));
				ClearAlerts();
				return true;
			}
		}
		else
		{
			$(Sender).removeClass(errorClass.toString());
			ClearAlerts();
			return true;
		}
	}
}
// -----------------------------------------------------------------------------
function CzyNull(sender)
{
	if ($(sender).val() == "")
	{
		$(sender).addClass("widgetError");
		addAlert("To pole nie może być puste");
		return false;
	}
	else
	{
		$(sender).removeClass("widgetError");
		ClearAlerts();
		return true;
	}
}
// -----------------------------------------------------------------------------
function ClearAlerts()
{
	$("#MsgBox").html("");
}
// -----------------------------------------------------------------------------
function addAlert(text)
{
	text = text.toString().replace(/&nbsp;/g, "&#160;");
	var tmp = new String();
	tmp = "<span class='sprite spriteAlerticon zLewej' />";
	tmp += "<span class='infoText'>" + text + "</span>";
	tmp = "<p class='clear'>" + tmp + "</p>";
	$("#MsgBox").html("<div>" + tmp + "</div>");
	$(document).scrollTop(0);
}
// -----------------------------------------------------------------------------
function ComaToPoint(text)
{
	var napis = text.replace(",", ".");
	return napis;
}
// -----------------------------------------------------------------------------
function CheckDate(sender, wymagany, minDate, maxDate)
{
	var monthShortName = new Array();
	monthShortName[0] = "01";
	monthShortName[1] = "02";
	monthShortName[2] = "03";
	monthShortName[3] = "04";
	monthShortName[4] = "05";
	monthShortName[5] = "06";
	monthShortName[6] = "07";
	monthShortName[7] = "08";
	monthShortName[8] = "09";
	monthShortName[9] = "10";
	monthShortName[10] = "11";
	monthShortName[11] = "12";

	var selected = $(sender).val();
	var styleAlert = "widgetError";
	ClearAlerts();
	$(sender).removeClass(styleAlert);

	if (selected != "")
	{
		var rok = selected.substring(0, 4);
		var miesiac = selected.substring(5, 7);
		var dzien = selected.substring(8, 10);
		// alert(rok+"-"+miesiac+"-"+dzien);
		var data = new Date(rok, miesiac - 1, dzien);
		if (data == "Invalid Date")
		{
			// addAlert("Data jest wpisana niepoprawnie. Musi być w formacie
			// RRRR-MM-DD");
			addAlert("Data jest niepoprawna");
			$(sender).val($(sender).prop("defaultValue"));
			$(sender).addClass(styleAlert);
			return;
		}
		else
		{
			var rok1 = data.getFullYear();
			var retval = rok1 + "-";
			var miesiac1 = data.getMonth();
			retval += monthShortName[miesiac1] + "-";
			var dzien1 = data.getDate();
			var dzien2 = "0" + dzien1;
			if (dzien2.length == 2)
			{
				dzien1 = "0" + dzien1;
			}
			retval += dzien1;
			if (retval != $(sender).val())
			{
				addAlert("Data została przeliczona");
				// Data jest niewłaściwie wpisana
				$(sender).val(retval);
				$(sender).addClass(styleAlert);
				return;
			}
			$(sender).val(retval);
		}
	}
	else
	{
		if (wymagany)
		{
			addAlert("Pole jest wymagane");
			$(sender).addClass(styleAlert);
		}
	}

	if (minDate != "")
	{
		if (selected < minDate)
		{
			$(sender).addClass("widgetError");
			addAlert("Minimalna data: " + minDate);
		}
	}
	if (maxDate != "")
	{
		if (selected > maxDate)
		{
			$(sender).addClass("widgetError");
			addAlert("Maksymalna data: " + minDate);
		}
	}
}
// -----------------------------------------------------------------------------
function SprawdzCombo(Sender)
{
	var styleAlert = "widgetError";
	if ($(Sender).children().filter(":selected").hasClass(styleAlert))
	{
		$(Sender).addClass(styleAlert);
	}
	else
	{
		$(Sender).removeClass(styleAlert);
	}
	return true;
}
// -----------------------------------------------------------------------------
function BeforeSubmit(FormObject)
{
	var a = FormObject.length;
	for (var i = 0; i < a; i++)
	{
		var tmp = FormObject.elements[i];
		if ($(tmp).hasClass("widgetError"))
		{
			alert('Nie wszystkie wymagane pola (wyróżnione) zostały wypełnione');
			return false;
		}
	}
	return true;
}
// -----------------------------------------------------------------------------
function getRandomString(dl)
{
	var keychars = new String("abcdefghijklmnopqrstuvwxyz");
	var randkey = new String();
	var max = keychars.length - 1;
	for (var i = 0; i < dl; i++)
	{
		los = Math.floor(Math.random() * max);
		randkey += keychars.substring(los, los + 1);
	}
	return randkey;
}
// -----------------------------------------------------------------------------
function var_dump(data, addwhitespace, safety, level)
{
	var rtrn = '';
	var dt, it, spaces = '';
	if (!level)
	{
		level = 1;
	}
	for (var i = 0; i < level; i++)
	{
		spaces += '   ';
	}// end for i<level
	if (typeof (data) != 'object')
	{
		dt = data;
		if (typeof (data) == 'string')
		{
			if (addwhitespace == 'html')
			{
				dt = dt.replace(/&/g, '&amp;');
				dt = dt.replace(/>/g, '&gt;');
				dt = dt.replace(/</g, '&lt;');
			}// end if addwhitespace == html
			dt = dt.replace(/\"/g, '\"');
			dt = '"' + dt + '"';
		}// end if typeof == string
		if (typeof (data) == 'function' && addwhitespace)
		{
			dt = new String(dt).replace(/\n/g, "\n" + spaces);
			if (addwhitespace == 'html')
			{
				dt = dt.replace(/&/g, '&amp;');
				dt = dt.replace(/>/g, '&gt;');
				dt = dt.replace(/</g, '&lt;');
			}// end if addwhitespace == html
		}// end if typeof == function
		if (typeof (data) == 'undefined')
		{
			dt = 'undefined';
		}// end if typeof == undefined
		if (addwhitespace == 'html')
		{
			if (typeof (dt) != 'string')
			{
				dt = new String(dt);
			}// end typeof != string
			dt = dt.replace(/ /g, "&nbsp;").replace(/\n/g, "<br>");
		}// end if addwhitespace == html
		return dt;
	}// end if typeof != object && != array
	for ( var x in data)
	{
		if (safety && (level > safety))
		{
			dt = '*RECURSION*';
		}
		else
		{
			try
			{
				dt = var_dump(data[x], addwhitespace, safety, level + 1);
			}
			catch (e)
			{
				continue;
			}
		}// end if-else level > safety
		it = var_dump(x, addwhitespace, safety, level + 1);
		rtrn += it + ':' + dt + ',';
		if (addwhitespace)
		{
			rtrn += '\n' + spaces;
		}// end if addwhitespace
	}// end for...in
	if (addwhitespace)
	{
		rtrn = '{\n' + spaces + rtrn.substr(0, rtrn.length - (2 + (level * 3))) + '\n' + spaces.substr(0, spaces.length - 3) + '}';
	}
	else
	{
		rtrn = '{' + rtrn.substr(0, rtrn.length - 1) + '}';
	}// end if-else addwhitespace
	if (addwhitespace == 'html')
	{
		rtrn = rtrn.replace(/ /g, "&nbsp;").replace(/\n/g, "<br>");
	}// end if addwhitespace == html
	return rtrn;
}
// -----------------------------------------------------------------------------
function setValueAfterAutoCompleate(event, ui, idField, nameField)
{
	if (ui.item)
	{
		$("#" + idField).val(ui.item.id);
		$("#" + idField).attr("alt", ui.item.label);
		$("#" + nameField).removeClass("widgetError");
	}
}
// -----------------------------------------------------------------------------
function checkAutoCompleateSelected(idField, nameField)
{
	try
	{
		var t = $("#" + idField).attr("alt");
		if (t.length > 0)
		{
			if (t != $("#" + nameField).val())
			{
				$("#" + nameField).addClass("widgetError");
				$("#" + idField).attr("alt", "");
				$("#" + idField).val(null);
			}
		}
	}
	catch (e)
	{
	}
}
// -----------------------------------------------------------------------------
function cloneField(sender)
{
	var clone = true;
	$(sender).parent().children().each(function()
	{
		if ($(this).val() == "")
		{
			clone = false;
		}
	});
	if (clone)
	{
		var tmp = $(sender).val();
		$(sender).val("");
		$(sender).clone().appendTo($(sender).parent());
		$(sender).val(tmp);
	}
}
// -----------------------------------------------------------------------------
function addToBookmark()
{
	var title = "EnMarket";
	var url = "http://www.enmarket.pl";
	if (document.all)
	{ // ie
		window.external.AddFavorite(url, title);
	}
	else if (window.sidebar)
	{ // firefox
		window.sidebar.addPanel(title, url, "");
	}
	else if (window.opera && window.print)
	{ // opera
		var elem = document.createElement('a');
		elem.setAttribute('href', url);
		elem.setAttribute('title', title);
		elem.setAttribute('rel', 'sidebar');
		elem.click(); // this.title=document.title;
	}
}
// -----------------------------------------------------------------------------
function showToolTip(Msg, Zdarzenie, Obj)
{
	$(Obj).attr("title", Msg);
	$(document).tooltip(
	{
		track : true,
		show :
		{
			effect : "fade",
			duration : 100
		},
		hide :
		{
			effect : "fade",
			duration : 100
		}
	});
}
// -----------------------------------------------------------------------------
function CheckEmail(sender, req)
{
	var val = new String($(sender).val());
	if (val.length > 0 || req == true)
	{
		$(sender).addClass("widgetError");
		var regexEmail = new RegExp("[a-zA-Z0-9_.\-]+@[a-zA-Z0-9_.\-]+[.]{1}[a-zA-Z0-9_.\-]{2,}", "g");
		if (regexEmail.test(val))
		{
			$(sender).removeClass("widgetError");
		}
	}
	else if (req)
	{
		$(sender).addClass("widgetError");
	}
	else
	{
		$(sender).removeClass("widgetError");
	}
}
// -----------------------------------------------------------------------------
