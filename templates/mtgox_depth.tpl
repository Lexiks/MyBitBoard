<link rel="stylesheet" type="text/css" href="css/dash.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="box_header">MtGox Depth<span style="float:right;"><a href="javascript:ReloadMtGoxDepth()">reload</a><br/></span></div>

<table cellpadding="0" cellspacing="0" border="1" id="depth_table">
    <tr class="header_row">
       <th width="80px" > <img height="10px" src="img/down.png">Ready to sell at</th>
       <th width="30px" ></th>    
       <th width="75px" >Amount</th>    
       <th width="2px" ></th>    
       <th width="80px" ><img height="10px" src="img/up.png">Ready to buy at</th>
       <th width="30px" ></th>    
       <th width="75px" >Amount</th>    
     </tr>
     
     {foreach from=$mtgox_depth['asks'] item=asks key=asks_key}
         <td align="right" class="td_price" onclick="javascript:SetBuyPrice(this.innerText)">{$asks['price']}$</td>   
         <td align="center"><span style="font-size:80%; color: maroon;">({math equation="last_price-usd_price" last_price={$mtgox_data.ticker.last} usd_price={$asks['price']} format="%.2f"})</span></td>    
         <td align="center" style="{$asks['color']}">{$asks['amount']}</td>   
         <td>&nbsp;</td>   
         
         <td align="right" class="td_price" onclick="javascript:SetSellPrice(this.innerText)">{$mtgox_depth['bids'][$asks_key]['price']}$</td>   
         <td align="center"><span style="font-size:80%; color: maroon;">({math equation="last_price-usd_price" last_price={$mtgox_data.ticker.last} usd_price={$mtgox_depth['bids'][$asks_key]['price']} format="%.2f"})</span></td>    
         <td align="center" style="{$mtgox_depth['bids'][$asks_key]['color']}">{$mtgox_depth['bids'][$asks_key]['amount']}</td>   
    </tr>
    {/foreach}
    </table>

<div style="font-size:60%">
  Amount bid: <b>{$amount_bid} BTC</b><br>
  Sum bid: <b>{$sum_bid}$</b><br>
  Amount ask: <b>{$amount_ask}BTC</b><br>
  Sum ask: <b>{$sum_ask}$</b><br>
</div>    
