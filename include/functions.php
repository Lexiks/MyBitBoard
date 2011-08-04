<?php
   function CurlGet($url)
   {
         $ch = curl_init(); 
         curl_setopt($ch, CURLOPT_URL, $url); 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         curl_setopt($ch, CURLOPT_TIMEOUT, 3);
         $output = curl_exec($ch); 
         curl_close($ch); 
         return $output;
     }
     
   function CurlGetHttps($url)
   {
       /*  $ch = curl_init(); 
         curl_setopt($ch, CURLOPT_URL, $url); 
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         curl_setopt($ch, CURLOPT_TIMEOUT, 3);
         $output = curl_exec($ch); 
         curl_close($ch); 
         return $output;*/
         $opts = array(
          'http'=>array(
            'timeout'=> 3, // 3 second timeout
            'user_agent'=> 'hashcash',
            'header'=>"Accept-language: en\r\n"
          )
        );
        $context = stream_context_create($opts);
        $output = file_get_contents($url, FALSE, $context);
        return $output;
     }     
?>