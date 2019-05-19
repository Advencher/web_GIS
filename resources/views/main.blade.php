@extends('layouts.papa')

@section('content')
<!-- Page Content -->
@include('includes.filter')
{{--<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">МЕСТО ДЛЯ ФИЛЬТРА</h1>
            <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
            <ul class="list-unstyled">
                <li>Bootstrap 4.1.1</li>
                <li>jQuery 3.3.1</li>
            </ul>
        </div>
    </div>
</div>--}}
<br/>
<ul class="nav nav-tabs" id="tab">
    <li class="nav-item">
        <a class="nav-link active show" href="#content">Пробы</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#content">Фитопланктон</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#content">Фотосинтетические пигменты</a>
    </li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade active show" id="content" style="margin-left: 100px; margin-right: 100px">
        <br/>
    </div>

</div>


@endsection
@can('create', App\Admin::class)
    @section('navbar')
    <a class="nav-link" href="../admin" role="button" >Панель администрирования
        <span class="sr-only">(current)</span>
    </a>
    @endsection
@endcan

@section('script')
@include('includes.scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--Дополнительные иконки-->
{{--<script type="text/javascript">
    //https://itchief.ru/lessons/bootstrap-3/100-bootstrap-3-dynamic-tabs
    $(document).ready(download('/samples', null));


</script>--}}

{{--<script type="text/javascript">
    $(document).ready(function () {
        //Учитываем, что на одной странице несколько таблиц
        var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], variableFT = [];
        variableFT.z = -1;
        variableFT.pressedUndoButton = false;
        variableFT.rowAdded = false;
        variableFT.pageChanged = true;
        variableFT.pageSize = 5;
        var
            insertURLFT = '/insert_sample',
            deleteURLFT = '/delete_sample',
            updateURLFT = '/update_sample',
            maxIdURLFT = '/maxIdSamples',
            CBURLFT = 'stationsCB';

        function dataForEditorFail(rowsOnPage, record) {//зависит от положения comboBox в таблице(для разных разная)
            var pos;//если не соед, то в CB значение hidden становится поч
            for(var i = 0; i < rowsOnPage.length; i++){
                if (rowsOnPage[i].ID === record.ID){
                    pos = i + 1;
                    break;
                }
            }
            if ($('[data-position=' + pos + ']')[0].childNodes[1].childNodes[0])
                $('[data-position=' + pos + ']')[0].childNodes[1].childNodes[0].removeAttribute('style');//.toString() - Не обязательно
            alert('Не удалось получить список станций! Обратитесь к администратору!');
        }

        function dataForEditor($editorContainer, value, record, CBURL, focusField, rowsOnPage){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({ url: CBURL, method: 'GET' ,async:false})
                .done(function (data) {
                    console.log('111111111');
                    console.log(record);
                    var select = $( data );
                    $editorContainer.append(select);
                    select.select2({ width: '100%'}).val(focusField).trigger('change');//чтобы фокус на текущую станцию был
                })
                .fail(function () {
                    dataForEditorFail(rowsOnPage, record);
                });
        }

        function select2editor($editorContainer, value, record) {
            dataForEditor($editorContainer, value, record, CBURLFT, record.StationID, rowsOnPageFT);
        }
       /* grid = $('#grid').grid({
            dataSource: data,
            inlineEditing: { mode: 'command' },
            columns: [
                { field: 'Name', editor: true },
                { field: 'CountryName', type: 'dropdown', editField: 'CountryID', editor: select2editor },
                { field: 'DateOfBirth', type: 'date', editor: true, format: 'dd.mm.yyyy' },
                { field: 'IsActive', title: 'Active?', type:'checkbox', editor: true, mode: 'editOnly', width: 80, align: 'center' }
            ]
        });*/

        gridFT = $('#grid').grid({

            dataSource: '/test2',
            uiLibrary: 'bootstrap4',
            primaryKey: 'ID',
            inlineEditing: { mode: 'command' },
            columns: [
                { field: 'ID', width: 44 },
                { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID',  editor: select2editor  , sortable: true},//{ dataSource: '/stationsCB', valueField: 'id' }
                { field: 'Date', title:'Дата', type: 'date', editor: true , sortable: true},
                { field: 'Time', title:'Время', editor: true , width: 80},
                { field: 'UTC' , width: 40},
                { field: 'SerialNumber', title:'Серийный номер', editor: true },
                { field: 'Longitude', title:'Долгота' , width: 60},
                { field: 'Latitude', title:'Широта' , width: 60},
                { field: 'Comment', title:'Комментарий', editor: true },
				{ field: 'Info', title: 'П',  width: 32, type: 'icon', icon: 'fa fa-envira',
					events: {'click': function (e) {
						alert('Пигменты по пробе с id ' + e.data.id);
						}
					}
				}

            ],
            //autoBind: false,
            pager: { limit: 5 }
        });


        $('#btn1').on('click', function () {//для изменения dataSource. Если фильтр будет //@@
            //function setDataSource() {
            console.log(gridFT.data().dataSource);
            gridFT.data().dataSource = 'daddas';
            console.log(gridFT.data().dataSource);
            //grid.data().dataSource;
            //}
        });

        function dataForCancelDelete(row){
            var rowForInsert = {};
            rowForInsert.id_sample = row.ID;
            rowForInsert.id_station = row.StationID;
            rowForInsert.date = row.Date;
            rowForInsert.comment = row.Comment;
            rowForInsert.serial_number = row.SerialNumber;
            return rowForInsert;
        }

        function dataForInsert(data){
            var rowForInsert = {};
            rowForInsert.id_sample = data;
            rowForInsert.id_station = '1';
            rowForInsert.date = '2015-12-12 00:00:00+04';
            rowForInsert.comment = '';
            rowForInsert.serial_number = '00/00';
            return rowForInsert;
        }

        function dataForInsertDG(data){
            var rowForInsert = {};
            rowForInsert.ID = data;
            rowForInsert.StationID = '1';
            rowForInsert.Station = '5, Невская губа';
            rowForInsert.Date = '2015-12-12';
            rowForInsert.Time = '00:00:00';
            rowForInsert.UTC = '+03';
            rowForInsert.Comment = '';
            rowForInsert.SerialNumber = '00/00';
            rowForInsert.Longitude = '30.22';
            rowForInsert.Latitude = '59.89';
            return rowForInsert;
        }

        function cancelDeleteRow(row, insertURL, grid, cancel, variable){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({ url: insertURL, data: {'dataRow': dataForCancelDelete(row)}, method: 'POST' })
                .done(function () {
                    cancel.pop();
                    console.log('USPEH! ');
                    console.log('row');
                    console.log(row);
                    variable.pageChanged = false;
                    //Проверка о соотв текущей выборке??
                    grid.addRow($.extend(true, {}, row));//строка сама доб в rowsOnPage, т.к. сработает событие dataBound
                    //if($('[data-role="page-last"]')[0].hasAttribute('disabled') === false)//Не известно куда добавится
                        //$('[data-role="page-last"]')[0].click(); //если страница последняя, не переходим
                })
                .fail(function () {
                    alert('Не добавлено в БД! Обратитесь к администратору!');
                });
        }

        function checkFullStack(del, cancel, rowsOnPage, changedRows, variable){
            if(cancel.length === 10) {//Ограничение в десять записей
                var p = -1, find = 0;
                if (!del) {//ДЛЯ УДАЛЕНИЯ НЕ НАДО, Т.К. ОБНОВЛЯЕТСЯ СТРАНИЦА
                    if (cancel[0].do === 'update') {//только если нижняя запись update
                        for (var i = 0; i < rowsOnPage.length; i++) {
                            if (rowsOnPage[i].ID === cancel[0].data.ID) {
                                p = i;
                                break;
                            }
                        }
                    }
                }
                cancel.shift();//Удаляем нижнюю запись
                if (cancel[0].do === 'update') {//только если нижняя запись update
                    for (i = 0; i < cancel.length; i++)// Проверяем есть ли в *cancel*  запись  с ID *changedRows[0]*
                    {
                        if (cancel[i].data.ID === changedRows[0].ID && cancel[i].do === 'update') {
                            find = 1;
                            break;
                        }
                    }
                    if (find === 0) {//Если нет, значит удаляем запись из *changedRows*
                        if (!del) {//ДЛЯ УДАЛЕНИЯ НЕ НАДО, Т.К. ОБНОВЛЯЕТСЯ СТРАНИЦА
                            if (p !== -1)
                                rowsOnPage[p] = $.extend(true, {}, changedRows[0]);
                        }
                        changedRows.shift();
                        variable.z = variable.z - 1;
                    }
                }
            }
        }

        function addRow(maxIdURL, insertURL, grid, cancel, rowsOnPage, changedRows, variable){
            console.log('DASDAS');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({ url: maxIdURL, method: 'GET' })
                .done(function (data) {
                    data = (parseInt(data)+1).toString(); //максимальный айдишник
                    $.ajax({ url: insertURL, data: {'dataRow': dataForInsert(data)}, method: 'POST' })
                        .done(function () {
                            var row;
                            console.log()
                            checkFullStack(false, cancel, rowsOnPage, changedRows, variable);

                            row = dataForInsertDG(data);
                            cancel.push({do:'insert', data: $.extend(true, {}, row)});
                            console.log('cancel');
                            console.log(cancel);
                            console.log('USPEH! ');
                            //rowsOnPage.push($.extend(true, {}, row));//не надо, т.к. добавится( след командой выполнится событие dataBound)
                            if(grid.count(true)% variable.pageSize !== 0){
                                variable.pageChanged = false;
                                variable.rowAdded = true;
                            }
                            grid.addRow($.extend(true, {}, row));
                            if($('[data-role="page-last"]')[0].hasAttribute('disabled') === false) {
                                variable.rowAdded = true;
                                $('[data-role="page-last"]')[0].click();

                            } //если страница последняя, не переходим
                            console.log('USPEH! ' + data + ' ');

                        })
                        .fail(function () {
                            alert('Не добавлено в БД! Обратитесь к администратору!');
                        });
                })
                .fail(function () {
                    alert('Не найден максимальный ID! Обратитесь к администратору!');
                });
        }

        $('#btnAdd').click(function() {
            addRow(maxIdURLFT, insertURLFT, gridFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT)
        });

        $('#btnUndo').click(function() {
            if (cancelFT.length > 0) {
                console.log('@@@cancel@')
                if (cancelFT[cancelFT.length - 1].do === "update") {//Отмена обновления
                    variableFT.pressedUndoButton = true;
                    update_with_ajax(cancelFT[cancelFT.length - 1].data, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
                }
                else if (cancelFT[cancelFT.length - 1].do === "delete") {
                    cancelDeleteRow(cancelFT[cancelFT.length - 1].data, insertURLFT, gridFT, cancelFT, variableFT);
                }
                else if (cancelFT[cancelFT.length - 1].do === "insert") {
                    variableFT.pressedUndoButton = true;
                    gridFT.removeRow(cancelFT[cancelFT.length - 1].data.ID);
                }
            }
        });

        function dataBound(rowsOnPage, variable, grid, records){
            if (variable.pageChanged === true)
                rowsOnPage.length = 0;
            else variable.pageChanged = true;


            console.log($('[data-position=' + 1 + ']')[0]);
            for (var i = 0; i < records.length; i++) {
                rowsOnPage.push($.extend(true, {}, records[i]));
            }
            if (variable.rowAdded === true){
                grid.edit(records[records.length - 1].ID);
                variable.rowAdded = false;
            }

            console.log(rowsOnPage);
        }

        gridFT.on('dataBound', function (e, records, totalRecords) {//@@
            dataBound(rowsOnPageFT, variableFT, gridFT, records);
        });

        function deleteCBData(id, rowsOnPage, gridName, posOfCB){
            var pos = 1;
            for(var i = 0; i < rowsOnPage.length; i++){
                if (rowsOnPage[i].ID === id){
                    pos = i + 1;
                    break;
                }
            }
            try{
                $(gridName).find('[data-position=' + pos + ']')[0].childNodes[1].childNodes[posOfCB].remove();
            }
            catch(Exception){
                console.log('deleteCBData. Не удалось!');
            }
            // if ($('#grid').find($('[data-position=' + pos + ']'))[0].childNodes[1].childNodes[posOfCB]) {//T.к.  в gijgo 6826
            //     console.log($('#grid').find($('[data-position=' + pos + ']'))[0].childNodes[1].childNodes[posOfCB]);
            //     $('[data-position=' + pos + ']')[0].childNodes[1].childNodes[posOfCB].remove();//.toString() - Не обязательно
            // }
        }

        gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
            deleteCBData(id, rowsOnPageFT, '#grid', 1);
        });


        //разделение имени станции и имени акватории, разделитель - ,пробел
        function splitString(stringToSplit, separator) {
            var arrayOfStrings = stringToSplit.split(separator);

            console.log('Оригинальная строка: "' + stringToSplit + '"');
            console.log('Разделитель: "' + separator + '"');
            console.log('Массив содержит ' + arrayOfStrings.length + ' элементов: ' + arrayOfStrings.join(' / '));

            return arrayOfStrings;
        }

        function checkForCBNull(record, changedRows, variable,onPage){
            if (record.StationID == null && !onPage) {
                record.StationID = changedRows[variable.z].StationID;
                record.Station = changedRows[variable.z].Station;
                return true;
            }
            if (record.StationID == null && onPage) {
                record.StationID = changedRows[variable.z].StationID;
                record.Station = changedRows[variable.z].Station;
                return true;
            }
            return false;
        }

        function dataForUpdate(record){
            // место
            console.log('Имя станции: "' + record.ID + '"');
            var place = splitString(record.Station, ', ');
            var station_name = place[0];
            var water_area_name = place[1];

            //собираем дату в правильный формат
            var reorder = splitString(record.Date, '/')
            var month = reorder [0];
            var day = reorder[1];
            var year = reorder [2];
            var date = year + '-' + month + '-' + day + ' ' + record.Time + record.UTC;

            console.log('Имя станции: "' + station_name + '"');
            console.log('Акватория: "' + water_area_name + '"');

            var rowForUpdate = {};
            rowForUpdate.id_sample = record.ID;
            //!!!!!!!!!!!!!!!!!
            //rowForInsert.id_station = '1';
            rowForUpdate.station_name = station_name;
            rowForUpdate.water_area_name = water_area_name;
            rowForUpdate.date = date;
            rowForUpdate.comment = record.Comment;
            rowForUpdate.serial_number = record.SerialNumber;
            return rowForUpdate;
        }

        function update_with_ajax(record, updateURL, grid, rowsOnPage, changedRows, cancel, variable){
            //if (confirm('Send to server?')) {
                if (!variable.pressedUndoButton) {
                    var  i, temp = variable.z,
                    k = -1;
                    variable.z = -1;


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
                                k = i;
                                break;
                            }
                        }
                    }

                    if (variable.z !== -1)//Есть
                    {
                        if (checkForCBNull(record, changedRows, variable, false))
                            grid.updateRow(record.ID, record);
                        // if (record.StationID === null) {//Устранение недочетов авторов библиотеки
                        //     record.StationID = changedRows[z].StationID;
                        //     record.Station = changedRows[z].Station;
                        //     grid.updateRow(record.ID, record);
                        // }
                    }

                    else {
                        if (checkForCBNull(record, changedRows, variable, true))
                            grid.updateRow(record.ID, record);
                        // if (record.StationID === null) {//Устранение недочетов авторов библиотеки
                        //     record.StationID = rowsOnPage[k].StationID;
                        //     record.Station = rowsOnPage[k].Station;
                        //     grid.updateRow(record.ID, record)
                        // }
                    }
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                 $.ajax({ url:  updateURL, data: {'dataRow': dataForUpdate(record) }, method: 'POST' })
                    .done(function (data) {
                        if(!variable.pressedUndoButton) {
                            checkFullStack(false, cancel, rowsOnPage, changedRows, variable);
                            if (variable.z !== -1)//Есть
                            {
                                if (checkForCBNull(record, changedRows, variable, false))
                                    grid.updateRow(record.ID, record);
                                // if (record.StationID === null) {//Устранение недочетов авторов библиотеки
                                //     //record.StationID = changedRows[z].StationID;
                                //     //record.Station = changedRows[z].Station;
                                //     grid.updateRow(id, record);//!!ЕСЛИ НЕ ПОЛУЧИЛОСЬ ТОЖЕ UPDATE???????
                                // }
                                cancel.push({
                                    do: "update",
                                    data: $.extend(true, {}, $.extend(true, {}, changedRows[variable.z]))
                                });//Вставляем предыдущее значение
                                changedRows[variable.z] = $.extend(true, {}, record);//Обновляем текущее значение
                            }
                            else {
                                if (checkForCBNull(record, changedRows, variable, true))
                                    grid.updateRow(record.ID, record);
                               /* if (record.StationID === null) {//Устранение недочетов авторов библиотеки
                                    //record.StationID = rowsOnPage[k].StationID;
                                    //record.Station = rowsOnPage[k].Station;
                                    grid.updateRow(id, record);
                                }*/
                                cancel.push({
                                    do: "update",
                                    data: $.extend(true, {}, $.extend(true, {}, rowsOnPage[k]))
                                });//Вставляем найденное значение
                                changedRows.push($.extend(true, {}, record));//Вставляем текущее значение
                                variable.z = changedRows.length - 1;
                            }
                            console.log('@@VDANE@@');
                            console.log(data);
                            $('#response').json(data);
                            //grid.reload();
                        }
                        else{
                            var find = 0;
                            var n = -1;
                            for (var i = 0; i < rowsOnPage.length; i++) {
                                if (rowsOnPage[i].ID === cancel[cancel.length - 1].data.ID) {//Если данная запись есть на странице, то изменяем ее еще и на странице. Ну или обновляем страницу. Как пойдет
                                    changedRows[variable.z] = $.extend(true, {}, cancel[cancel.length - 1].data);
                                    grid.updateRow(cancel[cancel.length - 1].data.ID, changedRows[variable.z]);
                                    n = i;
                                    break;
                                }
                            }
                            cancel.pop();//Удаляем запись из *cancel*
                            for (i = 0; i < cancel.length; i++)// Проверяем есть ли в *cancel*  запись  с ID *changedRows[changedRows.length - 1]*
                            {
                                if (cancel[i].data.ID === changedRows[changedRows.length - 1].ID && cancel[i].do === 'update') {
                                    find = 1;
                                    break;
                                }
                            }
                            if (find === 0) {//Если нет, значит удаляем запись из *changedRows*
                                if (n !== -1)
                                    rowsOnPage[n] = $.extend(true, {}, changedRows[changedRows.length - 1]);
                                changedRows.pop();
                                console.log("Я тут");
                            }

                            console.log("ОТМЕНА ИЗМЕНЕНИЯ");
                            console.log("Значение строки стало");
                            console.log(changedRows);
                            console.log("cancel");
                            console.log(cancel);
                            for (i = 0; i < changedRows.length; i++)//Новое значение z
                            {
                                if (changedRows[i].ID === cancel[cancel.length - 1].data.ID) {
                                    variable.z = i;
                                    break;
                                }
                            }
                            variable.pressedUndoButton = false;
                        }
                    })
                    .fail(function () {
                        if (!variable.pressedUndoButton){
                            if (variable.z === -1) {
                                grid.updateRow(id, $.extend(true, {}, rowsOnPage[k]));//Если не удачно, то возвращаем, что было
                            }
                            else {
                                grid.updateRow(id, $.extend(true, {}, changedRows[variable.z]));//Если не удачно, то возвращаем, что было
                            }
                            variable.z = temp;//восстанавливаем значение z
                        }
                        alert('Failed to update.');
                        console.log(data);
                        $('#response').json(data);
                    });
            //}
        }


        gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки
            console.log('@@rowDataChanged@@');

            update_with_ajax(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
            deleteCBData(id, rowsOnPageFT, '#grid', 1);

        });

        function dataForDelete(data){
            var rowForDelete = {};
            rowForDelete.id_sample = data.ID;
            return rowForDelete;
        }

        function rowRemowing(record, deleteURL, cancel, rowsOnPage, changedRows, variable){
            if (confirm('Are you sure?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({ url: deleteURL, data: { 'dataRow': dataForDelete(record) }, method: 'POST' })
                    .done(function () {
                        if(!variable.pressedUndoButton) {
                            checkFullStack(true, cancel, rowsOnPage, changedRows, variable);
                            cancel.push({do: 'delete', data: $.extend(true, {}, record)});
                        }
                        else{
                            cancel.pop();
                            variable.pressedUndoButton = false;
                        }
                        console.log('cancel');
                        console.log(cancel);
                        alert('Успешно удалено');
                    })
                    .fail(function () {
                        alert('Failed to delete.');
                    });
            }
        }

        gridFT.on('rowRemoving', function (e, $row, id, record) {
            rowRemowing(record, deleteURLFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT)
        });

        $('#btnAddStation').click(function() {//@@
            $.ajax({
                url: "/waterAreasCB",
                cache: false
            })
                .done(function (data) {
                    $("#mydropdown").html(data);
                    console.log(data);
                    dialog.open();
                })
                .fail(function (data){
                    alert('Что-то пошло не так. Обратитесь к администратору');
            });

        });

        function validateDataDialog(){//@@
            var aa = document.getElementById('station_longitude').validate();
            console.log(aa);
            document.getElementById('station_latitude').validate();
        }

        $('#btnAddStationDialog').click(function() {//@@
            validateDataDialog();
            // var name = document.getElementById('station_name').value;
            // var id_water_area = $('[aria-selected="true"]')[0].attributes.value.value;
            // var serial_number = document.getElementById('station_serial_number').value;
            // var longitude = document.getElementById('station_longitude').value;
            // var latitude = document.getElementById('station_latitude').value;
            //
            // //var dataRow = [{name: name, id_water_area: id_water_area, serial_number: serial_number, longitude:longitude, latitude:latitude}];
            // var dataRow = {'station_name': name, 'id_water_area': id_water_area, 'station_serial_number': serial_number, 'longitude':longitude, 'latitude':latitude};
            // console.log(dataRow);
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $.ajax({
            //     url: "/insert_station",
            //     data: {'dataRow' : dataRow} , method: 'POST'
            // })
            //     .done(function (data) {
            //         console.log('HHHH' + data + '');
            //         dialog.close();
            //     })
            //     .fail(function (data){
            //         console.log(  data );
            //         alert('Что-то пошло не так. Обратитесь к администратору');
            //     });

        });

        function copy(toCopy) {//Будет меняться для каждой таблицы. НЕ НУЖНА)))
            var newRow = {};
            newRow.ID = toCopy.ID;
            newRow.StationID = toCopy.StationID;
            newRow.Station = toCopy.Station;
            newRow.Comment = toCopy.Comment;
            newRow.Date = toCopy.Date;
            newRow.Time = toCopy.Time;
            newRow.UTC = toCopy.UTC;
            newRow.SerialNumber = toCopy.SerialNumber;
            newRow.Longitude = toCopy.Longitude;
            newRow.Latitude = toCopy.Latitude;
            return newRow;
        }

        function pageSizeChange(variable, newSize){
            variable.pageSize = newSize;
            console.log('pageSizeChange ' + variable.pageSize +' ')
        }

        gridFT.on('pageSizeChange', function (e, newSize) {
            pageSizeChange(variableFT, newSize);
        });
    });
</script>--}}
@endsection