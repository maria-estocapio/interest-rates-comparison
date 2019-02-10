<?php

require APPPATH . '/controllers/api/Financial.php';

class Financial_test extends TestCase
{
	

	function __construct()
	{		
		$this->resetInstance();
		
		$this->financial = new Financial();
	}

	public function test_call_api()
	{
		$params['resource_id'] = $this->financial->api_config->resource_id;        

		$output = $this->financial->call_api($params);	

		$this->assertEquals(200, $output['status_code']);
	}

	/** Test for total number of results base on start_date & end_date **/
	public function test_results_total()
	{
		$output = $this->request('GET', 'api/financial?start_date=2018-01&end_date=2018-12');
		
		$json = json_decode($output);

		$this->assertContains('"status":"success"', $output);

		$this->assertEquals(12, count($json->result));		
	}
	
	public function test_date_check()
	{
		$s_date = '';
		$e_date = '';
		
		$output = $this->request('GET', 'api/financial?start_date='.$s_date.'&end_date='.$e_date.'&rate_type=fixed');

		$this->assertContains('"result":[]', $output);
		echo "test_date_check: no result due to no specified date";
		
	}

	/** Test for savings deposit **/
	public function test_results_val_fixed()
	{
		$output = $this->request('GET', 'api/financial?start_date=2018-06&end_date=2018-07&rate_type=fixed');
		
		$this->assertContains('"end_of_month":"2018 Jun"', $output);
		$this->assertContains('"banks_fixed_deposits_3m":"0.15"', $output);		
		$this->assertContains('"banks_fixed_deposits_6m":"0.22"', $output);		
		$this->assertContains('"banks_fixed_deposits_12m":"0.37"', $output);		
		$this->assertContains('"fc_fixed_deposits_3m":"0.30"', $output);		
		$this->assertContains('"fc_fixed_deposits_6m":"0.38"', $output);		
		$this->assertContains('"fc_fixed_deposits_12m":"0.50"', $output);	

		$this->assertContains('"end_of_month":"2018 Jul"', $output);
		$this->assertContains('"banks_fixed_deposits_3m":"0.16"', $output);		
		$this->assertContains('"banks_fixed_deposits_6m":"0.23"', $output);		
		$this->assertContains('"banks_fixed_deposits_12m":"0.38"', $output);		
		$this->assertContains('"fc_fixed_deposits_3m":"0.30"', $output);		
		$this->assertContains('"fc_fixed_deposits_6m":"0.38"', $output);		
		$this->assertContains('"fc_fixed_deposits_12m":"0.50"', $output);
		
		echo "test_results_val_fixed: passed";
	}

	/** Test for fixed deposit **/
	public function test_results_val_savings()
	{
		
		$output = $this->request('GET', 'api/financial?start_date=2018-01&end_date=2018-01&rate_type=savings');
		
		$this->assertContains('"banks_savings_deposits":"0.16"', $output);			
		$this->assertContains('"fc_savings_deposits":"0.17"', $output);			
		echo "test_results_val_savings: passed";
	}
	//Test for period input 
	public function test_results_period()
	{
		
		$output = $this->request('GET', 'api/financial?start_date=2018-01&end_date=2018-01&period = 3&rate_type=savings');
		
		$this->assertContains('"end_of_month":"2018 Jan"', $output);
		$this->assertContains('"banks_savings_deposits":"0.16"', $output);			
		$this->assertContains('"fc_savings_deposits":"0.17"', $output);		
		echo "test_results_period: passed";
	}

	/** Test for average **/
	public function test_average()
	{	
		$output = $this->request('GET', 'api/financial/average?start_date=2015-01&end_date=2019-01&rate_type=savings');
		$this->assertContains('"banks_fixed_deposits_3m_average":0.16', $output);			
		$this->assertContains('"banks_fixed_deposits_6m_average":0.23', $output);	
		$this->assertContains('"banks_fixed_deposits_12m_average":0.35', $output);
		$this->assertContains('"banks_savings_deposits":0.15', $output);	
		$this->assertContains('"fc_fixed_deposits_3m_average":0.27', $output);			
		$this->assertContains('"fc_fixed_deposits_6m_average":0.35', $output);	
		$this->assertContains('"fc_fixed_deposits_12m_average":0.51', $output);
		$this->assertContains('"fc_savings_deposits":0.17', $output);		
		echo "test_average: passed";
	}


}
