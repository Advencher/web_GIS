function goToExtraDialog(e) {
    var el = document.getElementById('extraDialog');
    $.ajax({
        url: "/waterPurityCB",
        cache: false
    })
        .done(function (data) {
            $("#mydropdownWaterPurity").html(data);

            $.ajax({
                url: "/saprobityCB",
                cache: false
            })
                .done(function (data) {
                    $("#mydropdownSaprobity").html(data);
                    //console.log(data);
                    $('#id_phyto').val(e.data.record.ID);
                    $('#station_longitude').val(e.data.record.Longitude);
                    $('#station_latitude').val(e.data.record.Latitude);
                    $('#upholding_sample_time').val(e.data.record.UpholdingTime);
                    $('#concentrated_sample_volume').val(e.data.record.ConcentratedSampleVolume);
                    $('#cameras_viewed_number').val(e.data.record.CamerasViewedNumber);
                    document.getElementById('mydropdownWaterPurity').setAttribute('selected', e.data.record.WaterPurityID);
                    document.getElementById('mydropdownSaprobity').setAttribute('selected', e.data.record.SaprobityID);
                    el.toggle();
                })
                .fail(function (data) {
                    alert('Что-то пошло не так со списком сапробностей. Обратитесь к администратору');
                });
            console.log(data);
        })
        .fail(function (data) {
            alert('Что-то пошло не так со списком классов чистоты воды. Обратитесь к администратору');
        });
}