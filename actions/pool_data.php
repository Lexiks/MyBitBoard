<?php
include_once ("../include/config.php");  
include_once ("../include/smarty_init.php");
include_once ("../include/functions.php");
include_once ("../modules/pool_func.php");  


   
  function GetColorParams($value,$temp_old_value)
  {
     $color = 'black';
               if (!isset($value)) {
                   $color = 'grey';
               }
               if ($value > 60) {
                   $color = 'green';
               }
               if ($value > 70) {
                   $color = 'blue';
               }
               if ($value > 80) {
                   $color = 'red';
               }
               if ($value > $temp_old_value)
               {
                   $sign_pic = 'up.png';
                   $sign = '+';
               }
               if ($value < $temp_old_value)
               {
                   $sign_pic = 'down_16.png';
                   $sign = '';
               }
               
               if ($value == $temp_old_value)
               {
                   $sign_pic = 'eq.png';
                   $sign = '';
                   $change_10_min = '&nbsp;';
               } 
     return  array('temp_color' => $color,'sign_pic' => $sign_pic,'sign' => $sign,'color' => $color);
     
     
  }
   
  
  if ($_REQUEST['ajax'] == 1)
  {
      switch ($_REQUEST['action']) 
            {
            case 'diff_data' : {
                                 $diff_data = GetDifficultyData();
                                 echo json_encode($diff_data);
                                 Exit;
                               }  break;
            

                               
                                    
  
            }
  }
   
  if (($_REQUEST['ajax'] == 1) && ($_REQUEST['action'] === 'get_table') )
  {
     include_once ("../include/connect.php");
     if ($_REQUEST['get_shares'] == 1) 
        {
              $pool_data = GetSharesData();
        }
     $miner_data = $db->select("SELECT * FROM MinerTemp ORDER BY TransNo DESC limit 4");    
     $load_data = $db->select("SELECT * FROM MinerLoad ORDER BY TransNo DESC limit 4");    
     $core_data = $db->select("SELECT * FROM MinerCore ORDER BY TransNo DESC limit 4");    
     
     $miner_items = $miner_data[1];
     $miner_items_old = $miner_data[4-1];
     
     $load_items = $load_data[1];
     $load_items_old = $load_data[4-1];

     $core_items = $core_data[1];
     $core_items_old = $core_data[4-1];

     //echo "Date ".$uno_recs['Date'].'<BR>';

     $WorkersCount = 0;$CoreSum = 0;$TempSum = 0; $TempSumChange = 0;
     foreach ($miner_items as $key => $temp_value)
     {
         if (substr($key,0,5) === 'Miner') 
            {
                
                $WorkersCount++; 
                $temp_old_value = $miner_items_old[$key];
                $temp_change_10_min = $temp_value-$temp_old_value;//Изменение температуры
                
                $load_value = $load_items[$key];//загрузка
                $load_old_value = $load_items[$key];
                $load_change_10_min = $load_value-$load_old_value;//изменение загрузки
                
                $core_value = $core_items[$key];//загрузка
                $core_old_value = $core_items[$key];
                $core_change_10_min = $core_value-$core_old_value;//изменение загрузки
                
                $key = substr($key,5);
               
               if (isset($pool_data))
                  {
                       $pool_data_row_cz = $pool_data[$key]['cz'];
                       $pool_data_row_dip = $pool_data[$key]['dip'];
                       if ($pool_data_row_cz['alive']) $pool_data_row_cz['img_cz'] = 'on.png'; else  $pool_data_row_cz['img_cz'] = 'off.png';
                       if ($pool_data_row_dip['alive']) $pool_data_row_dip['img_dip'] = 'on.png'; else  $pool_data_row_dip['img_dip'] = 'off.png';               
                       $hash =  round($pool_data_row_dip['shares'] / $pool_data['dip']['shares_sum'] * $pool_data['dip']['hashrate'],0);
                  }
               $ColorParams = GetColorParams($temp_value,$temp_old_value);
               $CoreSum += $core_value;
               $TempSum += $temp_value;
               $TempSumChange += $temp_change_10_min;
               $workers[$key] = array('temp_value' => $temp_value, 'temp_change_10_min' => $temp_change_10_min, 'temp_old_value' => $temp_old_value,
                                      'load_value' => $load_value, 'load_change_10_min' => $load_change_10_min, 
                                      'core_value' => $core_value, 'core_change_10_min' => $core_change_10_min, 
                                      'ColorParams' => $ColorParams, 'hash' => $hash,
                                      'pool_data_row_cz' => $pool_data_row_cz, 'pool_data_row_dip' => $pool_data_row_dip );
               
            }               

     }    //foreach
     
     $smarty->assign('pool_data',$pool_data);     
     $smarty->assign('workers',$workers);
     $smarty->assign('WorkersCount',$WorkersCount);
     $smarty->assign('CoreSum',$CoreSum);
     $smarty->assign('TempSum',$TempSum);
     $smarty->assign('TempSumChange',$TempSumChange);
     $smarty->assign('CoreAvg',round($CoreSum/$WorkersCount,2));
     $smarty->display('workers.tpl');
     exit;  
  
  }
  
  
  
  $smarty->display('index.tpl');
  exit;  
?>

