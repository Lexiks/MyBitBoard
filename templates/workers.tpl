<div class="box_header">Workers<span style="float:right;"><a href="javascript:ReloadWorkers()">reload</a><br/></span></div>
<table cellpadding="0" cellspacing="0" border="0" id="workers_table">
<tr class="header_row">
   <th width="60px" >Miner</th>
   <th width="40px"> &deg;</th>
   <th>...</th><th>&#916;</th>
   <th width="50px">&nbsp;</th>
   <th  width="70px">Load</th>
   <th  width="70px">Core</th>
   <th>Shares dip</th>
   <th width="70px">Shares cz</th>
   <th width="50px">&nbsp;</th>
 </tr>
 
 {foreach from=$workers item=worker key=worker_name}
 <tr>
  <td><font color={$worker.ColorParams.color}>{$worker_name}</font></td>
  <td><font color={$worker.ColorParams.color}><b><center>{$worker.temp_value} &deg;</center></b></font></td>
  <td><img height="12px" src="img/{$worker.ColorParams.sign_pic}"/></td>
  <td>{$worker.ColorParams.sign}{$worker.temp_change_10_min} </td>
  <td ><font size="1px">{$worker.temp_old_value} </font></td>
  <td align="center">{$worker.load_value} %</td>
  <td align="center">{$worker.core_value}</td>
  <td><img height="12px" src="img/{$worker.pool_data_row_dip.img_dip}"/>{$worker.pool_data_row_dip.shares}</td> 
  <td><img height="12px" src="img/{$worker.pool_data_row_cz.img_cz}"/>{$worker.pool_data_row_cz.shares}</td>
  <td>{$worker.hash} Mh/s</td>
</tr>


{/foreach}
 <tr>
  <td>&nbsp;</td>
  <td align="center">{$TempSum}</td>
  <td>&nbsp;</td>
  <td align="center">{$TempSumChange}</td>
  <td>&nbsp;</td>
  <td align="center"></td>
  <td align="center">{$CoreSum}/{$CoreAvg}</td>
  <td>&nbsp;</td> 
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
<br>
   <div class="box" style="border:1px;">
            <h1>DeepBit hash:</h1>
            <span class="amount">{$pool_data.dip.hashrate}<small>&nbsp;MH/s</small></span>
            <div class="view">View &nbsp;</div>
    </div>
   <div class="box">
            <h1>DeepBit reward:</h1>
            <span class="amount">{$pool_data.dip.confirmed_reward|number_format:5:".":","}<small>&nbsp;BTC</small></span>
            <div class="view">View &nbsp;</div>
    </div>
    
    <div class="box">
            <h1>Slash reward:</h1>
            <span class="amount">{$pool_data.cz.confirmed_reward|number_format:5:".":","}<small>&nbsp;BTC</small></span>
            <div class="view">View &nbsp;</div>
    </div>
