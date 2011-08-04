<script src="js/jquery.dev.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/dash.css" />
<a href="javascript:ReloadAll()">Reload All</a><br/>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
  <td valign="top">
  <div id = "workers_data" >
     <div id = "workers_status" >
       &nbsp;
     </div>
  </div>   
     <br>
     <div>
         <div class="box">
                <h1>Difficulty:</h1>
                <div class="diff_amount"><b>Now: </b><span id="difficulty">&nbsp;</span></div>
                <div class="diff_amount"><b> Next:</b> <span id="next_difficulty">&nbsp;</span></div>
                <div ><img height="16px" src="img/up.png"> <span class="view" id="grow_difficulty">&nbsp;</span> %</div>
        </div>
        
        <div class="box">
                <h1>MtGox Day:</h1>
                <div class="mtgox_amount"><b style="color:red">High: </b><span id="mtgox_high">&nbsp;</span></div>
                <div class="mtgox_amount"><b style="color:green">Low: </b> <span id="mtgox_low">&nbsp;</span></div>
                <div class="mtgox_amount"><b style="color:blue">Avg: </b> <span id="mtgox_avg">&nbsp;</span></div>
                
        </div>
        
        <div class="box">
                <h1>MtGox Trade:</h1>
                <div class="mtgox_amount"><b style="color:red"><img height="14px" src="img/down.png"> Buy: </b><span id="mtgox_buy">&nbsp;</span></div>
                <div class="mtgox_amount"><b style="color:green"> <img height="14px" src="img/up.png"> Sell: </b> <span id="mtgox_sell">&nbsp;</span></div>
                <div class="mtgox_amount"><b style="color:blue">Last: </b> <span id="mtgox_last">&nbsp;</span></div>
        </div>
     </div>
  </td>
  <td valign="top">
      <div id = "mtgox_data" >
          <div id = "mtgox_orders" >
             &nbsp;
          </div>
     </div>
     
     <div id = "mtgox_data" >
          <div id = "mtgox_trades" >
             &nbsp;
          </div>
     </div>
     
  </td>
  <td valign="top"><div id = "mtgox_data" >
         <div id = "mtgox_depth" >&nbsp;
         </div>
      </div>
  </td>
</tr>
</table>
    
    

<br>    
<div align="left" style="dispplay:block">
<a href="http://bitcoincharts.com/charts/mtgoxUSD"target="_blank">
  <img  border = "0" width="750" height="112" symbol="mtgoxUSD" class="rt-chart" id="pricechart" src="">
</a>
</div>
<img class="rt-chart" width="750" height="150" src="" symbol="mtgoxUSD" id="orderbook">
<img class="rt-chart" width="750" height="150" src=""  id="accumulated_orderbook" symbol="mtgoxUSD">
