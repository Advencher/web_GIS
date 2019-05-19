@@@@
@@@@
@@@@ ЧТО-ТО ПОЛЕЗНОЕ

----  Вроде, пофиксили checkForCBNull. Возможна пустышка

---- deleteCBdata
T.к.  в gijgo в строке 6826 (кнопка отмена прожимаетмя во время загрузки данных в таблицу), то надо проверять на существование удаляемых данных

---- gridFT.on('rowCancelChanged', function (e, id, record){}); нужна только если есть comboBox

---- gridFT.on('pageSizeChange') используется, только при добавлении

@@@@
@@@@
@@@@ КАКИЕ Ф-ИИ(СКРИПТЫ) ИСПОЛЬЗУЮТСЯ В ФУНКЦИЯХ(СКРИПТАХ) ||_ ф-ия: какие в ней используются _||

1) gijgo
        нужен всем 0_0

2) dataForEditor:
                 dataForEditorFail

3) dataForUpdate:
                 splitString (Не обязательно, видимо)
                 dateToDBFormat (Не обязательно, видимо)

4) dataBound:
             daleteCBDataDataBound
             colourImage (Не обязательно, исп пустышку)

5) update:
          dataForUpdate
          checkForCBNull (если отсутствует CB в таблице, то используем пустышку)
          checkFullStack
          updateGrid (если после обновление данных в Базе Данных ничего в таблице на странице обновлять не надо, то используем пустышку)

6) addRow:
          dataForInsertAndDelete (dataForInsert, dataForInsertDG)
          checkFullStack

7) rowRemoving:
               dataForInsertAndDelete (dataForDelete)
               checkFullStack

8) cancelDeleteRow:
                   dataForInsertAndDelete (dataForCancelDelete)

9) gridFTEdit:
              dataForEditor
              dataBound
              deleteCBData
              update

10) gridFTAll:
             dataForEditor
             dataBound
             deleteCBData
             update
             addRow
             rowRemowing
             pageSizeChange

11) btnUndo:
           update
           cancelDeleteRow

12) checkDate:(после нажатия на обновить в таблице, для Samples)
             dateToDBFormat
             update

@@@@
@@@@
@@@@ ПОРЯДОК ЗАГРУЗКИ СКРИПТОВ ||_ если неск для одной позиции, то порядок внутри позиции не важен _||

1) gijgo

---- Для просмотра

2) gridFTWatch

---- Для просмотра, редактирования

2) dataForEditorFail, splitString, dateToDBFormat, daleteCBDataDataBound, colourImage
3) dataForEditor, dataBound, deleteCBData, checkFullStack, checkForCBNull, dataForUpdate, updateGrid
4) update
5) checkDate или аналоги
6) gridFTEdit

9) btnUndo

---- Для просмотра, редактирования и удаления

2) dataForEditorFail, splitString, dateToDBFormat, daleteCBDataDataBound, colourImage
3) dataForEditor, dataBound, deleteCBData, checkFullStack, checkForCBNull, dataForUpdate, dataForInsertAndDelete, pageSizeChange, updateGrid, btnAddStation
4) update, addRow, rowRemoving, btnAddStationDialog
5) checkDate или аналоги
6) gridFTAll
7) cancelDeleteRow

12) btnUndo

@@@@
@@@@
@@@@ ЧТО БЫ СДЕЛАТЬ

...

$('#btn1').on('click', function () {//для изменения dataSource. Если фильтр будет //@@
            //function setDataSource() {
            console.log(gridFT.data().dataSource);
            gridFT.data().dataSource = 'daddas';
            console.log(gridFT.data().dataSource);
            //grid.data().dataSource;
            //}
        });

          $('#updateP').click(download('/samples'));
                function download(URL){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: URL,
                        method: 'GET',

                    })
                        .done(function (data) {
                            $('#content2').html(data);
                        })
                        .fail(function (data){
                            console.log(  data );
                            alert('Что-то пошло не так. Обратитесь к администратору');
                        });
                }
            });

CREATE RULE view_new_samples_update2 AS ON UPDATE TO view_new_samples DO INSTEAD UPDATE samples SET date = new.date, comment = new.comment, serial_number = new.serial_number, id_station = (SELECT station.id_station FROM (station LEFT JOIN water_area ON ((station.id_water_area = water_area.id_water_area))) WHERE (((station.name)::text = (new.station_name)::text) AND ((water_area.name)::text = (new.water_area_name)::text))) WHERE (samples.id_sample = new.id_sample);

CREATE RULE view_stations_insert AS ON INSERT TO view_stations DO INSTEAD (INSERT INTO station (id_station, id_water_area, name, serial_number)
VALUES (((SELECT max(station.id_station) AS max FROM station) + 1), new.id_water_area, new.station_name, new.station_serial_number);
INSERT INTO station_coordinates (id_station_coord, id_station, date, longitude, latitude, longitude_str, latitude_str)
VALUES (((SELECT max(station_coordinates.id_station_coord) AS max FROM station_coordinates) + 1), (SELECT max(station.id_station) AS max FROM station),
    '1000-05-31 00:00:00+02:30:17'::timestamp with time zone, new.longitude, new.latitude, new.longitude_str, new.latitude_str)
RETURNING (SELECT station.id_station FROM station WHERE (station.id_station = (SELECT max(station.id_station) AS max FROM station))),
    (SELECT station.name FROM station WHERE (station.id_station = (SELECT max(station.id_station) AS max FROM station))), (
    SELECT station.serial_number FROM station WHERE (station.id_station = (SELECT max(station.id_station) AS max FROM station))),
    (SELECT station.id_water_area FROM station WHERE (station.id_station = (SELECT max(station.id_station) AS max FROM station))),
    (SELECT water_area.name FROM water_area WHERE
    ((SELECT max(station.id_station) AS max FROM station) = water_area.id_water_area)), station_coordinates.id_station_coord, station_coordinates.date,
    station_coordinates.longitude, station_coordinates.latitude, station_coordinates.longitude_str, station_coordinates.latitude_str; );

 public function __construct()
    {
        $this->middleware('auth');
    }