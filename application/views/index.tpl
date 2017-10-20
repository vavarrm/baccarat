<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<title>百家樂</title>
	<link rel="icon" href="/images/icon350x350.jpeg">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/index.css">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="crossorigin="anonymous"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body bgcolor="#E6E6FA" >
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" >
				<button class="btn btn-default"  id ="btn-run">开始</button>
				<button class="btn btn-default"  id ="btn-burn-card">烧牌</button>
				<{$end_cards}>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 right_div" >
				<div class="row">
					<div class="col-md-1">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	var total_cards = 0;
	var end_cards = <{$end_cards}>;
	var game_open = false;
	$('#btn-burn-card').bind('click', function(e){
		$.post('/MainPage/burnStartCard',{},function(r){
			console.log(r);
		}, 'json')
	})
	$('#btn-run').bind('click', function(e){
		if(game_open == false)
		{
			<!-- alert('游戏停止'); -->
			<!-- return false; -->
		}
		if(total_cards> end_cards)
		{
			alert('洗牌');
			return false;
		}
		$.post('/MainPage/run',{},function(r){
			if(r.status.code ="100")
			{
				console.log(r);
				var html="<div class='row'>";
				html+="<div class='col-md-1'>";
				html+='banker:'
				$.each(r['body']['datalist']['banker']['hand_card'],function(i,e){
					html+=e;
					html+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				})
				html+="point:"+r['body']['datalist']['banker']['point'];	
				html+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';				
				html+='player:'
				$.each(r['body']['datalist']['player']['hand_card'],function(i,e){
					html+=e;
					html+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				})
				total_cards +=r['body']['datalist']['player']['hand_card'].length;
				total_cards +=r['body']['datalist']['banker']['hand_card'].length;
				html+="point:"+r['body']['datalist']['player']['point'];
				html+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				html+="winner:"+r['body']['datalist']['winner'];
				html+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				html+='cards:'+total_cards;
				html+="</div>";
				html+="</div>";
				$('.right_div .row:first').before(html);
			}
		}, 'json')
	})
</script>
</html>