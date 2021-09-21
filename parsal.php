<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Content-Type: application/json");
    
    $input = file_get_contents('php://input');
    $uri = json_decode($input)->uri;
    
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type:application/json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        $res = curl_exec($ch);
        curl_close($ch);
    if ($res) 
    { 
        echo $res;
    } 
    else 
    { 
        echo json_encode(["status"=>false]);
        
    }
?>