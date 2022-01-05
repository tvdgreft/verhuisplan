$(document).ready(UnRequire);
$(document).ready(HideDetail);
$(document).ready(ShowDetail);

function ValForm()
{
	if(buttonclicked == "cancel")
	{
		return true;			// don't validate if cancel was clicked
	}
    if(buttonclicked == "deleteaction")
	{
		return true;			// don't validate if delete action was clicked
	}
	return true;
}
// als er een btn button is geklikt geen controle op verplichte keuze
function UnRequire()
{
	$('.btn').click(function()
	{
        $('#aktiviteit').attr("required",false);
	});
}

// verberg de detaillering van de inhuisacties.

function HideDetail()
{
	$('.detailrecord[day="1"]').hide();
	$('.detailrecord[day="2"]').hide();
	$('.detailrecord[day="3"]').hide();
	$('.detailrecord[day="4"]').hide();
	$('.detailrecord[day="5"]').hide();
	$('.detailrecord[day="5"]').hide();
	$('.detailrecord[day="6"]').hide();
	$('.detailrecord[day="7"]').hide();
	$('.detailrecord[day="8"]').hide();
	$('.detailrecord[day="9"]').hide();
	$('.detailrecord[day="10"]').hide();
	$('.detailrecord[day="11"]').hide();
	$('.detailrecord[day="12"]').hide();
	$('.detailrecord[day="13"]').hide();
	$('.detailrecord[day="14"]').hide();
	$('.detailrecord[day="15"]').hide();
	$('.detailrecord[day="16"]').hide();
	$('.detailrecord[day="17"]').hide();
	$('.detailrecord[day="18"]').hide();
	$('.detailrecord[day="19"]').hide();
	$('.detailrecord[day="20"]').hide();
	$('.detailrecord[day="21"]').hide();
	$('.detailrecord[day="22"]').hide();
	$('.detailrecord[day="23"]').hide();
	$('.detailrecord[day="24"]').hide();
	$('.detailrecord[day="25"]').hide();
	$('.detailrecord[day="26"]').hide();
	$('.detailrecord[day="27"]').hide();
	$('.detailrecord[day="28"]').hide();
	$('.detailrecord[day="29"]').hide();
	$('.detailrecord[day="30"]').hide();
	$('.detailrecord[day="31"]').hide();
}

// Toon detaillering van de acties van een dag.

function ShowDetail()
{
	$('.showrecord1').on('click', function()
	{
        $('.detailrecord[day="1"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord2').on('click', function()
	{
        $('.detailrecord[day="2"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord3').on('click', function()
	{
        $('.detailrecord[day="3"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord4').on('click', function()
{
        $('.detailrecord[day="4"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord5').on('click', function()
	{
        $('.detailrecord[day="5"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord6').on('click', function()
	{
        $('.detailrecord[day="6"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord7').on('click', function()
	{
        $('.detailrecord[day="7"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord8').on('click', function()
	{
        $('.detailrecord[day="8"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord9').on('click', function()
	{
        $('.detailrecord[day="9"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord10').on('click', function()
	{
        $('.detailrecord[day="10"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord11').on('click', function()
	{
        $('.detailrecord[day="11"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord12').on('click', function()
	{
        $('.detailrecord[day="12"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord13').on('click', function()
	{
        $('.detailrecord[day="13"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord14').on('click', function()
{
        $('.detailrecord[day="14"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord15').on('click', function()
	{
        $('.detailrecord[day="15"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord16').on('click', function()
	{
        $('.detailrecord[day="16"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord17').on('click', function()
	{
        $('.detailrecord[day="17"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord18').on('click', function()
	{
        $('.detailrecord[day="18"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord19').on('click', function()
	{
        $('.detailrecord[day="19"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord20').on('click', function()
	{
        $('.detailrecord[day="20"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord21').on('click', function()
	{
        $('.detailrecord[day="21"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord22').on('click', function()
	{2
        $('.detailrecord[day="22"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord23').on('click', function()
	{
        $('.detailrecord[day="23"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord24').on('click', function()
{
        $('.detailrecord[day="24"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord25').on('click', function()
	{
        $('.detailrecord[day="25"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord26').on('click', function()
	{
        $('.detailrecord[day="26"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord27').on('click', function()
	{
        $('.detailrecord[day="27"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord28').on('click', function()
	{
        $('.detailrecord[day="28"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord29').on('click', function()
	{
        $('.detailrecord[day="29"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord30').on('click', function()
	{
        $('.detailrecord[day="30"]').toggle();
		$(this).toggleClass("calendar_folded");
	});
	$('.showrecord31').on('click', function()
	{
        $('.detailrecord[day="31"]').toggle();
		$(this).toggleClass("calendar_folded");
	});

}