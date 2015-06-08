# codesocial-php-client
PHP API Library for Codesocial

#How to use
The library must be included to your PHP script that uses the API calls.

```
require "codesocial.php";
```
And make an object which has 3 parameters, the token, the API host and api version.

```
$codesocial = new CodeSocial($token,"http://167.114.158.94:4000","1");
```
You are ready to make API calls from now on, and you dont have to pass token on subsequent requests.

#Sample Usage
GET /tasks

```
require "codesocial.php";

$token ='$pbkdf2-sha512$60000$ZoyySeiSKCXErZNdEn0A8g$Xf0bwmt3avfklCnMSWIGFPSbY0LDrW3N13BB4IW/BmYAoAss/D/ClDGgcTgR96d6NFu2p./QsbEVHoU6dIFnTQ';

$codesocial = new CodeSocial($token,"http://167.114.158.94:4000","1");
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
If you need JSON response instead of array, use FALSE as the parameter

```
$tasks = $codesocial->GetTasks(FALSE);
```
Result:
```
{"processing":[{"to_process":20000,"timestamp":1433635513,"state":"processing","processed":1500,"module":"instagram","destination":"justinbieber","category":"followers"}],"completed":[]}
```

#POST /tasks

Create an array which includes id of the product,destination and quantity

You can go either way in array creation, easier being

```
$data["id"]=5;//
$data["destination"]="username";
$data["quantity"]=100;
```
You can also use the single line array key=>value method. Works just fine.

Do the request

```
$response = $codesocial->CreateTask($data);

```
Result : 

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
For JSON response, use FALSE as the second parameter

```
$response = $codesocial->CreateTask($data,FALSE);

```
Result:
```
{"status":"ok","currency":"USD","charge":8.75}
```


#Sample - Full code to products, and use it to create a task
```
<?php
require "codesocial.php";
$token ='$pbkdf2-sha512$60000$ZoyySeiSKCXErZNdEn0A8g$Xf0bwmt3avfklCnMSWIGFPSbY0LDrW3N13BB4IW/BmYAoAss/D/ClDGgcTgR96d6NFu2p./QsbEVHoU6dIFnTQ';
$codesocial = new CodeSocial($token,"http://167.114.158.94:4000","1");
$tasks = $codesocial->GetProducts();
$id = $tasks["items"][1]["products"][0]["id"]; // Manual locating. May need to provide users with a search capability within the library. 
//prepare data array
$data["id"]=$id;
$data["destination"]="randomusername";
$data["quantity"]="125";
//Call CreateTask. FALSE for JSON response.
$data = $codesocial->CreateTask($data,FALSE);
echo $data;
```

Result:
```
{"status":"ok","currency":"USD","charge":8.75}
```

