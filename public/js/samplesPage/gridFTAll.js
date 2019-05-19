 //$(document).ready(function () {
    var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], variableFT = [];
    variableFT.z = -1;
    variableFT.pressedUndoButton = false;
    variableFT.rowAdded = false;
    variableFT.pageChanged = true;
    variableFT.pageSize = 20;
    var
        dataSource = '/samples_grid',
        insertURLFT = '/insert_sample',
        deleteURLFT = '/delete_sample',
        updateURLFT = '/update_sample',
        CBURLFT = '/stationsCB';

    function select2editor($editorContainer, value, record) {
        dataForEditor($editorContainer, value, record, CBURLFT, record.StationID, rowsOnPageFT);
    }
	
    gridFT = $('#grid').grid({

        dataSource: dataSource,
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: { mode: 'command'},
        columns: [
            { field: 'ID', width: 44 , sortable: true},
            { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID',  editor: select2editor  , sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
            { field: 'Date', title:'Дата', type: 'date', editor: true , sortable: true, format: 'dd/mm/yyyy', width: 110},
            { field: 'Time', title:'Время', editor: true , width: 70},
            { field: 'UTC' , width: 40},
            { field: 'Longitude', title:'Долгота', width: 60},
            { field: 'Latitude', title:'Широта', width: 60},
            { field: 'SerialNumber', title:'Серийный номер', editor: true, sortable: true, width: 150},
            { field: 'Comment', title:'Комментарий', editor: true, width: 150},
            { field: 'Info', title: 'П',  width: 44, type: 'icon', icon: 'fa fa-envira',
                events: {'click': function (e) {
						if(confirm('Перейти к пигментам пробы ' + e.data.id + '?'))
						{
							$("#tab a").eq(2).tab('show');
							download('/pigments_tab', {'sid':e.data.id});
						}
                    }
                }
            },
            { field: 'InfoPhyto', title: 'Ф',  width: 44, type: 'icon', icon: 'fa fa-tencent-weibo fa-2x',
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
        dataBound(rowsOnPageFT, variableFT, gridFT, records);
        //deleteCBDataDataBound(rowsOnPageFT, '#grid', 1); //Если из edit не вышел, но обновил страницу, изменил число строк на странице, перешел на другую страницу
    });

    gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
        deleteCBData(id, rowsOnPageFT, '#grid', 1);
    });

    gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки
        console.log('@@rowDataChanged@@');
        deleteCBData(id, rowsOnPageFT, '#grid', 1); //Сработает rowCancelChanged 0_0 0_0 0_0 0_0 0_0
        //var tempVariable = [];
        //tempVariable.temp = -1;
        //tempVariable.k = -1;
        //findRecord(rowsOnPageFT, changedRowsFT, record, variableFT, tempVariable);
        //Если прошла проверка
        update(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });

    gridFT.on('rowRemoving', function (e, $row, id, record) {
        rowRemowing(record, deleteURLFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT);
    });

    gridFT.on('pageSizeChange', function (e, newSize) {
        pageSizeChange(variableFT, newSize);
    });

    $('#btnAdd').click(function() {//@@
        addRow('#grid', insertURLFT, gridFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT, null);
    });

    $('#btnUndo').click(function() {
        btnUndo(updateURLFT, insertURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });



   /* function findRecord(rowsOnPage, changedRows, record, variable, tempVariable){//Если после Validate надо восстановить значение
        //if (!variable.pressedUndoButton) {
            tempVariable.temp = variable.z;
            //tempVariable.k = -1;
            variable.z = -1;
            var  i;
            for (i = 0; i < changedRows.length; i++)//Есть ли уже запись о изменениях строки с индентификатором id
            {
                if (record.ID === changedRows[i].ID) {
                    variable.z = i;
                    break;
                }
            }

            if (variable.z === -1) {//нет
                for (i = 0; i < rowsOnPage.length; i++) {
                    if (rowsOnPage[i].ID === record.ID) {//Значит ищем по записям на текущей странице
                        tempVariable.k = i;
                        break;
                    }
                }
            }

            if (variable.z !== -1)//Есть
            {
                if (checkForCBNull(record, changedRows, variable, false))
                    grid.updateRow(record.ID, record);
            }

            else {
                if (checkForCBNull(record, changedRows, variable, true))
                    grid.updateRow(record.ID, record);
            }
       //}
    }*/


    $('#btnAddStation').click(function() {
        btnAddStation();
    });

    $('#btnAddStationDialog').click(function() {
        btnAddStationDialog();
    });
 //});