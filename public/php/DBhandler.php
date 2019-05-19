<?php
// Подтягиваем параметры параметры подключения
require_once 'DBConnect.php'; 

// Подключаемся по параметрам к бд

$conn = pg_connect("host = $host dbname = $dbname user =  $name password = $password") 
  or die('Could not connect: ' . pg_last_error());

if(!$conn) echo " Что-то пошло не так, проверь соединение с БД ";

// Формируем запрос
// Так как это заглушка, я не надеюсь на то, что я составил этот запрос правильно, не ругайте, ребят :D

if ($_GET['start']) {
  if ($_GET['start'] != "undefined" && $_GET['end'] != "undefined") {
    // $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples"; 
    $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples where sample_date between '" .$_GET['start']."'::timestamp and '" .$_GET['end']. "'::timestamp"; //::timestamp
  } else {
    $query = "select distinct latitude, longitude, water_area_name, id_station, station_name from vw_samples"; 
  }
  
} else if ($_GET['areas']) {
  $query = "select * from view_stations";
}





$result = pg_query($query) or die(pg_last_error());

$rows = array();


// Добавляем в массив данные из бд
while ($arrayRow = pg_fetch_object($result)) {
  $rows[] = $arrayRow;
}


$jsonString = json_encode($rows);
// echo json_encode($_GET['start']);
// echo json_encode(array($_GET['end']));
echo $jsonString;
pg_close($conn);

?>

