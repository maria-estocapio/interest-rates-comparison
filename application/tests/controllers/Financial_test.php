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

	/** Test for savings deposit **/
	public function test_results_val_fixed()
	{
		$output = $this->request('GET', 'api/financial?start_date=2018-01&end_date=2018-01&rate_type=fixed');
		
		$this->assertContains('"banks_fixed_deposits_3m":"0.15"', $output);		
		$this->assertContains('"banks_fixed_deposits_6m":"0.22"', $output);		
		$this->assertContains('"banks_fixed_deposits_12m":"0.34"', $output);		
		$this->assertContains('"fc_fixed_deposits_3m":"0.30"', $output);		
		$this->assertContains('"fc_fixed_deposits_6m":"0.38"', $output);		
		$this->assertContains('"fc_fixed_deposits_12m":"0.50"', $output);		
	}

	/** Test for fixed deposit **/
	public function test_results_val_savings()
	{
		
		$output = $this->request('GET', 'api/financial?start_date=2018-01&end_date=2018-01&rate_type=savings');
		
		$this->assertContains('"banks_savings_deposits":"0.16"', $output);			
		$this->assertContains('"fc_savings_deposits":"0.17"', $output);			
	}

	/** Test for average **/
	public function test_averate()
	{
		$ave = $this->financial->get_average(10, 5);

		$this->assertEquals(2, $ave);		
	}


}
