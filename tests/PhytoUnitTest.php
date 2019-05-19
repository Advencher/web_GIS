<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class PhytoUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;


    public function testAllPhytos(){

        //тест для контроллера фитопланктона (отображение всех проб)
        $this->getActualOutput();

        $response = $this->action('GET','ViewNewPhytos1Controller@ShowPhytos',
            [
                'sortBy' => 'ID',
                'limit' => '15'
            ]);

        $this->assertEquals(200,$response -> status());


        $phytos = DB::table('view_new_phytos1')->select('*')->orderBy('id_phyto')->paginate(15);

        foreach  ($phytos as  $phyto) {
            $phyto->longitude = round($phyto->longitude, 2);
            $phyto->latitude = round($phyto->latitude, 2);
            $phyto->time = substr($phyto->date, 11, 8);
            $phyto->utc = substr($phyto->date, 19, 3);
            $day = (int) substr($phyto->date, 8, 2);
            $month = (int) substr($phyto->date, 5, 2);
            $year = (int) substr($phyto->date, 0, 4);
            $phyto->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }

        $i = 0;
        $correct = true;
        foreach ($response->original->phytos as $phyto_current ){


            If (!($phyto_current->id_sample == $phytos[$i]->id_sample &&
                $phyto_current->id_phyto == $phytos[$i]->id_phyto &&
                $phyto_current->id_station == $phytos[$i]->id_station &&
                $phyto_current->station_name == $phytos[$i]->station_name &&
                $phyto_current->water_area_name == $phytos[$i]->water_area_name &&
                $phyto_current->id_horizon == $phytos[$i]->id_horizon &&
                $phyto_current->horizon == $phytos[$i]->horizon &&
                $phyto_current->upholding_sample_time == $phytos[$i]->upholding_sample_time &&
                $phyto_current->concentrated_sample_volume == $phytos[$i]->concentrated_sample_volume &&
                $phyto_current->cameras_viewed_number == $phytos[$i]->cameras_viewed_number &&
                $phyto_current->total == $phytos[$i]->total &&
                $phyto_current->total_species == $phytos[$i]->total_species &&
                $phyto_current->total_biomass == $phytos[$i]->total_biomass &&
                $phyto_current->total_percent == $phytos[$i]->total_percent &&
                $phyto_current->biomass_percent == $phytos[$i]->biomass_percent &&
                $phyto_current->id_class_of_purity == $phytos[$i]->id_class_of_purity &&
                $phyto_current->water_purity_name == $phytos[$i]->water_purity_name &&
                $phyto_current->id_saprobity == $phytos[$i]->id_saprobity)

            ) {

                $correct = false;
            }

            $i++;


        }


        $this->assertEquals(true, $correct);


    }


    public function testOnePhyto(){

        //тест для отображения одной пробы

        $this->getActualOutput();


        $id_sample = 1;


            while (sizeof($phytos = DB::table('view_new_phytos1')->select('*')->where('id_sample', $id_sample)->orderBy('id_phyto')->paginate(15)) == 0 || $id_sample > 200) {
                $id_sample++;

            }


        $response = $this->action('GET','ViewNewPhytos1Controller@ShowOnePhyto',
            [
                'sortBy' => 'ID',
                'limit' => '15',
                'id_sample' => $id_sample
            ]);

        $this->assertEquals(200,$response -> status());


        foreach  ($phytos as  $phyto) {
            $phyto->longitude = round($phyto->longitude, 2);
            $phyto->latitude = round($phyto->latitude, 2);
            $phyto->time = substr($phyto->date, 11, 8);
            $phyto->utc = substr($phyto->date, 19, 3);
            $day = (int) substr($phyto->date, 8, 2);
            $month = (int) substr($phyto->date, 5, 2);
            $year = (int) substr($phyto->date, 0, 4);
            $phyto->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }

        $i = 0;
        $correct = true;
        foreach ($response->original->phytos as $phyto_current ){

            If (!($phyto_current->id_sample == $phytos[$i]->id_sample &&
                $phyto_current->id_phyto == $phytos[$i]->id_phyto &&
                $phyto_current->id_station == $phytos[$i]->id_station &&
                $phyto_current->station_name == $phytos[$i]->station_name &&
                $phyto_current->water_area_name == $phytos[$i]->water_area_name &&
                $phyto_current->id_horizon == $phytos[$i]->id_horizon &&
                $phyto_current->horizon == $phytos[$i]->horizon &&
                $phyto_current->upholding_sample_time == $phytos[$i]->upholding_sample_time &&
                $phyto_current->concentrated_sample_volume == $phytos[$i]->concentrated_sample_volume &&
                $phyto_current->cameras_viewed_number == $phytos[$i]->cameras_viewed_number &&
                $phyto_current->total == $phytos[$i]->total &&
                $phyto_current->total_species == $phytos[$i]->total_species &&
                $phyto_current->total_biomass == $phytos[$i]->total_biomass &&
                $phyto_current->total_percent == $phytos[$i]->total_percent &&
                $phyto_current->biomass_percent == $phytos[$i]->biomass_percent &&
                $phyto_current->id_class_of_purity == $phytos[$i]->id_class_of_purity &&
                $phyto_current->water_purity_name == $phytos[$i]->water_purity_name &&
                $phyto_current->id_saprobity == $phytos[$i]->id_saprobity)

            ) {

                $correct = false;
            }
            echo $i, "\n";
            $i++;
        }
        $this->assertEquals(true, $correct);
    }



    public function testPhytoMaxID()
    {

        $this->getActualOutput();
        //тест максимального ID в базе данных

        $id_phyto_max = DB::table('view_new_phytos1')->max('id_phyto');


        $response = $this->action('GET','ViewNewPhytos1Controller@maxID');

        $c_phyto_max_id = $response->original;

        echo "\nТЕСТ: max ID for phyto samples\n"," CORRECT = ",$id_phyto_max, " TESTED = ", $c_phyto_max_id, "\n";

        $this->assertEquals($id_phyto_max, $c_phyto_max_id);


    }

    public function testCreatePhyto()
    {

        $this->getActualOutput();

        $response = $this->action('GET','ViewNewPhytos1Controller@maxID');

        $phyto_max_id = $response->original;
        $phyto_max_id++;

        $response = $this->action('POST','ViewNewPhytos1Controller@insert_phyto1',
            ['dataRow' => [   'id_sample' => 1,
                'id_phyto' => $phyto_max_id,
                'id_horizon' => 1,
                'total' => 1,
                'total_species' => 1,
                'total_biomass' => 1,
                'total_percent' => 1,
                'biomass_percent' => 1,
                'id_saprobity' => 1,
                'id_class_of_purity' => 1,
                'upholding_sample_time' => 1,
                'concentrated_sample_volume' => 1,
                'cameras_viewed_number'=> 1

            ]]);

        $this->assertEquals(200,$response->status());

        $new_phyto = [   'id_sample' => 1,
            'id_phyto' => $phyto_max_id,
            'id_horizon' => 1,
            'total' => 1,
            'total_species' => 1,
            'total_biomass' => 1,
            'total_percent' => 1,
            'biomass_percent' => 1,
            'id_saprobity' => 1,
            'id_class_of_purity' => 1,
            'upholding_sample_time' => 1,
            'concentrated_sample_volume' => 1,
            'cameras_viewed_number'=> 1
        ];

        $search_new_phyto = DB::table('view_new_phytos1')->select('id_phyto', 'id_sample', 'id_horizon', 'total', 'total_species',
            'total_biomass', 'total_percent','biomass_percent','id_saprobity','id_class_of_purity',
            'upholding_sample_time','concentrated_sample_volume','cameras_viewed_number')->where('id_phyto',$phyto_max_id)->get();


        $inserted_data = ['id_sample' => $search_new_phyto[0]->id_sample,
            'id_phyto' => $search_new_phyto[0]->id_phyto,
            'id_horizon' => $search_new_phyto[0]->id_horizon,
            'total' => $search_new_phyto[0]->total,
            'total_species' => $search_new_phyto[0]->total_species,
            'total_biomass' => $search_new_phyto[0]->total_biomass,
            'total_percent' => $search_new_phyto[0]->total_percent,
            'biomass_percent' => $search_new_phyto[0]->biomass_percent,
            'id_saprobity' => $search_new_phyto[0]->id_saprobity,
            'id_class_of_purity' => $search_new_phyto[0]->id_class_of_purity,
            'upholding_sample_time' => $search_new_phyto[0]->upholding_sample_time,
            'concentrated_sample_volume' => $search_new_phyto[0]->concentrated_sample_volume,
            'cameras_viewed_number'=> $search_new_phyto[0]->cameras_viewed_number ];

        $this->assertEquals($inserted_data, $new_phyto);

    }


    public function testDeletePhyto(){

        $this->getActualOutput();

        $id_phyto_max = DB::table('view_new_phytos1')->max('id_phyto');

        $response = $this->action('POST','ViewNewPhytos1Controller@delete_phyto1',
            ['dataRow' => [   'id_phyto' => $id_phyto_max ]]);

        $content = $response->original;


        if($content == 'Запись не удалена! 
        У пробы с ID ' .$id_phyto_max.' есть данные о группах и видах фитопланктона в пробе.
        Сначала удалите их!' || $content == 'success'){
            $correct = true;
        }
        else {
            $correct = false;
        }

        $this->assertEquals(true, $correct);

    }


    public function testUpdatePhyto(){

        $this->getActualOutput();

        $id_phyto_max = DB::table('view_new_phytos1')->max('id_phyto');

        $response = $this->action('POST','ViewNewPhytos1Controller@update_phyto1',
            ['dataRow' => [
                'id_phyto' => $id_phyto_max,
                'id_horizon' => 1,
                'total' => 1,
                'total_species' => 1,
                'total_biomass' => 1,
                'total_percent' => 1,
                'biomass_percent' => 1,
                'id_saprobity' => 1,
                'id_class_of_purity' => 1,
                'upholding_sample_time' => 1,
                'concentrated_sample_volume' => 1,
                'cameras_viewed_number'=> 1

            ]]);


        $this->assertEquals(200,$response->status());

        $updated_phyto_select = DB::table('view_new_phytos1')->select('id_phyto', 'id_horizon', 'total', 'total_species',
            'total_biomass', 'total_percent','biomass_percent','id_saprobity','id_class_of_purity',
            'upholding_sample_time','concentrated_sample_volume','cameras_viewed_number')->where('id_phyto',$id_phyto_max)->get();


        $updated_phyto_expected = [
            'id_phyto' => $id_phyto_max,
            'id_horizon' => 1,
            'total' => 1,
            'total_species' => 1,
            'total_biomass' => 1,
            'total_percent' => 1,
            'biomass_percent' => 1,
            'id_saprobity' => 1,
            'id_class_of_purity' => 1,
            'upholding_sample_time' => 1,
            'concentrated_sample_volume' => 1,
            'cameras_viewed_number'=> 1
        ];


        $updated_phyto = [
            'id_phyto' => $updated_phyto_select[0]->id_phyto,
            'id_horizon' => $updated_phyto_select[0]->id_horizon,
            'total' => $updated_phyto_select[0]->total,
            'total_species' => $updated_phyto_select[0]->total_species,
            'total_biomass' => $updated_phyto_select[0]->total_biomass,
            'total_percent' => $updated_phyto_select[0]->total_percent,
            'biomass_percent' => $updated_phyto_select[0]->biomass_percent,
            'id_saprobity' => $updated_phyto_select[0]->id_saprobity,
            'id_class_of_purity' => $updated_phyto_select[0]->id_class_of_purity,
            'upholding_sample_time' => $updated_phyto_select[0]->upholding_sample_time,
            'concentrated_sample_volume' => $updated_phyto_select[0]->concentrated_sample_volume,
            'cameras_viewed_number'=> $updated_phyto_select[0]->cameras_viewed_number ];


        $this->assertEquals($updated_phyto_expected,$updated_phyto);


    }

    public function testUpdatePhyto2(){

        $this->getActualOutput();

        $id_phyto_max = DB::table('view_new_phytos1')->max('id_phyto');

        $response = $this->action('POST','ViewNewPhytos1Controller@update_phyto2',
            ['dataRow' => [
                'id_phyto' => $id_phyto_max,
                'id_saprobity' => 1,
                'id_class_of_purity' => 1,
                'upholding_sample_time' => 1,
                'concentrated_sample_volume' => 1,
                'cameras_viewed_number'=> 1

            ]]);


        $this->assertEquals(200,$response->status());

        $updated_phyto_select = DB::table('view_new_phytos1')->select('id_phyto', 'id_saprobity','id_class_of_purity',
            'upholding_sample_time','concentrated_sample_volume','cameras_viewed_number')->where('id_phyto',$id_phyto_max)->get();


        $updated_phyto_expected = [
            'id_phyto' => $id_phyto_max,
            'id_saprobity' => 1,
            'id_class_of_purity' => 1,
            'upholding_sample_time' => 1,
            'concentrated_sample_volume' => 1,
            'cameras_viewed_number'=> 1
        ];


        $updated_phyto = [
            'id_phyto' => $updated_phyto_select[0]->id_phyto,
            'id_saprobity' => $updated_phyto_select[0]->id_saprobity,
            'id_class_of_purity' => $updated_phyto_select[0]->id_class_of_purity,
            'upholding_sample_time' => $updated_phyto_select[0]->upholding_sample_time,
            'concentrated_sample_volume' => $updated_phyto_select[0]->concentrated_sample_volume,
            'cameras_viewed_number'=> $updated_phyto_select[0]->cameras_viewed_number ];


        $this->assertEquals($updated_phyto_expected,$updated_phyto);


    }







}
