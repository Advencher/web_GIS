function btnAddStationDialog(){
    if (validateDataDialog()) {
        var name = document.getElementById('station_name').value;
        var id_water_area = $('[aria-selected="true"]')[0].attributes.value.value;
        var serial_number = document.getElementById('station_serial_number').value;
        var longitude = document.getElementById('station_longitude').value;
        var latitude = document.getElementById('station_latitude').value;

        //var dataRow = [{name: name, id_water_area: id_water_area, serial_number: serial_number, longitude:longitude, latitude:latitude}];
        var dataRow = {'station_name': name, 'id_water_area': id_water_area, 'station_serial_number': serial_number, 'longitude':longitude, 'latitude':latitude};
        console.log(dataRow);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/insert_station",
            data: {'dataRow' : dataRow} , method: 'POST'
        })
            .done(function (data) {
                console.log('HHHH' + data + '');
                dialog.close();
            })
            .fail(function (data){
                console.log(  data );
                alert('Что-то пошло не так. Обратитесь к администратору');
            });
    }

}

function validateDataDialog(){//@@
    return ( document.getElementById('station_name').validate() && document.getElementById('station_longitude').validate() &&  document.getElementById('station_latitude').validate());
}