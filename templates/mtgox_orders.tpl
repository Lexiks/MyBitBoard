<link rel="stylesheet" type="text/css" href="css/dash.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="box_header">My orders:<span style="float:right;"><a href="javascript:ReloadMtGoxOrders()">reload</a><br/></span></div>
<span class="orders_header"><b><img height="16px" src="img/bitcoin24.png"> BTC: </b>{$orders.btcs}</span>
<span class="orders_header"><b><img height="16px" src="img/usd16.png"> USD: </b>{$orders.usds}</span>
<table cellpadding="0" cellspacing="0" border="1" id="orders_table">
    <tr class="header_row" ">
       <th width="70px" >Type</th>
       <th width="170px" >Date</th>   
       <th width="60px" >Amount</th>
       <th width="60px" >Price</th>   
       <th width="60px" >Sum</th>   
       <th width="13px" ></th>   
     </tr>
     
     {foreach from=$orders['orders'] item=order key=orders_key}
     <tr id="order{$order.oid}" style="color:{if $order.status eq 0}grey{else}black{/if};">
         <td align="center" width="45px">{if $order.type eq 1} <img height="10px" src="img/up.png"> Sell {else} <img height="10px" src="img/down.png"> Buy{/if}</td>
         <td align="center">{$order.date|convertunix:"d-m-t H:m:s"}</td>
         <td align="center">{$order.amount}</td>
         <td align="right">{$order.price} <span style="font-size:80%; color: maroon;">({math equation="last_price-usd_price" last_price={$mtgox_data.ticker.last} usd_price={$order.price} format="%.2f"})</span></td>   
         <td align="right">{math equation="amount_btc*usd_price" amount_btc={$order.amount} usd_price={$order.price} format="%.2f"}$</td>   

         <td align="center" valign="middle"><a href="javascript:MtgoxCancelOrder('{$order.oid}',{$order.type})"><img height="10px" src="img/cancel.png"></a></td>
    </tr>
    {/foreach}

    </table>
    
            <div class="put_order">         
               <span class="edit_box">Кол-во: <input class="edit_text"   type="text" id="mtgox_sell_amount" size="11" maxlength="11"/  onkeyup="javascript:ReCalcSellSum()"></span>
               <span class="edit_box">Цена: <input class="edit_text"  type="text" id="mtgox_sell_price" size="11" maxlength="11" onchange="javascript:ReCalcSellSum()" value="{$mtgox_data.ticker.buy}" onkeyup="javascript:ReCalcSellSum()"/></span>
               <span class="edit_box" id="mtgox_sell_sum">0</span>
               <span class="edit_box"><img height="10px" src="img/up.png"><input type="submit" value="Sell" class="GrayButton" onClick="MtgoxSellOrder($('#mtgox_sell_amount').val(),$('#mtgox_sell_price').val())"></span>
               
            </div>   
            
            <div class="put_order">         
               <span class="edit_box">Кол-во: <input class="edit_text"   type="text" id="mtgox_buy_amount" size="11" maxlength="11"/ onkeyup="javascript:ReCalcBuySum()"></span>
               <span class="edit_box">Цена: <input class="edit_text"  type="text" id="mtgox_buy_price" size="11" maxlength="11" onchange="javascript:ReCalcBuySum()" value="{$mtgox_data.ticker.sell}" onkeyup="javascript:ReCalcBuySum()"/></span>
               <span class="edit_box" id="mtgox_buy_sum">0</span>
               <span class="edit_box"><img height="10px" src="img/down.png"><input type="submit" value="Buy" class="GrayButton" onClick="MtgoxBuyOrder($('#mtgox_buy_amount').val(),$('#mtgox_buy_price').val())"></span>
            </div>   

