<?php
class CodeSocial
{
    //Store token and url to use through out the class.
    private $access_token;
    private $apiurl;
    public function __construct($token, $apihost, $version)
    {
        //set token and api url
        $this->access_token = $token;
        $this->apiurl = $apihost . "/api/v" . $version;
    }
      //Curl function for GET and POST request
    private function Curl($endpoint, $type = "GET", $data = null)
    {
        $ch = curl_init();
        if ($type == "POST")
        {
            if ($data !== null)
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
                echo "The post field array is empty";
                error_log("The post field array is empty", 0); //log error to the error_log file.
                exit;
            }
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
        {
            echo curl_error($ch);
            error_log(curl_error($ch), 0);
        } else
        {
            return ($response);
        }
    }
    
    //get endpoints, a TRUE parameter will return an array.FALSE will give JSON as is. 
    //Default is set to TRUE
    public function GetBalance($bool=TRUE)
    {
        $curlresponse = $this->curl("/balance");
        if ($bool)
        {
            return json_decode($curlresponse, true);
        } else
        {
            return $curlresponse;
        }
    }
    public function GetProducts($bool=TRUE)
    {
        $curlresponse = $this->curl("/products");
        if ($bool)
        {
            return json_decode($curlresponse, true);
        } else
        {
            return $curlresponse;
        }
    }
    public function GetTasks($bool=TRUE)
    {
        $curlresponse = $this->curl("/tasks");
        if ($bool)
        {
            return json_decode($curlresponse, true);
        } else
        {
            return $curlresponse;
        }
    }
    //CreateTask - $data parameter is an array of id,description and quantity. Accesstoken is appended automagically.
    public function CreateTask($data, $bool=TRUE)
    {
        //TO DO - check if all required array elements are not empty or null
        //typecast id and quantity to int.
        $data["id"] = (int)$data["id"];
        $data["quantity"] = (int)$data["quantity"];
        //append access_token
        $data["token"]= $this->access_token;
        $curlresponse = $this->curl("/tasks", "POST", json_encode($data));
        //return data as array or JSON
        if ($bool)
        {
            return json_decode($curlresponse, true);
        } else
        {
            return $curlresponse;
        }
    }
}
