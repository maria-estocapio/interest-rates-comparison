

<main role="main" class="container">
	<div class="row">		
	    <div class="col-md-12">
			<h1>Trend</h1>
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
			    	<label for="end_datepicker">Rate Type</label>  	    	
				    <select class="custom-select" id="rate_type">
					  <option selected>Both</option>
					  <option value="fixed">Fixed Deposit</option>
					  <option value="savings">Savings Deposit</option>					  
					</select>
				</div>
			    <div class="form-group col-md-2">	
			    	<label for="end_datepicker">Period</label>  	      
			     	<select class="custom-select" id="period">
					  <option selected>All</option>
					  <option value="3">3 months</option>
					  <option value="6">6 months</option>					  
					  <option value="12">12 months</option>					  
					</select>
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
</main>
	<script>
		function load_chart()
		{
			var sdate = $('#start_datepicker').val();
			var edate = $('#end_datepicker').val();
			var rate_type = $('#rate_type').val();
			var period = $('#period').val();			
			
			$.ajax({
				url: '<?php echo base_url();?>api/financial?rate_type='+rate_type+'&start_date='+sdate+'&end_date='+edate+'&period='+period+'&d='+ new Date().getTime(),
			    cache: false,
			    success: function(api_response) {
			       		console.log(api_response);
						var labels = [];
						var source1 = [];
						var source2 = [];
						var source3 = [];
						var source4 = [];
						var source5 = [];
						var source6 = [];
						var source7 = [];
						var source8 = [];

						if(api_response.status_code=='200' && api_response.result.length > 0)
						{
							for (i = 0; i < api_response.result.length; ++i) {
							
								labels.push(api_response.result[i].end_of_month);
								source1.push(api_response.result[i].banks_fixed_deposits_3m);
								source2.push(api_response.result[i].banks_fixed_deposits_6m);
								source3.push(api_response.result[i].banks_fixed_deposits_12m);
								source4.push(api_response.result[i].fc_fixed_deposits_3m);
								source5.push(api_response.result[i].fc_fixed_deposits_6m);
								source6.push(api_response.result[i].fc_fixed_deposits_12m);
								source7.push(api_response.result[i].banks_savings_deposits);
								source8.push(api_response.result[i].fc_savings_deposits);
							    
							}

						}
					
					   var ctx = document.getElementById("chart-area").getContext("2d");
					   var myChart = new Chart(ctx, {
					      type: 'line',
					      data: {
					         labels: labels,
					         datasets: [{
					            label: "Bank Fixed 3m",
					            data: source1,
					            borderWidth: 2,
					            backgroundColor: "rgba(6, 167, 125, 0.1)",
					            borderColor: "rgba(6, 167, 125, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(6, 167, 125, 1)",
					            pointHoverBackgroundColor: "rgba(6, 167, 125, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "Bank Fixed 6m",
					            data: source2,
					            borderWidth: 2,
					            backgroundColor: "rgba(246, 71, 64, 0.1)",
					            borderColor: "rgba(246, 71, 64, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(246, 71, 64, 1)",
					            pointHoverBackgroundColor: "rgba(246, 71, 64, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "Bank Fixed 12m",
					            data: source3,
					            borderWidth: 2,
					            backgroundColor: "rgba(26, 143, 227, 0.1)",
					            borderColor: "rgba(26, 143, 227, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(26, 143, 227, 1)",
					            pointHoverBackgroundColor: "rgba(26, 143, 227, 1)",
					            pointHoverBorderColor: "#fff"
					         },
					         {
					            label: "FC Fixed 3m",
					            data: source4,
					            borderWidth: 2,
					            backgroundColor: "rgba(255, 255, 0, 0.1)",
					            borderColor: "rgba(255, 255, 0, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(255, 255, 0, 1)",
					            pointHoverBackgroundColor: "rgba(255, 255, 0, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "FC Fixed 6m",
					            data: source5,
					            borderWidth: 2,
					            backgroundColor: "rgba(191, 0, 255, 0.1)",
					            borderColor: "rgba(191, 0, 255, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(191, 0, 255, 1)",
					            pointHoverBackgroundColor: "rgba(191, 0, 255, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "FC Fixed 12m",
					            data: source6,
					            borderWidth: 2,
					            backgroundColor: "rgba(255, 128, 0, 0.1)",
					            borderColor: "rgba(255, 128, 0, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(255, 128, 0, 1)",
					            pointHoverBackgroundColor: "rgba(255, 128, 0, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "Bank Savings Deposit",
					            data: source7,
					            borderWidth: 2,
					            backgroundColor: "rgba(0, 255, 255, 0.1)",
					            borderColor: "rgba(0, 255, 255, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(0, 255, 255, 1)",
					            pointHoverBackgroundColor: "rgba(0, 255, 255, 1)",
					            pointHoverBorderColor: "#fff"
					         }, {
					            label: "FC Savings Deposit",
					            data: source8,
					            borderWidth: 2,
					            backgroundColor: "rgba(128, 128, 128, 0.1)",
					            borderColor: "rgba(128, 128, 128, 1)",
					            pointBackgroundColor: "rgba(225, 225, 225, 1)",
					            pointBorderColor: "rgba(128, 128, 128, 1)",
					            pointHoverBackgroundColor: "rgba(128, 128, 128, 1)",
					            pointHoverBorderColor: "#fff"
					         }]
					      }
					   });
			    }			   
			});


			
		}
		$(document).ready(function(){	

			$('#submit').on('click',function(){
				load_chart();
			});

			$('#rate_type').on('change',function(){
				$('#period').removeAttr('disabled');

				if($(this).val()=='savings')
				{
					$('#period').attr('disabled','disabled');
				}
			});

			load_chart();	       		     
		});

	</script>

