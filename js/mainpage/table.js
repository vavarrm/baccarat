$( document ).ready(function() {
	$('.btn-addtable').bind('click', function(e){
		var active =  $(this).hasClass('active') ;
		var p_id = $(this).attr('p_id');
		var table_id = $('#table-select').val();
		var isintable  = $('.table-seat').eq(table_id-1).find('.btn-removetable[p_id='+p_id+']').length;
		console.log(isintable);
		if(isintable == 0)
		{
			$(this).addClass('active');

			addTable( p_id, table_id);
		}else if(active){
			console.log('d');
		}
		else{
			alert('in table alreday');
		}
	});
	
	function showtable(tableid)
	{
		$('.poker-table').addClass('hidden');
		$('.poker-table').eq(tableid-1).removeClass('hidden');
	}
	
	showtable($('#table-select').val());
	$('#table-select').bind('change', function(e){
		
		
		var tableid = $(this).val();
		showtable(tableid)
		
	
	})
	
	$( "body" ).on( "click", ".btn-removetable", function() {
		if(confirm('remove player'))
		{	
			var p_id = $(this).attr('p_id');
			$('.btn-addtable[p_id='+p_id+']').removeClass('active');
			$(this).remove();
		}
	});
	
	
	
	
	function addTable(p_id, table_id){
		$('.poker-table').eq(table_id-1).find('.table-seat');
		var playername = $('.btn-addtable[p_id='+p_id+']').text();
		var content= '<button type="button" p_id="'+p_id+'" class="btn btn-success btn-removetable">'+playername+'</button><p>';
		var target= $('.table-seat').eq(table_id-1);
		// $().insert($('.table-seat').eq(table_id-1));
		target.append(content);
	}
});