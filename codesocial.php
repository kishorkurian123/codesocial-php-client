<?php
/*
| -------------------------------------------------------------------
| PHP Api client for Codesocial REST API
| -------------------------------------------------------------------
| Simple, easy to use library to use Codesocial REST API
|
| For complete instructions on how to use the library,please check the readme file.
| 
|   Author  : Kishor Kurian aka Repulsor
|   Contact : repulsorbhw (Skype)
|
|  “Any fool can write code that a computer can understand. Good programmers write code that humans can understand.”
|   -Martin Fowler
| -------------------------------------------------------------------
*/
class CodeSocial
{
    //Store token and url to use through out the class.
    private $access_token;
    private $apiurl = "http://DOMAINNAME.com/api/v1/";
    private $errortrigger; //production mode(0), Fatal(1), notice(2)
    
    public function __construct($token, $state = 0)//defaults to production mode. No error messages.
    {
        //set token and api url
        $this->access_token = $token;
        $this->errortrigger = $state;
    }
    private function errorhandler($errormessage)
    {
        if ($this->errortrigger == 0)
        {
             //no error message to the user, but errors are logged - Production mode
            error_log($errormessage,0);
           
        }
        elseif ($this->errortrigger == 1)
        {
            //Development mode - Library will throw fatal errors
            trigger_error($errormessage, E_USER_ERROR);
        } else
        {
            //Shows notices on errors. Script execution continues, A False may be returned instead of expected response.
            trigger_error($errormessage);
        }
    }
    //Curl function for GET and POST request
    private function Curl($endpoint, $type = "GET", $data = null)
    {
        $ch = curl_init();
        if ($type == "POST")
        {
            $endpoint = $this->apiurl . $endpoint;
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Content-Length: ' . strlen($data)));
        } else
        {
            $endpoint = $this->apiurl . $endpoint . "/?token=$this->access_token";
        }
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute the call and get the response.
        $response = curl_exec($ch);
        //check for curl errors, log and die incase of errors.Possible cases like Site outage etc.
        if (!$response)
        {   //includes all possible curl errors. Timeouts,unreachable and all those.
            $this->errorhandler(curl_error($ch));
            return false;
        } else
        { //success - valid response. jscon_decode it.
            return json_decode($response,TRUE);
        }
    }
//GET End points. Returns array response
    public function GetBalance()
    {
        $curlresponse = $this->curl("/balance");
        return $curlresponse;
    }
    public function GetProducts()
    {
        $curlresponse = $this->curl("/products");
        return $curlresponse;
    }
    public function GetTasks()
    {
        $curlresponse = $this->curl("/tasks");
        return $curlresponse;
    }
    
    //CreateTask - Parameters are  id,destiation and quantity. Accesstoken is appended automagically.
    public function CreateTask($id = null, $destination = null, $quantity = null)
    {
        //check if any values are null, trigger an error if any of them is null
        if ($id == null || $destination == null || $quantity == null)
        {
            $this->errorhandler("CreateTask() Function invalid or missing parameters");
            return false;
        }
        //check if id and quantity are int and trigger an error if they arent.
        if (!is_int($id) || !is_int($quantity))
        {
            $this->errorhandler("CreateTask() id and quantity must be an int");
            return false;
        } else
        {
            //set the array.
            $data["id"] = $id;
            $data["quantity"] = $quantity;
        }
        //destination - Can be array or string. Error if its of another datatype 
        if(is_array($destination) || is_string($destination)){
        $data["destination"] = $destination;
        }
        else{
            $this->errorhandler("CreateTask() Destination is not of the expected data type");
        }
        //append access_token to the array elements
        $data["token"] = $this->access_token;
        //Make the call
        $curlresponse = $this->curl("/tasks", "POST", json_encode($data));
        //return data as array 
        return $curlresponse;
    }
}
