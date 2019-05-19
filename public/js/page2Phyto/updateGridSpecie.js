function updateGridSpecie(grid, changedRows, record, variable) {
    $.ajax({ url: '/speciesInfo', data: {'dataRow': {'id_species': record.IDSpecies}}, method: 'POST' })
        .done(function (data) {
            changedRows[variable.z].GroupName = data.name;
            console.log(changedRows[variable.z]);
            grid.updateRow(record.ID, $.extend(true, {},  changedRows[variable.z]));
        })
        .fail(function () {
            alert('Название группы не получено, обновите таблицу вручную.')
        });
}