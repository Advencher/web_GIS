function updateGrid(grid, changedRows, record, variable) {
    $.ajax({ url: '/stationInfo', data: {'dataRow': {'id_sample': record.ID}}, method: 'POST' })
        .done(function (data) {
            console.log('update/stationCoord');
            console.log(data);
            // changedRows[variable.z].Date = data.date;
            // changedRows[variable.z].Time = data.time;
            changedRows[variable.z].UTC = data.utc;
            changedRows[variable.z].Longitude = data.longitude;
            changedRows[variable.z].Latitude = data.latitude;
            console.log(changedRows[variable.z]);
            grid.updateRow(record.ID, $.extend(true, {},  changedRows[variable.z]));
        })
        .fail(function () {
            alert('Широта и долгота не получены.\nОбновите таблицу позже.')
        });
}