<main role="main" class="container">
	<div class="row">		
	    <div class="col-md-12">
			<h1>Average</h1>
		</div>	
	</div>
	<div class="row">		
	    <div class="col-md-12">
		<div class="jumbotron">
	    	<div class="form-row">
			    <div class="form-group col-md-2">	
			    	<label for="start_datepicker">Date Range</label>      	      
			      	<input type="text" class="form-control" id="start_datepicker" placeholder="Start Date" value="2018-01">
			    </div>
			    <div class="form-group col-md-2">		
			    	<label for="end_datepicker">&nbsp;</label>      
			      	<input type="text" class="form-control" id="end_datepicker" placeholder="End Date" value="2019-02">
			    </div>
			   	  
				<div class="form-group col-md-2">
					<label for="end_datepicker">&nbsp;</label>  	    <br>	
					<button type="button" class="btn btn-primary" id="submit">Submit</button>
				</div>
		  </div>	
	  </div>
	  </div>
			 
		<script type="text/javascript">
		     $(function() {
			      $('#start_datepicker').datepicker({
			      	format: 'yyyy-mm',
			      	autoHide: true		        
			      });

			      $('#end_datepicker').datepicker({
			      	format: 'yyyy-mm',
			      	autoHide: true	        
			      });
			    });
		</script> 
	     <div class="col-md-12">	
			<div id="canvas-holder">
				<canvas id="chart-area"></canvas>
			</div>	
		</div>	
		</div>	
	</div>
</main>
	<script>
		var myBarChart;
		function load_chart()
		{
			var sdate = $('#start_datepicker').val();
			var edate = $('#end_datepicker').val();

			$.ajax({
				url: '<?php echo base_url();?>api/financial/average?start_date='+sdate+'&end_date='+edate+'&d='+ new Date().getTime(),
			    cache: false,
			    success: function(api_response) {
			    	var source1 = [];
					var source2 = [];

					source1.push(api_response.result.banks_fixed_deposits_3m_average);
					source1.push(api_response.result.banks_fixed_deposits_6m_average);
					source1.push(api_response.result.banks_fixed_deposits_12m_average);
					source1.push(api_response.result.banks_savings_deposits);
					
					source2.push(api_response.result.fc_fixed_deposits_3m_average);
					source2.push(api_response.result.fc_fixed_deposits_6m_average);
					source2.push(api_response.result.fc_fixed_deposits_12m_average);
					source2.push(api_response.result.fc_savings_deposits);
					
					
					
					var data = {
						  labels: ["Fixed 3m", "Fixed 6m", "Fixed 12m", "Savings"],
						  datasets: [{
							label: "Bank",
							backgroundColor: "rgba(6, 167, 125, 1)",
							data: source1
						  }, {
							label: "Financial Company",
							backgroundColor: "rgba(246, 71, 64, 1)",
							data: source2
						  }
						  ]
						};
					var ctx = document.getElementById("chart-area").getContext("2d");
					
					myBarChart = new Chart(ctx, {
						  type: 'bar',
						  data: data,
						  options: {
							barValueSpacing: 20,
							scales: {
							  yAxes: [{
								ticks: {
								  min: 0,
								}
							  }]
							}
						  }
									
						
					});  		     
				}   		     
			});	
		}

		$(document).ready(function(){								
			load_chart();

			$('#submit').on('click',function(){
				myBarChart.destroy();
				load_chart();
			});	       		     
		});

	</script>
</body>

</html>