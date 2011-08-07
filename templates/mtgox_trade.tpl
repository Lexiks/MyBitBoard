<link rel="stylesheet" type="text/css" href="css/dash.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="box_header">Last lrade<span style="float:right;"><a href="javascript:ReloadMtGoxTrades()">reload</a><br/></span></div>
<table cellpadding="0" cellspacing="0" border="1" id="orders_table">
    <tr class="header_row" ">
       <th width="30px" >ask/bid</th>   
       <th width="170px" >Date</th>   
       <th width="60px" >Price</th>   
       <th width="60px" >Amount</th>
       <th width="60px" >Sum</th>   
     </tr>
     
     {foreach from=$trade_data item=trade_item key=trade_item_key}
     <tr>   
         <td align="center">{if $trade_item.trade_type eq 'ask'} <img height="10px" src="img/up.png">{else} <img height="10px" src="img/down.png">{/if} {$trade_item.trade_type}</td>
         <td align="center"> {$trade_item.date}</td>
         <td align="center">{$trade_item.price}</td>
         <td align="center" style="{$trade_item.color}">{$trade_item.amount}</td>
         <td align="right">{math equation="amount_btc*usd_price" amount_btc={$trade_item.amount} usd_price={$trade_item.price} format="%.2f"}$</td>   
    </tr>
    {/foreach}

