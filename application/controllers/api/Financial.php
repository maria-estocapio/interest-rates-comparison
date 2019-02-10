<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Financial extends REST_Controller {   

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->helper('security');
        $this->api_config = new stdClass();

        #Setup API config. 
        $this->api_config->end_point = 'https://eservices.mas.gov.sg/api/action/datastore/search.json';
        $this->api_config->resource_id = '5f2b18a8-0883-4769-a635-879c63d3caac';
        
        date_default_timezone_set('Asia/Singapore');
    }

    public function call_api($params=[])
    {
        # Construct API endpoint with params
        $endpoint = $this->api_config->end_point.'?'.http_build_query($params);        
        $mas_response = Requests::get($endpoint);

        $records = [];

        if($mas_response->status_code=='200')
        {
            $result = json_decode($mas_response->body);
            $records = $result->result->records;   
            //print_r($records);
            $response = ['status'=>'success','status_code'=>$mas_response->status_code,'result'=>$records,'msg'=>'Success']; 
        }else{
            $response = ['status'=>'failed','status_code'=>$mas_response->status_code,'result'=>[],'msg'=>'Error Occured.'];
        }

        return $response;
        
    }

    public function index_get()
    {
        $start_date = xss_clean($this->input->get('start_date'));
        $end_date = xss_clean($this->input->get('end_date'));
        $period = xss_clean($this->input->get('period'));
        $rate_type = $this->input->get('rate_type');

        $params['resource_id'] = $this->api_config->resource_id;

        if($start_date && $end_date)
        {
            $params['between[end_of_month]'] = $start_date.','.$end_date;
        }
       
        $api_response = $this->call_api($params);        

        //print_r($response);
        $response = ['status'=>$api_response['status'],'status_code'=>$api_response['status_code'],'msg'=>$api_response['msg']]; 

        if(!empty($api_response['result']))
        {
            foreach($api_response['result'] as $record)
            {

                $end_month = date('Y M',strtotime($record->end_of_month));
                $banks_savings_deposits = $record->banks_savings_deposits;
                $fc_savings_deposits = $record->fc_savings_deposits;
                $banks_fixed_deposits_3m = $record->banks_fixed_deposits_3m;
                $banks_fixed_deposits_6m = $record->banks_fixed_deposits_6m;
                $banks_fixed_deposits_12m = $record->banks_fixed_deposits_12m;
                $fc_fixed_deposits_3m = $record->fc_fixed_deposits_3m;
                $fc_fixed_deposits_6m = $record->fc_fixed_deposits_6m;
                $fc_fixed_deposits_12m = $record->fc_fixed_deposits_12m;

                switch ($rate_type) {                               
                    case 'savings':
                            $response['result'][] = [
                                    'end_of_month'=>$end_month,
                                    'banks_savings_deposits'=>$banks_savings_deposits,
                                    'fc_savings_deposits'=>$fc_savings_deposits,                                
                                ];
                        break;

                    case 'fixed':
                    
                            $response['result'][] = $this->periods($period, $record);
                                                          
                        break;
                    default:
                            $response['result'][] = $this->periods($period, $record);                           
                        break;
                    }                                
            }
        }
        
        # output the json object        

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($api_response['status_code'])
            ->set_output(json_encode($response));
    }

    public function average_get()
    {

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $params['resource_id'] = $this->api_config->resource_id;

        if($start_date && $end_date)
        {
            $params['between[end_of_month]'] = $start_date.','.$end_date;
        }
       
        $api_response = $this->call_api($params);        
        
        $response = ['status'=>$api_response['status'],'status_code'=>$api_response['status_code'],'msg'=>$api_response['msg']]; 
             

        if(!empty($api_response['result']))
        {
            
            $banks_fixed_deposits_3m = 0;
            $banks_fixed_deposits_6m = 0;
            $banks_fixed_deposits_12m = 0;
            $fc_fixed_deposits_3m = 0;
            $fc_fixed_deposits_6m = 0;
            $fc_fixed_deposits_12m = 0;
            $banks_savings_deposits = 0;
            $fc_savings_deposits = 0;


            foreach($api_response['result'] as $record)
            {                
                $banks_fixed_deposits_3m += $record->banks_fixed_deposits_3m;
                $banks_fixed_deposits_6m += $record->banks_fixed_deposits_6m;
                $banks_fixed_deposits_12m += $record->banks_fixed_deposits_12m;
                $fc_fixed_deposits_3m += $record->fc_fixed_deposits_3m;
                $fc_fixed_deposits_6m += $record->fc_fixed_deposits_6m;
                $fc_fixed_deposits_12m += $record->fc_fixed_deposits_12m;
                $banks_savings_deposits += $record->banks_savings_deposits;
                $fc_savings_deposits += $record->fc_savings_deposits;                                                         
            }

            $total = count($api_response['result']);

            $response['result'] = [
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'banks_fixed_deposits_3m_average' => $this->get_average($banks_fixed_deposits_3m, $total),
                            'banks_fixed_deposits_6m_average' => $this->get_average($banks_fixed_deposits_6m, $total),
                            'banks_fixed_deposits_12m_average' => $this->get_average($banks_fixed_deposits_12m, $total),
                            'fc_fixed_deposits_3m_average' => $this->get_average($fc_fixed_deposits_3m, $total),
                            'fc_fixed_deposits_6m_average' => $this->get_average($fc_fixed_deposits_6m, $total),
                            'fc_fixed_deposits_12m_average' => $this->get_average($fc_fixed_deposits_12m, $total),
                            'banks_savings_deposits' => $this->get_average($banks_savings_deposits, $total),
                            'fc_savings_deposits' => $this->get_average($fc_savings_deposits, $total)
                        ];
        }
        
        # output the json object        

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($api_response['status_code'])
            ->set_output(json_encode($response));
    }

    public function periods($period, $record)
    {

        $end_month = date('Y M',strtotime($record->end_of_month));
        $banks_savings_deposits = $record->banks_savings_deposits;
        $fc_savings_deposits = $record->fc_savings_deposits;
        $banks_fixed_deposits_3m = $record->banks_fixed_deposits_3m;
        $banks_fixed_deposits_6m = $record->banks_fixed_deposits_6m;
        $banks_fixed_deposits_12m = $record->banks_fixed_deposits_12m;
        $fc_fixed_deposits_3m = $record->fc_fixed_deposits_3m;
        $fc_fixed_deposits_6m = $record->fc_fixed_deposits_6m;
        $fc_fixed_deposits_12m = $record->fc_fixed_deposits_12m;

        switch ($period) {
            case '3':
                    $response = [
                        'end_of_month'=>$end_month,                                                
                        'banks_fixed_deposits_3m'=>$banks_fixed_deposits_3m,
                        'fc_fixed_deposits_3m'=>$fc_fixed_deposits_3m,
                    ];
                break;
            
            case '6':
                    $response = [
                        'end_of_month'=>$end_month,                                                
                        'banks_fixed_deposits_6m'=>$banks_fixed_deposits_6m,
                        'fc_fixed_deposits_6m'=>$fc_fixed_deposits_6m,
                    ];
                break;
            
            case '12':
                    $response = [
                        'end_of_month'=>$end_month,                                                
                        'banks_fixed_deposits_12m'=>$banks_fixed_deposits_12m,                                    
                        'fc_fixed_deposits_12m'=>$fc_fixed_deposits_12m
                    ];
                break;
            default:
                    $response = [
                        'end_of_month'=>$end_month,
                        'banks_fixed_deposits_3m'=>$banks_fixed_deposits_3m,
                        'banks_fixed_deposits_6m'=>$banks_fixed_deposits_6m,
                        'banks_fixed_deposits_12m'=>$banks_fixed_deposits_12m,
                        'fc_fixed_deposits_3m'=>$fc_fixed_deposits_3m,
                        'fc_fixed_deposits_6m'=>$fc_fixed_deposits_6m,
                        'fc_fixed_deposits_12m'=>$fc_fixed_deposits_12m
                    ];

                break;
            
        }

        return $response;
    }

    public function get_average($val, $total)
    {
        return round($val / $total, 2);
    }
}