<?php
include_once ("../include/config.php");  
include_once ("../include/smarty_init.php");
include_once ("../include/functions.php");
include_once ("../modules/pool_func.php");  


   
  function GetFields()
  {   
     global $db;            
  //  Fields FROM MinerTemp where Field like "Miner%"
      $fileds = $db->select('SHOW Fields FROM MinerTemp where Field like "Miner%"');
      foreach ($fileds as $field)
      {
          $field_name = $field['Field'];
          $fileds_line .= "MinerTemp.$field_name as Temp$field_name,MinerCore.$field_name as Core$field_name,";
      }
     $fileds_line = substr($fileds_line,0,-1);
     return $fileds_line; 
  }
 
  if (($_REQUEST['ajax'] == 1) && ($_REQUEST['action'] === 'get_temp_data') )
  {
     include_once ("../include/connect.php");
     $miner_field = $_REQUEST['miner'];
     $callback = $_REQUEST['callback'];
     $DataType = $_REQUEST['DataType'];
     
     switch ($DataType)
     {
         case 'Temp' : $TableName = 'MinerTemp';break;
         case 'Core' : $TableName = 'MinerCore';break;
         case 'Volt' : $TableName = 'MinerVolt';break;
         case 'Load' : $TableName = 'MinerLoad';break;
         default : $TableName = 'MinerLoad';break;
     }
     
     $DateFrom = $_REQUEST['DateFrom'];//  $DateFrom = 1312580700;
     $DateTo = $_REQUEST['DateTo'];   //  $DateTo=1312643940;
     
     $page = $_REQUEST['page'];
     $start = $_REQUEST['start'];     //  $start = 0;
     $limit = $_REQUEST['limit'];     //  $limit = 50;
     //$Fileds = GetFields();
     if (preg_match( '/[^0-9a-zA-Z]/', $miner_field )) {Exit;}
     //$SQL = "SELECT $Fileds FROM MinerTemp ";
     //$SQL .= 'left join MinerCore on ( MinerTemp.UnixMinute = MinerCore.UnixMinute) ';
     $SQL = "SELECT * FROM $TableName ";
     $SQL .= "WHERE ($TableName.UnixMinute BETWEEN ?d and ?d) ";
     $miner_data_count = $db->select("SELECT Count(*) as cnt FROM $TableName WHERE (UnixMinute BETWEEN ?d and ?d)",$DateFrom,$DateTo);    
     $miner_data_count = $miner_data_count[0]['cnt'];
     $miner_data = $db->select("$SQL ORDER BY $TableName.TransNo DESC limit ?d,?d",$DateFrom,$DateTo,$start,$limit);    
     $res['totalCount'] = $miner_data_count;
     $res['topics'] = $miner_data;
     
     echo $callback.'('.json_encode($res).');';
  }  
?>

