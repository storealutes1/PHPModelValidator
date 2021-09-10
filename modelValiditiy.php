<?php

function modelValid($objModel, $modelDict){
    $modelArr = json_decode(json_encode($objModel), true); 
    
    //Check All Required Properties Exist In Input Model
    foreach($modelDict as $k=> $v){
        if ($v['required'] && !array_key_exists($k, $modelArr)) {
            header("HTTP/1.1 400 Bad Request");
            exit("Missing required Property '$k'");
        }
    }
    
    //Check All Properties Exist In Defined Model
    foreach($modelArr as $k => $v){
        if(!array_key_exists($k, $modelDict)) {
            header("HTTP/1.1 400 Bad Request");
            exit("Unknown Property '$k'");
        }
        if(gettype($objModel->$k) != $modelDict[$k]['type']){
            header("HTTP/1.1 400 Bad Request");
            exit("Expected ".$modelDict[$k]['type']." for property '$k' received ".gettype($objModel->$k));
        }
        
        //Array minimum
        if($modelDict[$k]['type'] == "array" &&
            array_key_exists('minCount', $modelDict[$k]) &&
            count($v) < $modelDict[$k]['minCount']){
                
            header("HTTP/1.1 400 Bad Request");
            exit("At least ". $modelDict[$k]['minCount']." value(s) are required for '$k'");
        }
        
        //Array maximum
        if($modelDict[$k]['type'] == "array" &&
            array_key_exists('maxCount', $modelDict[$k]) &&
            count($v) > $modelDict[$k]['maxCount']){
                
            header("HTTP/1.1 400 Bad Request");
            exit("'$k' has a maximum of ". $modelDict[$k]['maxCount']." value(s)");
        }
        
        //String minimum
        if($modelDict[$k]['type'] == "string" &&
            array_key_exists('minLength', $modelDict[$k]) &&
            strlen($v) < $modelDict[$k]['minLength']){
                
            header("HTTP/1.1 400 Bad Request");
            exit("'$k' has a minimum length of ". $modelDict[$k]['minLength']." character(s)");
        }
        
        //String maximum
        if($modelDict[$k]['type'] == "string" &&
            array_key_exists('maxLength', $modelDict[$k]) &&
            strlen($v) > $modelDict[$k]['maxLength']){
                
            header("HTTP/1.1 400 Bad Request");
            exit("'$k' has a maximum length of ". $modelDict[$k]['maxLength']." character(s)");
        }
        
        //String length
        if($modelDict[$k]['type'] == "string" &&
            array_key_exists('length', $modelDict[$k]) &&
            strlen($v) != $modelDict[$k]['length']){
                
            header("HTTP/1.1 400 Bad Request");
            exit("'$k' has a required length of ". $modelDict[$k]['length']." character(s)");
        }
    }

}  
    
?>
