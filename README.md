# codesocial-php-client
PHP API Library for Codesocial

#How to use
The library must be included to your PHP script that uses the API calls.

```
require "codesocial.php";
```
And make an object which 1 required parameter, and 1 optional parameter.

Required parameter : token

Optional parameter : Error Level
```
0  - No errors are shown. All errors are logged. - Production
1  - All errors within the library are FATAL.
2  - All errors within the library are NOTICES, and responses may be FALSE instead of expected arrays.
```

#Production Mode
```
$codesocial = new CodeSocial($token);
```

#Development Mode
```
$codesocial = new CodeSocial($token,1);
```
#Error Level - Notices
```
$codesocial = new CodeSocial($token,2);
```

You are ready to make API calls from now on, and you dont have to pass token on subsequent requests.

#All Responses are Arrays

#Sample Usage
GET /tasks

```
require "codesocial.php";

$token ='$pbkdf2-sha512$60000$ZoyySeiSKCXErZNdEn0A8g$Xf0bwmt3avfklCnMSWIGFPSbY0LDrW3N13BB4IW/BmYAoAss/D/ClDGgcTgR96d6NFu2p./QsbEVHoU6dIFnTQ';

$codesocial = new CodeSocial($token);
$tasks = $codesocial->GetTasks();
```
Output:

```
array(2) {
  ["processing"]=>
  array(1) {
    [0]=>
    array(7) {
      ["to_process"]=>
      int(20000)
      ["timestamp"]=>
      int(1433635513)
      ["state"]=>
      string(10) "processing"
      ["processed"]=>
      int(1500)
      ["module"]=>
      string(9) "instagram"
      ["destination"]=>
      string(12) "justinbieber"
      ["category"]=>
      string(9) "followers"
    }
  }
  ["completed"]=>
  array(0) {
  }
}
```

#POST /tasks

Make a call to the CreateTask() method, with id(int) destination(string/array) and quantity(int)
Make sure the parameters are of the correct datatype,else it may raise an error or notice depending upon the error level set in the object.

Sample
```
$response = $codesocial->CreateTask(5,"username",125);
$response = $codesocial->CreateTask($id,$array,$quantity);
$response = $codesocial->CreateTask($id,array('0'=>'username1','1'=>'username2'),$quantity);
```
Result(when a single username is submitted as destination)
```
array(3) {
  ["status"]=>
  string(2) "ok"
  ["currency"]=>
  string(3) "USD"
  ["charge"]=>
  float(8.75)
}
```



#Sample - Full code to call GetProducts, and then calling CreateTask
```
require "codesocial.php";
$token ='$pbkdf2-sha512$60000$ZoyySeiSKCXErZNdEn0A8g$Xf0bwmt3avfklCnMSWIGFPSbY0LDrW3N13BB4IW/BmYAoAss/D/ClDGgcTgR96d6NFu2p./QsbEVHoU6dIFnTQ';
$codesocial = new CodeSocial($token);
$tasks = $codesocial->GetProducts();
$id = $tasks["items"][1]["products"][0]["id"]; 
$data= array(0 =>'google', 1=>'facebook',2=>'twitter');
//Call CreateTask. FALSE for JSON response.
$data = $codesocial->CreateTask(5,"sandrachandran",313);
var_dump($data);

```

Result:
```
array(4) {
  ["valid_destinations"]=>
  array(3) {
    [0]=>
    string(6) "google"
    [1]=>
    string(8) "facebook"
    [2]=>
    string(7) "twitter"
  }
  ["status"]=>
  string(2) "ok"
  ["currency"]=>
  string(3) "USD"
  ["charge"]=>
  float(65.73)
}
```
