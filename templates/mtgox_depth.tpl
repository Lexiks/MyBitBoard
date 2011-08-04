<link rel="stylesheet" type="text/css" href="css/dash.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="box_header">Ставки<span style="float:right;"><a href="javascript:ReloadMtGoxDepth()">reload</a><br/></span></div>
<table cellpadding="0" cellspacing="0" border="1" id="depth_table">
    <tr class="header_row">
       <th width="80px" > <img height="10px" src="img/down.png">Готовы продать по</th>
       <th width="30px" ></th>    
       <th width="75px" >Кол-во</th>    
       <th width="2px" ></th>    
       <th width="80px" ><img height="10px" src="img/up.png">Готовы купить по</th>
       <th width="30px" ></th>    
       <th width="75px" >Кол-во</th>    
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

