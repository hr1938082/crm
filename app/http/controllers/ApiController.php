<?php

/**
* CalendarController
*/
class ApiController extends Controller{
    
   private $leadModel;
   private $projectModel;
   private $orderModel;
   private $gatewayModel;
   private $webclient;
    	
   function __construct(){
		parent::__construct();
 		$this->commons = new CommonsController();
 		$this->leadModel = new Lead();
 		$this->projectModel = new Project();
		$this->orderModel = new Order();
		$this->gatewayModel = new Gateway();
		$this->webclient = new WebClient();
 	}
 	
    public function LeadApi(){
         
	 
		  $data = [];
			$data['email'] = $this->url->post('email');
			$data['phone'] = $this->url->post('phone');
			$data['firstname'] = $this->url->post('firstname');
			$data['lastname'] = $this->url->post('lastname');
			$data['company'] = $this->url->post('company');
			 // return $data; 
	$result = $this->leadModel->createLead($data);
	 $data['id'] = $result;
	  $this->leadModel->convertLeadToContact($data);
          
		 	 return "Success";
 
 		 
    }
    
    
    
     public function ProjectApi(){
        
       
		  $data = [];
      $data['email'] = $this->url->post('email');
      
      $check_lead_exist = $this->leadModel->check_lead_exist($data);
    
       if($check_lead_exist != false){
    //     var_dump($check_lead_exist);
    //     die();
   	  $data = [];
			$data['name'] = $this->url->post('name');
			$data['description'] = $this->url->post('description');
			$data['customer'] = $this->url->post('customer');
			$data['billing_method'] = $this->url->post('billing_method');
			$data['currency'] = $this->url->post('currency'); 
			
			
			
			$data['rate_hour'] = $this->url->post('rate_hour');
			$data['project_hour'] = $this->url->post('project_hour');
			$data['total_cost'] = $this->url->post('total_cost');
			$data['staff'] = $this->url->post('staff');
			$data['task'] = $this->url->post('task'); 
			
			$data['completed'] = $this->url->post('completed');
			$data['start_date'] = $this->url->post('start_date');
			$data['due_date'] = $this->url->post('due_date');
			$data['date_of_joining'] = $this->url->post('date_of_joining');
			$result = $this->projectModel->createProject($data);
				  return $result;
       }else{
          
          	$data = [];
			$data['name'] = $this->url->post('name');
			$data['description'] = $this->url->post('description');
			$data['customer'] = $this->url->post('customer');
			$data['billing_method'] = $this->url->post('billing_method');
			$data['currency'] = $this->url->post('currency'); 
			$data['rate_hour'] = $this->url->post('rate_hour');
			$data['project_hour'] = $this->url->post('project_hour');
			$data['total_cost'] = $this->url->post('total_cost');
			$data['staff'] = $this->url->post('staff');
			$data['task'] = $this->url->post('task'); 
			$data['completed'] = $this->url->post('completed');
			$data['start_date'] = $this->url->post('start_date');
			$data['due_date'] = $this->url->post('due_date');
			$data['date_of_joining'] = $this->url->post('date_of_joining');
 			 // return $data; 
 			 
 		 $data['firstname'] = $this->url->post('firstname');
			$data['lastname'] = $this->url->post('lastname');
		
			$data['email'] = $this->url->post('email');
			$data['company'] = $this->url->post('company'); 
         	$data['phone'] = $this->url->post('phone'); 
 
			$result = $this->projectModel->createProject($data);
			
				$result = $this->leadModel->createLead($data);
	 $data['id'] = $result;
	  $this->leadModel->convertLeadToContact($data);

	  
          return $result;
           
       }
    }
    
    
    public function leadform_api(){
      
        $this->view->render('api/lead_form.tpl');
        
    }
    
    public function leadform_api_submit($get = null){
      	$data = [];
		if($get === null)
		{
			$data['email'] = $this->url->post('email');
			$data['phone'] = $this->url->post('phone');
			$data['firstname'] = $this->url->post('firstname');
			$data['lastname'] = $this->url->post('lastname');
			$data['company'] = $this->url->post('company'); 
			$data['website_id'] = $this->url->post('website_id');
		}
		else
		{
			$data['email'] = $get['email'];
			$data['phone'] = $get['phone'];
			$data['firstname'] = $get['firstname'];
			$data['lastname'] = $get['lastname'];
			$data['company'] = $get['email'];
    //   	var_dump($get);
    //   	die;
			$data['website_id'] = $get['website_id'];
		}
		$data['salutation'] = "";
		$data['website'] = "";
		$data['address'] = "";
		$data['country'] = "";
		$data['remark'] = "";
		$data['source'] = "";
		$data['marketing'] = "";
		$data['expire'] = "";
		$data['status'] = "";
		$data['staff'] = "";
		$data['website'] = "";
		$data['address'] = "";
		$data['country'] = "";
		$data['remark'] = "";
		$data['user_id'] = "";
		// return $data; 
		$result = $this->leadModel->createLead($data);
	 	$data['id'] = $result;
	  	$this->leadModel->convertLeadToContact($data);
		
		return $data['id'];
    }
    public function orderApi()
	{
	    
		header('Content-Type: application/json');
		$input = file_get_contents('php://input');
		$input = (array)json_decode($input);
		$email['email']= $input['email'];
		$check_lead = $this->leadModel->check_lead_exist($email);
		if($check_lead === false)
		{
	   // var_dump($check_lead);
			$this->leadform_api_submit($input);
		}
		$order = $this->orderModel->Create((array)$input["order"]);
		
		$data = [];
		$data["name"] = "";
		$data["customer"] = $this->projectModel->getCustomers(null,$email["email"])[0]["id"];
		$temp = (array)$input["project"];
		$data["description"] = $temp['description'];
		$data["billingmethod"] = "";
		$data["currency"] = "";
		$data["ratehour"] = "";
		$data["projecthour"] = "";
		$data["totalcost"] = "";
		$data["staff"] = "";
		$data["order_id"] = $order;
		$data["task"] = "";
		$data["completed"] = "0";
		$data["start_date"] = "";
		$data["website_id"] = $input["website_id"];
		$data["due_date"] = "";
		$last_id=$this->projectModel->createProject($data);
			$data = [];
		foreach ($input["file"] as  $value) {
			$image_name = explode('.', $value->name);
			$extension = end($image_name);
			$image_data = base64_decode($value->base64);
			$image_Name = sha1(date('dmYhis') . microtime('true'));
			$filename = "$image_Name.$extension";
		    file_put_contents("public/uploads/$filename", $image_data);
			$dir = "$filename";
			$data['name'] = $dir;
			$data['type_id'] = $last_id;
			$data['type'] = 'project';	
			$this->commonsModel = new Commons();
			$result = $this->commonsModel->insertAttchedFile($data);
		}
		echo json_encode(["status"=>true,"id"=>$last_id]);
	}
	public function paymentDetails()
	{
		header('Content-Type: application/json');
		$input = file_get_contents('php://input');
		$input = (array)json_decode($input);
		$data = [
			'name' => $input['name'],
			'amount' => $input['amount'],
			'project_id' => $input['id'],
		];
		$result = $this->gatewayModel->createGateway($data);
		if($result)
		{
			echo json_encode(['status'=>'Payment Sucessfully']);
		}
		else
		{
			echo json_encode(['status'=>'Payment not Sucessfully']);
		}
	}
}