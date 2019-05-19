<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class otherStuffTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


public function testControllerWaterArea(){


    $this->getActualOutput();

    $response = $this->action('GET','WaterAreaController@forComboBox');


    $phytos = DB::table('water_area')->select('*')->orderBy('id_water_area')->get();



    $i = 0;
    $correct = true;
    foreach ($response->original->waterAreas as $phyto_current ){


        If (!($phyto_current->id_water_area == $phytos[$i]->id_water_area &&
            $phyto_current->name == $phytos[$i]->name)) {

            $correct = false;
        }

        $i++;

    }
    $this->assertEquals(true, $correct);


}



    public function testControllerHorizonLevels(){


        $this->getActualOutput();

        $response = $this->action('GET','HorizonLevelsController@ShowAllForComboBox');


        $phytos = DB::table('horizon_levels')->select('*')->get();



        $i = 0;
        $correct = true;
        foreach ($response->original->horizons as $phyto_current ){


            If (!($phyto_current->id_horizon == $phytos[$i]->id_horizon &&
                $phyto_current->name == $phytos[$i]->name &&
                $phyto_current->upper_horizon_level == $phytos[$i]->upper_horizon_level &&
                $phyto_current->lower_horizon_level == $phytos[$i]->lower_horizon_level)) {

                $correct = false;
            }

            $i++;

        }
        $this->assertEquals(true, $correct);


    }



    public function testControllerSaprobity(){


        $this->getActualOutput();

        $response = $this->action('GET','SaprobityController@forComboBox');


        $phytos = DB::table('saprobity')->select('*')->orderBy('id_saprobity')->get();


        $i = 0;
        $correct = true;
        foreach ($response->original->saprobities as $phyto_current ){


            If (!($phyto_current->id_saprobity == $phytos[$i]->id_saprobity &&
                $phyto_current->name == $phytos[$i]->name)) {

                $correct = false;
            }

            $i++;

        }
        $this->assertEquals(true, $correct);


    }


    public function testControllerWaterPurity(){


        $this->getActualOutput();

        $response = $this->action('GET','ClassOfWaterPurityController@forComboBox');


        $phytos = DB::table('class_of_water_purity')->select('*')->orderBy('id_class_of_purity')->get();


        $i = 0;
        $correct = true;
        foreach ($response->original->waterPurites as $phyto_current ){


            If (!($phyto_current->id_class_of_purity == $phytos[$i]->id_class_of_purity &&
                $phyto_current->name == $phytos[$i]->name)) {

                $correct = false;
            }

            $i++;

        }
        $this->assertEquals(true, $correct);


    }






}

