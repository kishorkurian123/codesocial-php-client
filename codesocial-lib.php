<?php
class CodeSocial ($version,$host,$token){
 public function __construct($token){
    const VERSION = $version;
    const URL = $host;
    const TOKEN = $token;
 }
 private function call($type="GET",$data="NULL"){
     $s = curl_init();
         curl_setopt($s,CURLOPT_URL,);
         curl_setopt($s,CURLOPT_HTTPHEADER,array('Expect:'));
         curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
         curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
         curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
         curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
         curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
         curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation); 
 }
 private function getbalance($decode="array"){
     $response = file_get_contents()
 }
 
 }
