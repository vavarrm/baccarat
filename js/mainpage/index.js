$( document ).ready(function() {
	var dialog, myform , position;
	myform = $("#dialog-form form");
	var addPlayer = function()
	{
		var player_name = $('#player_name').val();
		if($('h2[player='+player_name+']').length > 0)
		{
			alert('player name is play now');
			return false
		}
		if( player_name =="")
		{
			alert('player name is empty');
			return false
		}
		$(position).removeClass('close').find('h2').text(player_name).attr('player',player_name) ;
		dialog.dialog( "close" );
	};
	
	var delPlayer = function ()
	{
		var _default =$(position).removeClass('close').find('h2').attr('default');
		$(position).addClass('close').find('h2').text(_default);
		dialog.dialog( "close" );
	}
	
	var formreset = function ()
	{
		$('#player_name').val('');
		$('#market').val('NA');
	}
	dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		// height: 450,
		width: 'auto',
		modal: true,
		buttons: {
			"Create an player": addPlayer,
			"Delete an player": delPlayer,
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			formreset();
		}
    });
	var openPosition = function(p){
		formreset();
		position = p;
		dialog.dialog( "open" );
		$( "#dialog-form").removeClass('hide');
	}
	$('.position').bind('click', function(e){
		e.preventDefault();
		openPosition(this);
	});
	var player_name;
	$("#player_name").autocomplete({
		source: function (request, response) {
			$.get("/AjaxApi/getPlayerJson/"+request.term, {
				
			}, function (r) {
				player_name =[];
				if(r.status =='100')
				{
					$.each(r.data['list'], function(i,e){
						player_name.push(e.p_name);;
					})
				}
				// assuming data is a JavaScript array such as
				// ["one@abc.de", "onf@abc.de","ong@abc.de"]
				// and not a string
				response( player_name);
			},'json');
		},
		minLength: 3
	});
});