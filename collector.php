<?php
include_once ("include/config.php");  
include_once ("include/connect.php");
  $timestamp = mktime(date("H"), date("i"), 0, date("n")  , date("j"), date("Y"));
  
  if ($_GET['Cardid'] == 0) 
     {$cardid = 1;}
  else 
     {$cardid = 2;}
  $FiendName = 'Miner'.$_GET['MinerName'].$cardid;
  $FieldValue  = $_GET['Temp'];
  $FieldLoad  = $_GET['Load'];
  $FieldCore  = $_GET['Core'];
  $FieldVolt  = $_GET['Volt'];
  $FieldMem  = $_GET['Mem'];


  $r = $db->select("INSERT INTO MinerTemp (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldValue,$FieldValue);
  $r = $db->select("INSERT INTO MinerLoad (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldLoad,$FieldLoad);
  $r = $db->select("INSERT INTO MinerCore (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldCore,$FieldCore);
  $r = $db->select("INSERT INTO MinerVolt (Date,UnixMinute,$FiendName) VALUES (FROM_UNIXTIME(?d),?d,?d) ON DUPLICATE KEY UPDATE $FiendName = ?d",$timestamp,$timestamp,$FieldVolt,$FieldVolt);
  echo  $timestamp;
?>

