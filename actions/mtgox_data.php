<?php
include_once ("../include/config.php");  
include_once ("../include/smarty_init.php");
include_once ("../include/functions.php");
//include_once ("include/json.php");  
include_once ("../modules/mtgox_func.php");  

  function ShowOrders($mtgox_orders_data)
  {
    global $smarty;
    $mtgox_data = GetMtGoxData();
    
    $smarty->assign('mtgox_data',json_decode($mtgox_data, true));
    $smarty->assign('orders',$mtgox_orders_data);
    $smarty->display('mtgox_orders.tpl');
  }
  function GetDepthColor($amount)
     {
         

         if ($amount < 1) {$color = 'color:grey;';}
         
         if ($amount > 10) {$color = 'font-weight:bolder;';}
         if ($amount > 50) {$color = 'color:blue;';}
         if ($amount > 100) {$color = 'color:maroon;';}
         if ($amount > 500) {$color = 'color:red;';}
         if ($amount > 1000) {$color = 'color:red;font-weight:bolder;';}
         return $color;
         
  }
     
  if ($_REQUEST['ajax'] == 1)
  {
      switch ($_REQUEST['action']) 
            {
            case 'mtgox_data' : {
                                 $mtgox_data = GetMtGoxData();
                                 echo $mtgox_data;
                                 Exit;
                               }  break;
                               
            case 'get_mtgox_trades' : {
                                         $tid = (time()-24*100);
                                         $mtgox_trade_data = GetTrades($tid.'000000');
                                         if (!isset($mtgox_trade_data)) {echo "Get trade data error!";exit;}
                                    foreach ($mtgox_trade_data as $key => $value)
                                     {
                                         
                                         $trade['date'] = date( 'd-m-Y H:i:s',$value['date']+$utcdiff);
                                         $trade['price'] = round($value['price'],3);
                                         $trade['amount'] = round($value['amount'],3);
                                         $trade['color'] = GetDepthColor($trade['amount']);
                                         $trade['trade_type'] = $value['trade_type'];
                                         if ($trade['amount'] > 1) {$mtgox_trade_data_out[$value['tid']] = $trade;}
                                     }
                                     rsort($mtgox_trade_data_out);
                                         $smarty->assign('trade_data',$mtgox_trade_data_out);
                                         $smarty->display('mtgox_trade.tpl');
                                         exit;
                                         //$mtgox_data = GetMtGoxData(); 
            }
                
            case 'get_mtgox_depth' : {
                                 $mtgox_depth_data = GetDepth();
                                 if (!isset($mtgox_depth_data)) {echo "Get depth data error!";exit;}
                                 $mtgox_data = GetMtGoxData();
                                 rsort ($mtgox_depth_data['bids']);
                                 foreach ($mtgox_depth_data['bids'] as $key => $value)
                                     {
                                         $bid['amount'] = round($mtgox_depth_data['bids'][$key][1],3);
                                         $bid['price'] = round($mtgox_depth_data['bids'][$key][0],3);
                                         $bid['color'] = GetDepthColor($bid['amount']);
                                         if ($bid['amount'] > 1) {$mtgox_depth_data_out['bids'][] = $bid;}
                                     }
                                     foreach ($mtgox_depth_data['asks'] as $key => $value)
                                     {
                                         $ask['amount'] = round($mtgox_depth_data['asks'][$key][1],3);
                                         $ask['price'] = round($mtgox_depth_data['asks'][$key][0],3);
                                         $ask['color'] = GetDepthColor($ask['amount']);
                                         if ($ask['amount'] > 1) {$mtgox_depth_data_out['asks'][] = $ask;}
                                         
                                     }
     
     
                                 array_splice($mtgox_depth_data_out['bids'],45);
                                 array_splice($mtgox_depth_data_out['asks'],45);
                                 $smarty->assign('mtgox_data',json_decode($mtgox_data, true));
                                 $smarty->assign('mtgox_depth',$mtgox_depth_data_out);
                                 $smarty->display('mtgox_depth.tpl');
                                 Exit;
                               }  break;  
                               
            case 'get_mtgox_orders' : {
                                 $mtgox_orders_data = GetOrders();
                                 if (!isset($mtgox_orders_data)) {echo "Get orders data error!";exit;}
                                 ShowOrders($mtgox_orders_data);                                 
                                 Exit;
                               }  break;
            
            case 'cancel_mtgox_order' : {
                                 $mtgox_orders_data =  CancelOrder($_REQUEST['oid'],$_REQUEST['type']);
                                 ShowOrders($mtgox_orders_data);    
                                 Exit;
                               }  break;
                               
            case 'sell_mtgox_order' : {
                                 $mtgox_orders_data =  SellBTC($_REQUEST['amount'],$_REQUEST['price']);
                                 $mtgox_orders_data = GetOrders();
                                 ShowOrders($mtgox_orders_data);    
                                 Exit;
                               }  break;                               
            case 'buy_mtgox_order' : {
                                 $mtgox_orders_data =  BuyBTC($_REQUEST['amount'],$_REQUEST['price']);
                                 $mtgox_orders_data = GetOrders();
                                 ShowOrders($mtgox_orders_data);    
                                 Exit;
                               }  break;                               
                               
                               
            }
  }
?>