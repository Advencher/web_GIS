function checkDate(record, updateURL, grid, rowsOnPage, changedRows, cancel, variable){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ url: '/checkDateStation', data: {'dataRow': {'id_station': record.StationID, 'date': dateToDBFormat(record)}}, method: 'POST' })
        .done(function () {
            console.log('changeCells: дата прошла проверку!');
            update(record, updateURL, grid, rowsOnPage, changedRows, cancel, variable);
        })
        .fail(function () {
            $.ajax({ url: '/minDateStation', data: {'dataRow': {'id_station': record.StationID}}, method: 'POST' })
                .done(function (data) {
                    alert('Данные не обновлены!\nМинимальная дата для станции ' + record.Station + ' - ' + data);
                    grid.edit(record.ID);
                })
                .fail(function () {
                    alert('Данные не обновлены!\nМинимальная дата для станции ' + record.Station + ' не получена.\nПовторите попытку или обратитесь к администратору!');
                    grid.edit(record.ID);
                });
        });

}