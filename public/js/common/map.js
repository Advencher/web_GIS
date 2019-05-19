/**
 *            [Летняя практика: Yandex Maps API]
 */

/**
 * Интересная идея:
 * По нажатию ctrl идет удаление behavior drag у карты и
 * мы можем по левой кнопке НЕ двигать картой, что дает
 * нам возможность выделять карту, таким образом мы 
 * ПРИ зажатом ctrl выделить нужный участок карты и работать 
 * с этим
 * ПРИ отпущенном ctrl behavior drag меняется на enable
 */

 /**
  * Рефактор может быть таким:
  * По дефолту в myCollection задать инициализирующие опции
  * preset: twirl#blueIcon
  * 
  * А для SelCollection - preset: islands#redIcon
  * тем самым избавившись от кода, отвечающий за изменение стилей
  * при перемещении балунов из одной коллекции в другую
  */

/** [RESOLVED/?]
 * Также баг с неправильным отображением станций
 * В selectedAreas нужно записывать не какие-то номера айдишники
 * а реальные id которые потом используются в jQuery файла mainpage.blade
 */
var startCalendarText = undefined;
var endCalendarText = undefined;
var getCalendarField = document.getElementById('get-calendar-field');


var myMap,
    myPlacemark,
    myCollection, 
    SelCollection,
    myButton,
    toggleSelectionButton,
    diagramMap,
    diagramMapButton,
    diagramCollection,
    diagramPlacemark,
    diagramMapListBox,
    diagramMapListBoxLayout,
    diagramMapListBoxItems,
    diagramMapListBoxItemLayout;
var mapPlacemarks = [];

var mapStationsAjax = document.getElementById('mapStations-ajax');

var mapInitialize = function() {

  var calendarField = document.getElementById('reportrange'); //div календаря
  var calendarText = calendarField.getElementsByTagName('span')[0].innerHTML; // Почему не querySelector? Потому что get* - живая колекция, а это нам нужно для работы кнопки

  startCalendarText = calendarText.slice(0, calendarText.indexOf(' - '));
  endCalendarText = calendarText.slice(calendarText.indexOf(' - ') + 3);
  console.log('Данные в reportrange:', calendarText);
  console.log('\t startCalendarText:', startCalendarText);
  console.log('\t endCalendarText:', endCalendarText);

  var startDate;
  var endDate;

  startDate = startCalendarText;
  endDate = endCalendarText;

  // startDate = moment(startCalendarText, 'LL').format().slice(0, startCalendarText.indexOf('T'));
  // endDate = moment(endCalendarText, 'LL').format().slice(0, endCalendarText.indexOf('T'));

  console.log('Данные в запрос startDate / endDate:');
  console.log('\t', startDate);
  console.log('\t', endDate);
  // if (startDateCalendar && endDateCalendar) {
  //   console.log('Данные календаря в удобном виде:', startDateCalendar, endDateCalendar);
  //   startDate = startDateCalendar;
  //   endDate = endDateCalendar;
  // } else {
  //   console.log('Данных нет, вывод двух дат из calendarText');
  //   console.log('\t', startCalendarText);
  //   console.log('\t', endCalendarText);
  //   startDate = startCalendarText;
  //   endDate = endCalendarText;
  // }

  /**
   * FETCH
   * Подставить сюда маршрут к контроллеру, который будет отдавать данные 
   */
  console.log(`php/DBhandler.php?start=${startDate}&end=${endDate}`);
  // console.log('Moment:', moment(startDate, 'LL').format());


  fetch(`php/DBhandler.php?start=${encodeURIComponent(startDate)}&end=${encodeURIComponent(endDate)}`)
    .then(response => {
      return response.json();
    })
    .then(response => {
      if (myMap) {
        myMap.destroy();
      }

      if (diagramMap) {
        diagramMap.destroy();
        $('#map-diagram').css("display", "none");
      }

      ymaps.ready(init);
      ymaps.ready(initDiagramMap);
      

      // phpDataObject больше не нужен
      var phpDataArray = response;

      console.log('phpDataArray: ', phpDataArray);

      /**
       * Так же этот код не нужен, если от сервера придет массив с уникальными значениями
       * Тогда можно будет удалить от НАЧАЛА до КОНЦА
       */
      // НАЧАЛО
      var newArray = uniqueData(phpDataArray);
      console.log('newArray: ', newArray);

      phpDataArray = newArray;
      //КОНЕЦ


      // ---------------------------------------------------------

      /* 
      * Функции 
      */

      // Создание уникального массива данных
      function uniqueData(arr) {
        var dataObject = {};
        
        for (var i = 0; i < arr.length; i++) {
          dataObject[arr[i].latitude + " " + arr[i].longitude] = arr[i];
        }

        return Object.values(dataObject);
      }

      // Инициализация
      function init() {
        myMap = new ymaps.Map("map", {
          center: [60.15619551, 28.73452422], 
          zoom: 8
        });
        
        myMap.behaviors
          .disable(['dblClickZoom', 'multiTouch', 'rightMouseButtonMagnifier']);


        myCollection = new ymaps.GeoObjectCollection(); // коллекция для всех меток
        SelCollection = new ymaps.GeoObjectCollection(); // коллекция для выделенных меток

        myButton = new ymaps.control.Button({
          data: {
            content: 'Снять выделение'
          },
          options: {
            maxWidth: [150, 150, 178]
          }
        }); 
        // --- Вспомогательные функции ---


        // Внимание, важная функция:
        // В ней хранятся данные все о нашей метке в properties.balloonContentBody
        // Как минимум можно взять данные оттуда и передавать в фильтр или куда 
        // нужно по странице
        var getPointData = function (_waterAreaName, _idStation, _ltd, _lng, _name) {
                return {
                  //   balloonContentBody: '<strong>' + _waterAreaName + ':' + _name + '</strong> : <em>'
                  //                      + _idStation + '</em><br>' + _ltd + " : " + _lng,
                    waterAreaName: _waterAreaName,
                    idStation: _idStation,
                    ltd: _ltd,
                    lng: _lng,
                    valueName: _name // 
                };
            },
            getPointOptions = function () {
                return {
                    preset: 'twirl#blueIcon'
                };
            }
        
        // --- Добавление меток из БД ---

        // Создаем метки и пихаем в коллекцию myCollection
        for (var i = 0; i < phpDataArray.length; i++) {
          myPlacemark = new ymaps.Placemark([phpDataArray[i].latitude, phpDataArray[i].longitude],
            {
              waterAreaName: phpDataArray[i].water_area_name,
              idStation: phpDataArray[i].id_station,
              ltd: phpDataArray[i].latitude,
              lng: phpDataArray[i].longitude,
              valueName: phpDataArray[i].station_name,
              hintContent: `${phpDataArray[i].water_area_name}:${phpDataArray[i].station_name}`
            },
            // getPointData(phpDataArray[i].water_area_name, phpDataArray[i].id_station, phpDataArray[i].latitude, phpDataArray[i].longitude, phpDataArray[i].station_name), 
            {
              preset: "twirl#blueIcon"
            }
            // ^ выше можно вернуть функцию getPointOptions, которая делает то же самое, оставил
            // из-за какого-то нелепого бага, который решился отключением режима разработчика
          );
          myPlacemark.selected = false;
          
          myCollection.add(myPlacemark);
        }
        
        // Сразу же добавляем коллекцию на карту
        myMap.geoObjects.add(myCollection);
        myMap.geoObjects.add(SelCollection); 

        var storage = ymaps.geoQuery(myCollection);


        
        // Готовим выделяющий прямоугольник, но пока не показываем
        SelectionBox = new ymaps.Rectangle([[60.15619551, 28.73452422],[60.15619551, 28.73452422]]);
        SelectionBox.options.set({"strokeColor":"#0000ff", 
          "fillColor":"#0000ff", 
          "fillOpacity":0.2, 
          "visible":false, 
          hasBalloon:false, 
          hasHint: false
        });
        
        

        /**
         * Справка по двум нижним частям кода: добавление событий на 
         * myCollection и SelCollection
         * У нас по умолчанию есть myCollection, в котором по умолчанию
         * находятся все метки, которые мы достали из БД и отобразили при загрузке
         * Далее мы можем выделить их, тем самым добавляя в специальную коллекцию
         * SelCollection. Тем самым нам не нужно иметь проверку на то, выделен ли
         * элемент или нет, а просто навесить обработчики событий на определенные 
         * коллекции (myCol... / SelCol...), что будет почти равнозначно 
         * if (placemark.selected) проверке
         */

        /**
         * ВАРИАНТ №1
         */
        
        var body = document.body,
            isCtrlPressed = false;
        body.onkeydown = async function(event) {
          // console.log(event.target);
          if (event.keyCode === 17 || event.charCode === 17) {
            // console.log('keydown === ctrl');
            myMap.behaviors
              .disable('drag');
            isCtrlPressed = true;
          }
        };

        body.onkeyup = function(event) {
          // console.log(event.target);    
          if (event.keyCode === 17 || event.charCode === 17 && isCtrlPressed) {
            // console.log('keyup === ctrl');      
            myMap.behaviors
              .enable('drag');
            isCtrlPressed = false;
          }
        };

        

        // Выделяем метку, нажатием по ней
        myCollection.events.add('click', function(e) {

          console.log('clicked myCollection: ', e.get('target'));
          console.log('myCol selected:', e.get('target').selected);

          // Если метка не выбрана
          // 1. Добавляем нажатую метку в список
          e.get('target').options.set('preset', 'islands#redIcon');
          $('.selectStation')
              .append($('<option></option>')
                  .attr('value', e.get('target').properties.get('idStation'))
                  .text(e.get('target').properties.get('waterAreaName') + ':' + e.get('target').properties.get('valueName')));
          SelCollection.add(e.get('target'));
          
          // Log Begin
          /*...*/ console.log('===========================================');        
          /*...*/ console.log('SelCollection:', SelCollection);
          /*...*/ console.log('myCollection:', myCollection);
          /*...*/ console.log('e.get(target):', e.get('target').properties.get('idStation'));
          /*...*/ console.log('===========================================');                
          // Log End

          // 2. Обновляем .selectStation, чтобы в него добавилась метка
          $('.selectStation option').each(function() {
            selectedStations.push($( this ).attr('value'));
          });
          $('.selectStation').val(selectedStations).change();

          console.log('selStat selected: ',selectedStations);

          // Становится true
          e.get('target').selected = true; 
          

        });

        // Убираем выделение метки
        SelCollection.events.add('click', function(e) {

          /*...*/ console.log('===========================================');        
          /*...*/ console.log('selected SelCollection:', e.get('target'));
          /*...*/ console.log('length:', SelCollection.getLength());    
          /*...*/ console.log('SelCol selected:', e.get('target').selected);
          /*...*/ console.log('===========================================');        

          // 1. Находим и добавляем
          e.get('target').options.set('preset', 'twirl#blueIcon');
          myCollection.add(e.get('target'));
          
          // 2. Обновляем .selectStation
          /*...*/ console.log('===========================================');   
          /*...*/ console.log('selStat before splice: ', selectedStations);
          let selectIndex = selectedStations.indexOf(e.get('target').properties.get('idStation'));
          selectedStations.splice(selectIndex, 1);
          /*...*/ console.log('selStat after splice: ', selectedStations);
          /*...*/ console.log('===========================================');  
          
          // 3. Удаляем из select ненужные уже options, тк мы сняли с них выделение
          $('.selectStation option[value='+e.get('target').properties.get('idStation')+']').remove();    
          $('.selectStation').val(selectedStations).change();

          // Становится false
          e.get('target').selected = false;    
          
        });

        /**
         * Выделение 
         */

        SelectionBox.events.add('mouseup', function (e) {
          console.log('### MOUSEUP / CLICK ###');
          // Когда прямоугольник охватит всю нужную зону,
          // щелкаем по нему и начинается проверка, какие метки в него попали

          // Получить координаты прямоугольника
          console.log('SelectionBox coords: ', SelectionBox.geometry.getCoordinates());

          var objectsInsideBox = storage.searchInside(SelectionBox);
          objectsInsideBox.setOptions('preset', 'islands#redIcon'); //.options.set('preset', "islands#redIcon");
          objectsInsideBox.each(function(geoObj) {
            $('.selectStation')
              .append($("<option></option>")
                .attr("value", geoObj.properties.get("idStation"))
                .text(geoObj.properties.get("waterAreaName") + ":" + geoObj.properties.get("valueName")));
            SelCollection.add(geoObj);
            // storage.remove(geoObj);
          });
          
          // myCollection.each(function (geoObj) {
          //   if (SelectionBox.geometry.contains(geoObj.geometry.getCoordinates())) {

          //     console.log(geoObj.properties.get("idStation") + ": ", geoObj.geometry.getCoordinates());

          //     geoObj.options.set('preset', "islands#redIcon"); //если попала - меняем пресет
          //     $('.selectStation')
          //       .append($("<option></option>")
          //         .attr("value", geoObj.properties.get("idStation"))
          //         .text(geoObj.properties.get("waterAreaName") + ":" + geoObj.properties.get("valueName")));
              
          //     SelCollection.add(geoObj); //и переносим в коллекцию выделенных меток

          //     // Log Begin
          //     // /*...*/ console.log('===========================================');                
          //     // /*...*/ console.log('SelCollection: ', SelCollection);
          //     // /*...*/ console.log('geoObj: ', geoObj);
          //     // /*...*/ console.log('===========================================');                
          //     // Log End

              
          //   }
          // });

          SelectionBox.options.set("visible",false); // Прямоугольник больше не нужен, убираем его
          myMap.geoObjects.remove(SelectionBox);

          $('.selectStation option').each(function() {
              selectedStations.push($( this ).attr('value'));
          });
          $('.selectStation').val(selectedStations).change();

          // Log Begin
          /*...*/ console.log('SelCollection:', SelCollection.getLength());
          /*...*/ console.log('myCollection:', myCollection.getLength());
          /*...*/ console.log('selStat selected: ', selectedStations);
          // Log End
          
        });
        
        // При щелчке по карте открываем крошечный прямоугольник в координатах щелчка
        /**
         * Идея: выделять при dblclick
         * Приемущества: 
         *  + не нужно обходить API Яндекс Карт
         *  + скорее всего будет работать на мобильных устройствах
         * Недостатки: 
         *  - то, что мы выделяем не задерживанием, а парой кликов 
         * 
         * При переделывании в dblclick закомментировать строки с body
         */
        // myMap.events.add('dblckick', function (e) {
        myMap.events.add('mousedown', function (e) {
          if (isCtrlPressed) { // isCtrlPressed
            console.log('### mousedown ###');
            var coords = e.get('coords');

            myMap.geoObjects.add(SelectionBox); 
            
            SelectionBox.geometry.setCoordinates( [coords, coords] );
            SelectionBox.options.set("visible",true);
          }
          
        });
        

        // При движении мышки по карте проверяем - видим ли наш прямоугольник
        // Видим ли наш прямоугольник значит то, что мы зажали ЛКМ и начинаем
        // выделять какую-то область, соответственно, если мы выделяем какую-то
        // область - мы видим наш прямоугольник
        // 
        // если да, координаты верхнего левого угла оставляем неизменные, 
        // второй угол сдвигается в координаты мыши,
        // если нет, ничего не делаем
        myMap.events.add('mousemove', function (e) {
          // console.log('### MOUSEMOVE ###');
          var coords = e.get('coords');
          // console.log(coords);
          if (SelectionBox.options.get("visible")) {

            var firstPoint = SelectionBox.geometry.getCoordinates();
            //console.log(firstPoint)
            SelectionBox.geometry.setCoordinates( [firstPoint[0], coords] );
          }

        });
        // --------------

        /**
         * 
         *  --- Кнопки ---
         * 
         */

        // Кнопка "снять выделение"
        myMap.controls.add(myButton, {float: "left"});
        myButton.events.add('press', function() {
          /**
           * Небольшая справка по коллекциям:
           * Объект может храниться ТОЛЬКО в одной коллекции,
           * при добавлении объекта в другую коллекцию, он 
           * удаляется из исходной
           */
          
          while (SelCollection.getLength()) {
            var object = SelCollection.get(0);

            object.options.set('preset', "twirl#blueIcon");
            object.selected = false;
            myCollection.add(object);
          }
          
          console.log('myCollection length after: ', myCollection.getLength());
          console.log('SelCollection length after: ', SelCollection.getLength());

          $('.selectStation').empty();
          $('.selectStation').val(selectedStations).change();
          
        });

        // Кнопка "Выделить"
        toggleSelectionButton = new ymaps.control.Button({
          data: {
            content: "Выделить",
            title: "Выделение прямоугольной области"
          }
        });

        myMap.controls.add(toggleSelectionButton, { float: "left" });
        toggleSelectionButton.events
          .add('select', function() {
            myMap.behaviors
              .disable('drag');
            isCtrlPressed = true;
          })
          .add('deselect', function() {
            myMap.behaviors
              .enable('drag');
            isCtrlPressed = false;
          });
        // ---

        // Кнопка "Показать данные" -- TBD
        diagramMapButton = new ymaps.control.Button({
          data: {
            content: "Показать данные",
            title: "Показать диаграмму данных о фитопланктоне на карте"
          }, 
          options: {
            maxWidth: [150, 150, 178]
          }
        });

        myMap.controls.add(diagramMapButton, { float: "left" });
        diagramMapButton.events
          .add('click', function() {
            $('#map-diagram').css("display", "block");
            
            diagramCollection.removeAll();

            /**
             * FETCH
             * Подставить сюда маршрут к получению json с данными для диаграммы
             * Полученный json должен быть вида:
             * [
             *   {
             *     id: station_id,
             *     фитоданные: количество (вес),
             *     фитоданные: количество (вес),
             *     фитоданные: количество (вес),
             *     ...
             *   },
             *   
             *   {
             *     id: station_id,
             *     фитоданные: количество (вес),
             *     фитоданные: количество (вес),
             *     фитоданные: количество (вес),
             *     ...
             *   },
             *   ...
             * ]
             * Где station_id - айдишник станции, у которой эти данные есть
             * 
             * Вывод данных заключается в переборе каждого объекта по ключам
             * Затем, записи каждого поля ключ:значения в диаграмму 
             * ИСКЛЮЧАЯ поле id
             * Таким образом получим data у placemark и выглядеть конструктор будет:
             * {
             *   [latitude, longitude],
             *   data: [
             *     { weight: количество (вес) },
             *     { weight: количество (вес) },
             *     ...
             *   ],
             *   {
             *     id: station_id
             *   }
             * }
             * 
             * Закомментированный ниже код: то, как будет обрабатываться данный json,
             * а код под ним можно убрать от НАЧАЛА до КОНЦА
             */
            
            // fetch('')
            //   .then(response => {
            //     return response.json();
            //   })
            //   .then(response => {
            //     for (var i = 0; i < response.length; i++) {
            //       var id;
            //       for (var j = 0; phpDataArray.length; j++) {
            //         if (phpDataArray[j].id_station === response[i].id) {
            //           id = j;
            //           break;
            //         }
            //       }

            //       var newData = [];
            //       for (var key in response[i]) {
            //         if (key == 'id') {
            //           continue;
            //         }
            //         newData.push({ weight: response[i][key], color: '#FF0202' })
            //       }
            //       diagramPlacemark = new ymaps.Placemark(
            //         [phpDataArray[id].latitude, phpDataArray[id].longitude], 
            //         {
            //           data: newData
            //         }
            //       );

            //       diagramCollection.add(diagramPlacemark);
            //     }
            //   });
            
            // Добавляем по айдишнику из массива так как при добавлении
            // из баллунов получится что мы их перемещаем, а не копируем
            // НАЧАЛО
            for (var i = 0; i < selectedStations.length; i++) {
              var station_i = +getStationId(selectedStations[i], phpDataArray);

              diagramPlacemark = new ymaps.Placemark(
                [phpDataArray[station_i].latitude, phpDataArray[station_i].longitude], 
                {
                  data: [
                    { weight: +phpDataArray[station_i].id_station, color: '#FF0202' }
                  ]
                }
              );
              
              diagramCollection.add(diagramPlacemark);
            }
            // КОНЕЦ
          });

        // ---
      
      }

      function getStationId(id, phpDataArray) {
        for (var i = 0; i < phpDataArray.length; i++) {
          if (phpDataArray[i].id_station === id) {
            return i;
          }
        }
      }

      /**
       * Карта для отображения данных
       * #map-diagram
       * 
       * Наверное это придется выделить в другой js файл, а может и нет;
       * разницы нет, так как они разделяют одну и ту же область видимости
       */

      function initDiagramMap() {
        diagramMap = new ymaps.Map("map-diagram", {
          center: [60.15619551, 28.73452422], 
          zoom: 8,
          controls: ['zoomControl']
        });

        diagramMap.behaviors
          .disable(['dblClickZoom', 'multiTouch', 'rightMouseButtonMagnifier']);

        diagramCollection = new ymaps.GeoObjectCollection({}, {
          iconLayout: 'default#pieChart'
        });

        // Добавляем список
        diagramMapListBoxLayout = ymaps.templateLayoutFactory.createClass(
          "<button id='my-listbox-header' class='btn btn-success dropdown-toggle' data-toggle='dropdown'>" +
              "{{data.title}} <span class='caret'></span>" +
          "</button>" +
          // Этот элемент будет служить контейнером для элементов списка.
          // В зависимости от того, свернут или развернут список, этот контейнер будет
          // скрываться или показываться вместе с дочерними элементами.
          "<ul id='my-listbox'" +
              " class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu'" +
              " style='display: {% if state.expanded %}block{% else %}none{% endif %}; top: auto; left: auto; padding: 10px; margin-top: 10px;'></ul>", {

          build: function() {
              // Вызываем метод build родительского класса перед выполнением
              // дополнительных действий.
              diagramMapListBoxLayout.superclass.build.call(this);

              this.childContainerElement = $('#my-listbox').get(0);
              // Генерируем специальное событие, оповещающее элемент управления
              // о смене контейнера дочерних элементов.
              this.events.fire('childcontainerchange', {
                  newChildContainerElement: this.childContainerElement,
                  oldChildContainerElement: null
              });
          },

          // Переопределяем интерфейсный метод, возвращающий ссылку на
          // контейнер дочерних элементов.
          getChildContainerElement: function () {
              return this.childContainerElement;
          },

          clear: function () {
              // Заставим элемент управления перед очисткой макета
              // откреплять дочерние элементы от родительского.
              // Это защитит нас от неожиданных ошибок,
              // связанных с уничтожением dom-элементов в ранних версиях ie.
              this.events.fire('childcontainerchange', {
                  newChildContainerElement: null,
                  oldChildContainerElement: this.childContainerElement
              });
              this.childContainerElement = null;
              // Вызываем метод clear родительского класса после выполнения
              // дополнительных действий.
              diagramMapListBoxLayout.superclass.clear.call(this);
          }
        }),

        // Также создадим макет для отдельного элемента списка.
        diagramMapListBoxItemLayout = ymaps.templateLayoutFactory.createClass(
          "<li><a style='font-size: 16px;'>{{data.content}}</a></li>"
        ),

        // Создадим пункты выпадающего списка
        diagramMapListBoxItems = [
          new ymaps.control.ListBoxItem({
              data: {
                  content: 'Первый',
                  phyto: 1
              }
          }),
          new ymaps.control.ListBoxItem({
              data: {
                  content: 'Второй',
                  phyto: 2
              }
          }),
          new ymaps.control.ListBoxItem({
              data: {
                  content: 'Третий',
                  phyto: 3
              }
          })
        ],

        // Теперь создадим список, содержащий 2 пункта.
        diagramMapListBox = new ymaps.control.ListBox({
          items: diagramMapListBoxItems,
          data: {
              title: 'Параметр'
          },
          options: {
              // С помощью опций можно задать как макет непосредственно для списка,
              layout: diagramMapListBoxLayout,
              // так и макет для дочерних элементов списка. Для задания опций дочерних
              // элементов через родительский элемент необходимо добавлять префикс
              // 'item' к названиям опций.
              itemLayout: diagramMapListBoxItemLayout
          }
        });

        diagramMapListBox.events.add('click', function (e) {
          // Получаем ссылку на объект, по которому кликнули.
          // События элементов списка пропагируются
          // и их можно слушать на родительском элементе.
          var item = e.get('target');
          // Клик на заголовке выпадающего списка обрабатывать не надо.
          if (item != diagramMapListBox) {
            console.log(item.data.get('content'), item.data.get('phyto'));
          }
        });

        

        diagramMap.geoObjects.add(diagramCollection); 
        diagramMap.controls.add(diagramMapListBox, { float: 'left' }); 
        
      }
    })
    .catch(error => console.log(error));
};


mapStationsAjax.addEventListener('click', function() {

  if (mapToggle) {

    $('#map').css("display", "block");
    $('#mapStations-ajax').html('Скрыть карту');

    mapInitialize();
    mapToggle = false;

  } else {

    $('#map').css("display", "none");
    $('#mapStations-ajax').html('Отметить на карте');
    
    mapToggle = true;

  }
  
});



// Отладочная кнопка, вскорем удалим
// getCalendarField.addEventListener('click', () => {
//   // Дополняем функционал календаря, чтобы всё работало супер
//   var calendarField = document.getElementById('reportrange'); //div календаря
//   var calendarText = calendarField.getElementsByTagName('span')[0].innerHTML;
//   startCalendarText = calendarText.slice(0, calendarText.indexOf(' - '));
//   endCalendarText = calendarText.slice(calendarText.indexOf(' - ') + 3);
//   console.log('Данные в reportrange:', calendarText);
//   console.log('startCalendarText:', startCalendarText);
//   console.log('endCalendarText:', endCalendarText);


//   if (startDateCalendar && endDateCalendar) {
//     console.log('Данные календаря в удобном виде:', startDateCalendar, endDateCalendar);
//   } else {
//     console.log('Данных нет, вывод двух дат из calendarText');
//     console.log('\t', startCalendarText);
//     console.log('\t', endCalendarText);
//   }
// });
// console.log('test', startCalendarText, endCalendarText);