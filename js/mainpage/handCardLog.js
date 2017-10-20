$( document ).ready(function() {
	var CardColor = [
      "spade",
      "heart",
      "club",
      "diamond",
    ];
	
	$( "#C1_color" ).autocomplete({
      source:  CardColor
    });
	
		
	$( "#C2_color" ).autocomplete({
      source:  CardColor
    });
	

	
	$('#limp').bind('focusout', function(){
		var val = $(this).val();
		$('#iso').attr('disabled','disabled')
		$('#open').attr('disabled','disabled')
		if(val==0)
		{
			$('#open').removeAttr('disabled');
		}else
		{
			$('#iso').removeAttr('disabled');
		}
	})
	
	$('.player_action').slice( 3 ).hide();
	$('select[name=player_numbers]').val(3);
	$('select[name=player_numbers]').bind('change', function(e){
		var player_numbers = $(this).val();
		$('.player_action').slice( 3 ).hide();
		switch (player_numbers)
		{
			case '3':
			break;
			case '4':
			$('.player_action[position=EP]').show();
			break;
			case '5':
			$('.player_action[position=EP]').show();
			$('.player_action[position=CO]').show();
			break;
			case '6':
			$('.player_action[position=EP]').show();
			$('.player_action[position=CO]').show();
			$('.player_action[position=HJ]').show();
			break;
			default :
			var mp_number = 11-player_numbers;
			$('.player_action[position=EP]').show();
			$('.player_action[position=CO]').show();
			$('.player_action[position=HJ]').show();
			$('.player_action[position=MP]').slice(mp_number).show();
		}
	})
	
	$('.player_send').bind('click', function(e){
		e.preventDefault();
		var position = $(this).attr('position');
		var action = $('select[name='+ position+']').val();
		var	BB =parseInt($('input[name='+position+'_value]').val());
		if(BB > 0)
		{
			var action_log =position +'  '+ action + ' '+BB;
		}else{

			var action_log =position +'  '+ action ;
			BB = 0;
		}
		var tr_str ='<tr>';
		tr_str +='<td>'+position+'</td>';
		tr_str +='<td>'+action+'</td>';
		tr_str +='<td>'+BB+' </td>';
		tr_str +='<td>'+'<button class="btn btn-primary del_action" >del</button>'+' </td>';
		tr_str +='</tr>';
		$('#myTable tr:last').after(tr_str);
	})
	
	$('#flopbtn').bind('click', function(e){
		e.preventDefault();
		var card1,card2,card3;
		card1 = $('select[name=flopcard1]').val() + $('select[name=flopcardcolor1]').val();
		card2 = $('select[name=flopcard2]').val() + $('select[name=flopcardcolor2]').val();
		card3 = $('select[name=flopcard3]').val() + $('select[name=flopcardcolor3]').val();
		var tr_str ="<tr action='flop' ><td colspan='3'>";
		tr_str+='flop: '+card1+' '+card2+' '+card3;
		tr_str +='</td>';
		tr_str +='<td>'+'<button class="btn btn-primary del_action" >del</button>'+' </td>';
		tr_str +='</tr>';
		$('#myTable tr:last').after(tr_str);
	})	
	$('#turnbtn').bind('click', function(e){
		e.preventDefault();
		var card1;
		card1 = $('select[name=turncard1]').val() + $('select[name=turncardcolor1]').val();
		var tr_str ="<tr action='trun'><td colspan='3'>turn : ";
		tr_str+=card1;
		tr_str +='</td>';
		tr_str +='<td>'+'<button class="btn btn-primary del_action" >del</button>'+' </td>';
		tr_str +='</tr>';
		$('#myTable tr:last').after(tr_str);
	})	
	$('#riverbtn').bind('click', function(e){
		e.preventDefault();
		var card1;
		card1 = $('select[name=rivercard1]').val() + $('select[name=rivercardcolor1]').val();
		var tr_str ="<tr action='river'><td colspan='3'>river : ";
		tr_str+=card1;
		tr_str +='</td>';
		tr_str +='<td>'+'<button class="btn btn-primary del_action" >del</button>'+' </td>';
		tr_str +='</tr>';
		$('#myTable tr:last').after(tr_str);
	})
	
	
	$('table').on('click', '.del_action', function(event) {
		event.preventDefault();
		$(this).parent().parent().remove();
	});
});