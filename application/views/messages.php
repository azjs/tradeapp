<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CurrencyFair</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
    
    <?php if(count($arrStats)) { ?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {
		var data = google.visualization.arrayToDataTable([
		  ['Country', 'Requests', { role: "style" }, { role: 'annotation' }],
		  <?php for($ind = 0; $ind < count($arrStats); $ind++) { ?>
		  ['<?php echo $arrStats[$ind]['countries_name']; ?>',  <?php echo (int)$arrStats[$ind]['countries_msg_count']; ?>, '#6B801F',  <?php echo (int)$arrStats[$ind]['countries_msg_count']; ?>],
		  <?php } ?>
		]);
	
		var options = {
		  title: 'Countries Stats Summary',
		  legend: { position: 'left' },
		  vAxis: {title: 'No. of Requests',  titleTextStyle: {color: 'red'}},
		  hAxis: {title: 'Country',  direction: '1',  titleTextStyle: {color: 'red'}}
		};
	
		var chart = new google.visualization.ColumnChart(document.getElementById('divChartSource'));
		chart.draw(data, options);
	  }
	</script>
	<?php } ?>

</head>
<body>
<div id="container">
	<h1>10 Recent Requests</h1>
	<table width="100%">
    	<tr>
        	<th>userId</th>
        	<th>currencyFrom</th>
        	<th>currencyTo</th>
        	<th>amountSell</th>
        	<th>amountBuy</th>
        	<th>rate</th>
        	<th>timePlaced</th>
        	<th>originatingCountry</th>
        </tr>
        <?php for($ind = 0; $ind < count($arrMessages); $ind++) { ?>
    	<tr>
        	<th><?php echo $arrMessages[$ind]['user_id']; ?></th>
        	<th><?php echo $arrMessages[$ind]['currency_from']; ?></th>
        	<th><?php echo $arrMessages[$ind]['currency_to']; ?></th>
        	<th><?php echo $arrMessages[$ind]['amount_sell']; ?></th>
        	<th><?php echo $arrMessages[$ind]['amount_buy']; ?></th>
        	<th><?php echo $arrMessages[$ind]['rate']; ?></th>
        	<th><?php echo $arrMessages[$ind]['time_placed']; ?></th>
        	<th><?php echo $arrMessages[$ind]['country']; ?></th>
        </tr>
        <?php } ?>
    </table>
</div>
<div style="clear:both">&nbsp;</div>
<div id="divChartSource" style="width: 100%; height: 700px; float:left"></div>
</body>
</html>