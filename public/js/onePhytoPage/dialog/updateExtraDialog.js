function updateExtraDialog() {
    if (validateThis()) {
        var id_phyto = document.getElementById('id_phyto').value;
        var upholding_sample_time = document.getElementById('upholding_sample_time').value;
        var concentrated_sample_volume = document.getElementById('concentrated_sample_volume').value;
        var cameras_viewed_number = document.getElementById('cameras_viewed_number').value;
        var id_saprobity = $('#mydropdownSaprobity').find('[aria-selected="true"]')[0].attributes.value.value;
        var id_class_of_purity = $('#mydropdownWaterPurity').find('[aria-selected="true"]')[0].attributes.value.value;
        var pageRefresh = $('#grid').find('[data-role="page-refresh"]');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/update_phyto2', data: {
                'dataRow': {
                    'id_phyto': id_phyto,
                    'upholding_sample_time': upholding_sample_time,
                    'concentrated_sample_volume': concentrated_sample_volume,
                    'cameras_viewed_number': cameras_viewed_number,
                    'id_saprobity': id_saprobity,
                    'id_class_of_purity': id_class_of_purity
                }
            }, method: 'POST'
        })
            .done(function (data) {

                alert('успешно изменено');
                pageRefresh.click();

            })
            .fail(function (data) {

                alert('Что-то пошло не так c редактированием доп. данных');
            });
    }
}

function validateThis (){
    return (document.getElementById('upholding_sample_time').validate() & document.getElementById('concentrated_sample_volume').validate() & document.getElementById('cameras_viewed_number').validate());
}