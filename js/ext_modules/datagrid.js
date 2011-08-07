Ext.Loader.setConfig({enabled: true});

Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.ModelManager'
]);



Ext.onReady(function(){
    
    
    
    Ext.tip.QuickTipManager.init();
    
    MinersDataClass = {
                    Miners : ['MinerA1','MinerA2', 'MinerA3','MinerA4','MinerB1','MinerB2','MinerB3','MinerC1','MinerC2','MinerD1'],
                    defaults : { 
                                MinerColumnWidth : 37,
                                DateColumnWidth : 110
                        
                               },
                   GetTempColor : function (value,DataType)
                   {
                       switch (DataType) {
                                           case 'Temp': {
                                                           var color = 'black';
                                                           if (value == 0) {color = 'grey';}
                                                           if (value > 60) {color = 'green';}
                                                           if (value > 70) {color = 'blue';}
                                                           if (value > 80) {color = 'red';}     
                                                        }; break 
                                           case 'Core': {
                                                           var color = 'black';
                                                           if (value == 0) {color = 'grey';}
                                                           if (value > 700) {color = 'red';}
                                                           if (value > 800) {color = 'blue';}
                                                           if (value > 900) {color = 'green';}     
                                                        }; break 
                                           case 'Load': {
                                                           var color = 'black';
                                                           if (value == 0) {color = 'grey';}
                                                           if (value > 90) {color = 'red';}
                                                           if (value > 95) {color = 'blue';}
                                                           if (value > 97) {color = 'green';}     
                                                        }; break 
                                           case 'Volt': {
                                                           var color = 'black';
                                                           if (value == 0) {color = 'grey';}
                                                           if (value > 1000) {color = 'red';}
                                                           if (value > 1100) {color = 'blue';}
                                                           if (value >= 1200) {color = 'black';}     
                                                        }; break 
                       }
                      return color;
                   },
                   RenderMiner : function (value, p, record) {
                                        
                                        var DataType = Ext.getCmp('data_type').value;
                                        var color = MinersDataClass.GetTempColor(value,DataType);
                                        return Ext.String.format('<font color={1}>{0}</font>',value,color);
                                                                },
                    InitFields : function ()
                                 {
                                    var const_fields = [];
                                    var miners_fields = [];
                                    var miners_column = [];
                                    var Miners = MinersDataClass.Miners;
                                    
                                    //Init const fields
                                    const_fields.push({name:'Date',dataIndex:'Date',type:'string',width:MinersDataClass.defaults.DateColumnWidth});
                                    for (key in Miners)
                                    {
                                     const_fields.push({name:Miners[key],dataIndex:'Miner'+Miners[key],type:'int'});
                                    }
                                    
                                    //Creating fileds and columns
                                    for (key in const_fields)
                                    {
                                       var field = {
                                                     name: const_fields[key].dataIndex, 
                                                     type: const_fields[key].type
                                                   }
                                       var column = {
                                                      text: '<small>'+const_fields[key].name+'</small>', 
                                                      dataIndex: const_fields[key].dataIndex, 
                                                      type: const_fields[key].type,
                                                      sortable: false,
                                                      width : const_fields[key].width || MinersDataClass.defaults.MinerColumnWidth,
                                                      align: 'left'
                                                    }
                                       if (const_fields[key].name === 'Date') 
                                           {
                                             column.renderer = Ext.util.Format.dateRenderer('d.m.Y H:i');
                                           }
                                           else
                                           {
                                               column.renderer = MinersDataClass.RenderMiner
                                           }
                                       
                                       miners_fields.push(field);    
                                       miners_column.push(column);    
                                    }
                                    return {'miners_fields': miners_fields,'miners_column': miners_column}
                                 }//InitFields
             }
    

    MinersData = new MinersDataClass.InitFields;
    Ext.define('MinersModel', {
        extend: 'Ext.data.Model',
        fields:  MinersData.miners_fields
    });                     

    var store = Ext.create('Ext.data.Store', {
        pageSize: 50,
        
        model: 'MinersModel',
        proxy: {
            type: 'jsonp',
            url: 'actions/grid_data.php',
            extraParams: {
                          action : 'get_temp_data',
                          ajax : 1,
                          DateTo: Math.round(new Date()/1000),
                          DateFrom:Math.round(new Date()/1000-60*60),
                          DataType:'Temp'
            },            

            reader: {root: 'topics', totalProperty: 'totalCount'},
            
  
        },
        listeners: {
                        load    : function(store, records, options){
                            var Miners = MinersDataClass.Miners
                            var MyData = [];
                            var MyCategories = [];
                            if (typeof(chart) !== 'undefined')
                                {
                                 var series = chart.series;
                                }
                            function GetVisible(pSeries,pIdx)
                            {
                                if (typeof(pSeries) !== 'undefined')
                                        {
                                           IsVisible = pSeries[pIdx].visible
                                           
                                           //IsVisible = true;
                                        }
                                        else
                                        {
                                            IsVisible = false;
                                        }
                                return  IsVisible;
                                        
                            }
                            idx = 0;
                            var TotalSum = Array(records.length);
                            for(var i=1; i<records.length; i++) {TotalSum[i] = 0}
                            for (miner in Miners)
                                {
                                    var ChartData = {name : Miners[miner], data : [], visible : GetVisible(series,idx)}
                                    for(var i=records.length-1; i>0; i--) 

                                    {
                                        ChartData.data.push(records[i].data['Miner'+Miners[miner]])
                                        TotalSum[i] = TotalSum[i]+records[i].data['Miner'+Miners[miner]];
                                    }    
                                MyData.push(ChartData);
                                idx++
                                }

                                 var ChartData = {name : 'Total', data : [], visible : GetVisible(series,idx)}
                                 for(var i=records.length-1; i>0; i--) 

                                    {
                                        ChartData.data.push(TotalSum[i])
                                    }    
                                MyData.push(ChartData);
                                
                                for(var i=records.length-1; i>0; i--) 
                                    {
                                        var myDate = new Date(records[i].data.Date);
                                        MyCategories.push(Ext.Date.dateFormat(myDate,'d.m H:i') );

                                    }    
                                InitChart(MyCategories,MyData);
                                   }
        }     
    });
    
    
    
    var states = Ext.create('Ext.data.Store', {
    fields: ['type', 'name'],
    data : [
        {"type":"Temp", "name":"Temp"},
        {"type":"Core", "name":"Core"},
        {"type":"Volt", "name":"Volt"},
        {"type":"Load", "name":"Load"}
    ]
});    

    var grid = Ext.create('Ext.grid.Panel', {  
                                                tbar : { items: [
                                                                    {
                                                                        xtype: 'datefield',
                                                                        id: 'myDateFrom',
                                                                        fieldLabel:'From',
                                                                        format: 'd.m.Y', 
                                                                        width:150,
                                                                        labelWidth: 30,
                                                                        value: new Date()
                                                                        
                                                                    }, 
                                                                        
                                                                    {
                                                                        xtype: 'timefield',
                                                                        id: 'myTimeFrom',
                                                                        format: 'H:i', 
                                                                        width:70,
                                                                        labelWidth: 0,
                                                                        value: new Date(new Date()-60*60*1000)
                                                                    },
                                                                    {
                                                                        xtype: 'datefield',
                                                                        format: 'd.m.Y', 
                                                                        id: 'myDateTo',
                                                                        fieldLabel:'  To',
                                                                        width:150,
                                                                        labelWidth: 30,
                                                                        value: new Date()
                                                                        
                                                                    },
                                                                    {
                                                                        xtype: 'timefield',
                                                                        format: 'H:i', 
                                                                        id: 'myTimeTo',
                                                                        width:70,
                                                                        labelWidth: 0,
                                                                        value: new Date()
                                                                    },
                                                                    {
                                                                        xtype: 'combobox',
                                                                        id:'data_type',
                                                                        width:130,
                                                                        labelWidth: 60,
                                                                        fieldLabel: 'Data type',
                                                                        store: states,
                                                                        queryMode: 'local',
                                                                        displayField: 'name',
                                                                        valueField: 'type',
                                                                        value:'Temp'
                                                                    },
                                                                    {
                                                                        xtype: 'button',
                                                                        frame : true,
                                                                        text: 'Refresh',
                                                                        handler: function() {
                                                                                                var DateFrom = new Date(Ext.getCmp('myDateFrom').value);
                                                                                                var DateTo = Ext.getCmp('myDateTo').value;
                                                                                                var TimeFrom = Ext.getCmp('myTimeFrom').value;
                                                                                                var TimeTo = Ext.getCmp('myTimeTo').value;
                                                                                                var DataType = Ext.getCmp('data_type').value;
                                                                                                
                                                                                                var d = new Date();
                                                                                                
                                                                                                var UnixDateFrom = Date.UTC(DateFrom.getFullYear(),DateFrom.getMonth(),DateFrom.getDate(),TimeFrom.getHours(),TimeFrom.getMinutes())/1000+d.getTimezoneOffset()*60;
                                                                                                var UnixDateTo = Date.UTC(DateTo.getFullYear(),DateTo.getMonth(),DateTo.getDate(),TimeTo.getHours(),TimeTo.getMinutes())/1000+d.getTimezoneOffset()*60;
                                                                                                
                                                                                                store.proxy.extraParams.DateFrom =UnixDateFrom;
                                                                                                store.proxy.extraParams.DateTo = UnixDateTo;
                                                                                                store.proxy.extraParams.DataType = DataType;
                                                                                                store.load();
                                                                                             }
                                                                    }
                                                                 ]
                                                },
                                                width: 1000,
                                                height: 430,
                                                store: store,
                                                frame : true,
                                                title : 'Miners data',
                                                collapsible:true,
                                                layout:'fit',
//                                                collapsed:true,
                                                columns:MinersData.miners_column,
                                                
                                                bbar: Ext.create('Ext.PagingToolbar', {
                                                    
                                                    items : [{
                                                                        xtype: 'numberfield',
                                                                        id: 'pageSize',
                                                                        fieldLabel: 'Rows at page',
                                                                        width:140,
                                                                        labelWidth: 80,
                                                                        step: 10,
                                                                        MinValue : 0,
                                                                        allowBlank: false,
                                                                        value: store.pageSize,
                                                                        listeners: {
                                                                                    'change': function(){
                                                                                      store.pageSize = Ext.getCmp('pageSize').value;
                                                                                    }
                                                                                  }

                                                                        
                                                                        
                                                                        
                                                                    }],
                                                    store: store,
                                                                                        displayInfo: true,
                                                                                        displayMsg: 'Displaying records {0} - {1} of {2}',
                                                                                        emptyMsg: "No records to display",
                                                                                    }),

                                                renderTo: 'data-grid'
                                            });
    store.loadPage(1);

    var ChartForm = Ext.create('Ext.form.Panel', {
        
        title : 'Miners chart',
        collapsible:true,
        //collapsed:true,
        frame: true,
        bodyPadding: 5,
        width: 1000,
        height: 460,

        items: [
            {
                height: 460,
                layout: 'fit',
                margin: '0 0 3 0',
                html: '<div id="chart_container">&nbsp;<div>'
            }],
        renderTo: 'chart-grid'
    });
function InitChart(MyCategories,MyData)
{
    chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart_container',
                        defaultSeriesType: 'line',
                        marginRight: 130,
                        marginBottom: 80
                    },
                    title: {
                        text: 'Miners  '+Ext.getCmp('data_type').value,
                        x: -20 //center
                    },
                    xAxis: {
                        labels: {
                                rotation: 90,
                                align : 'left',
                                style: {
                                        color: '#6D869F',
                                        //fontWeight: 'bold',
                                        fontSize: '80%',
                                        top:'100px'
                                       }
                        },
                        categories: MyCategories,
                    },
                    
                    yAxis: {
                        title: {
                            text: Ext.getCmp('data_type').value
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b<font color="maroon">'+ this.series.name +'</font></b><br/>'+
                                this.x +': <b><font color="green">'+ this.y +'</font></b>';
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 20,
                        borderWidth: 0
                    },
                    series: MyData

                });
}//InitChart
    
});


