<?php
include_once ("include/config.php");  
include_once ("include/connect.php");
  
//Convert MinerName and CardID to FieldName in sql tables  
  function GetMinerFieldName($Cardid,$MinerName)
  {
    global $miners_table;
    if (isset($miners_table[$MinerName]) && isset($miners_table[$MinerName][$Cardid]))
        {
          return $miners_table[$MinerName][$Cardid];
        }
  }
  
  $FiendName = GetMinerFieldName($_GET['Cardid'],$_GET['MinerName']);
  if (isset($FiendName))
     {
       $FiendName = 'Miner'.$FiendName;
     }
     else
     {
         Exit;
     }  
   
//Parsing params
  $FieldValue  = $_GET['Temp'];
  $FieldLoad  = $_GET['Load'];
  $FieldCore  = $_GET['Core'];
  $FieldVolt  = $_GET['Volt'];
  $FieldMem  = $_GET['Mem'];

//Adding data 
  $r = $db->select("INSERT INTO MinerTemp (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldValue,$FieldValue);//ON DUPLICATE KEY UPDATE c=c+1;
  $r = $db->select("INSERT INTO MinerLoad (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldLoad,$FieldLoad);//ON DUPLICATE KEY UPDATE c=c+1;
  $r = $db->select("INSERT INTO MinerCore (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldCore,$FieldCore);//ON DUPLICATE KEY UPDATE c=c+1;
  $r = $db->select("INSERT INTO MinerVolt (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldVolt,$FieldVolt);//ON DUPLICATE KEY UPDATE c=c+1;
?>

