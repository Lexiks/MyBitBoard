function SetBuyPrice(price)
{
    price = price.replace('$','');
    $('#mtgox_sell_price').val(price); 
    ReCalcSellSum();  
}

function SetSellPrice(price)
{
  price = price.replace('$','');
    $('#mtgox_buy_price').val(price); 
    ReCalcBuySum();
}


function ReCalcSellSum()
{
    sellsum = $('#mtgox_sell_amount').val()*$('#mtgox_sell_price').val();
    $('#mtgox_sell_sum').text(sellsum.toFixed(3)+'$');
}

function ReCalcBuySum()
{
    sellsum = $('#mtgox_buy_amount').val()*$('#mtgox_buy_price').val();
    $('#mtgox_buy_sum').text(sellsum.toFixed(3)+'$');
}

function MtgoxCancelOrder(oid,type)
{
    
    $.get("actions/mtgox_data.php?ajax=1&action=cancel_mtgox_order&oid="+oid+"&type="+type, function(data){
              $('#mtgox_orders').html(data);
         });
    $('#order'+oid).fadeOut("slow");
}

function MtgoxSellOrder(amount,price)
{
    $.get("actions/mtgox_data.php?ajax=1&action=sell_mtgox_order&amount="+amount+"&price="+price, function(data){
              $('#mtgox_orders').html(data);
         });
}

function MtgoxBuyOrder(amount,price)
{
    $.get("actions/mtgox_data.php?ajax=1&action=buy_mtgox_order&amount="+amount+"&price="+price, function(data){
              $('#mtgox_orders').html(data);
         });
}

//Reload functions
function ReloadWorkers()
{
    $.get("actions/pool_data.php?ajax=1&action=get_table", function(data){
              $('#workers_status').html(data);
         }); 
    $.get("actions/pool_data.php?ajax=1&action=get_table&get_shares=1", function(data){
              $('#workers_status').html(data);
         });
         
}

function ReloadMtGoxDepth()
{
        $.get("actions/mtgox_data.php?ajax=1&action=get_mtgox_depth", function(data){
              $('#mtgox_depth').html(data);
         });   
}

function ReloadMtGoxOrders()
{
    $.get("actions/mtgox_data.php?ajax=1&action=get_mtgox_orders", function(data){
              $('#mtgox_orders').html(data);
         });
}

function ReloadMtGoxTrades()
{
    $.get("actions/mtgox_data.php?ajax=1&action=get_mtgox_trades", function(data){
              $('#mtgox_trades').html(data);
         });
}
       
function ReloadAll()
{
    ReloadWorkers();
    ReloadMtGoxOrders();       
    ReloadMtGoxDepth();  
    ReloadMtGoxTrades();
         
         
    $.get("actions/pool_data.php?ajax=1&action=diff_data", function(data){
              var diff_data = jQuery.parseJSON( data );
              $('#difficulty').html(diff_data['difficulty']);
              $('#next_difficulty').html(diff_data['next_difficulty']);
              $('#grow_difficulty').html(diff_data['grow_difficulty']);
         });
         
    $.get("actions/mtgox_data.php?ajax=1&action=mtgox_data", function(data){
              var mtgox_data = jQuery.parseJSON( data );
              console.log(mtgox_data['ticker']);
              $('#mtgox_high').html(mtgox_data['ticker']['high'].toFixed(3));
              $('#mtgox_low').html(mtgox_data['ticker']['low'].toFixed(3));
              $('#mtgox_avg').html(mtgox_data['ticker']['avg'].toFixed(3));
              
              $('#mtgox_buy').html(mtgox_data['ticker']['buy'].toFixed(3));
              $('#mtgox_sell').html(mtgox_data['ticker']['sell'].toFixed(3));
              $('#mtgox_last').html(mtgox_data['ticker']['last'].toFixed(3));
         });
        
       
                  
    $("#orderbook").attr({ src: 'http://bitcoincharts.com/charts/mtgoxUSD/orderbook.png' });   
    $("#accumulated_orderbook").attr({ src: 'http://bitcoincharts.com/charts/mtgoxUSD/accumulated_orderbook.png' });   
    $("#pricechart").attr({ src: 'http://bitcoincharts.com/charts/chart.png?m=mtgoxUSD&amp;v=1&amp;t=S&amp;noheader=1&amp;height=80&amp;width=750&amp;r=2' });   
    
}
$(document).ready(function() {
                 ReloadAll();
});

