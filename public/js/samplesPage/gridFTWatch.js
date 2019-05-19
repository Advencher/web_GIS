//$(document).ready(function () {
    var gridFT,
        dataSource = '/samples_grid';
    gridFT = $('#grid').grid({

        dataSource: dataSource,
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        columns: [
            { field: 'ID', width: 44, sortable: true},
            { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID', sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
            { field: 'Date', title:'Дата', type: 'date', sortable: true, format: 'dd/mm/yyyy', width: 110},
            { field: 'Time', title:'Время', width: 70},
            { field: 'UTC' , width: 40},
            { field: 'Longitude', title:'Долгота' , width: 60},
            { field: 'Latitude', title:'Широта' , width: 60},
            { field: 'SerialNumber', title:'Серийный номер',  sortable: true, width: 150},
            { field: 'Comment', title:'Комментарий', width: 150},
            { field: 'Info', title: 'П',  width: 32, type: 'icon', icon: 'fa fa-envira',
                events: {'click': function (e) {
                        $("#tab a").eq(2).tab('show');
						download('/pigments_tab', {'sid':e.data.id});
                    }
                }
            },
            { field: 'InfoPhyto', title: 'Ф',  width: 40, type: 'icon', icon: 'fa fa-tencent-weibo fa-2x',
                events: {'click': function (e) {
                        window.open('/onePhytoMain?id_sample='+e.data.record.ID+'&station='+e.data.record.Station + '&id_station='+e.data.record.StationID + '&date='+ e.data.record.Date + '&time=' + e.data.record.Time + '&utc=' + e.data.record.UTC  )

                    }
                }
            },
            { field: 'CountPho', hidden : true},
            { field: 'CountPhy', hidden : true}

        ],
        //autoBind: false,
        pager: { limit: 20 }
    });

    gridFT.on('dataBound', function (e, records, totalRecords) {
        var row, Pho, Phy;
        for (var i = 0; i < records.length; i++) {
            row = $('#grid').find('[data-position=' + (i+1) + ']').eq(0).children();
            Pho = row.eq(9);
            Phy = row.eq(10);
            if (records[i].CountPho > 0)
                Pho.css('color','#00e600');
            else
                Pho.css('color','#000000');
            if (records[i].CountPhy > 0)
                Phy.css('color','#00e600');
            else
                Phy.css('color','#000000');
        }
    });
//});
