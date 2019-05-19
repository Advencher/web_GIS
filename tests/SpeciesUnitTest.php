<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class SpeciesUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    function testShowSpecies() {


        $this->getActualOutput();


        $id_phyto = 1;
        while (sizeof($phytos = DB::table('view_new_phytos2')->select('*')->where('id_phyto', $id_phyto)->orderBy('specie_name')->paginate(15)) == 0 || $id_phyto > 200) {
            $id_phyto++;
        }

        $response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@ShowPhytosSpecies',
            [
                'sortBy' => 'specie_name',
                'limit' => '15',
                'id_phyto' => $id_phyto
            ]);

        $this->assertEquals(200,$response -> status());


        $i = 0;
        $correct = true;
        foreach ($response->original->phytos as $phyto_current ){

            If (!($phyto_current->id_species == $phytos[$i]->id_species &&
                $phyto_current->id_specie_in_phyto == $phytos[$i]->id_specie_in_phyto &&
                $phyto_current->id_phyto == $phytos[$i]->id_phyto &&
                $phyto_current->percentage_of_total == $phytos[$i]->percentage_of_total &&
                $phyto_current->percentage_of_the_total_biomass == $phytos[$i]->percentage_of_the_total_biomass &&
                $phyto_current->number  == $phytos[$i]->number  &&
                $phyto_current->biomass  == $phytos[$i]->biomass &&
                $phyto_current->specie_name == $phytos[$i]->specie_name &&
                $phyto_current->id_group  == $phytos[$i]->id_group  &&
                $phyto_current->group_name == $phytos[$i]->group_name ))
            {
                $correct = false;
            }
            $i++;
        }
        $this->assertEquals(true, $correct);

    }

    function testShowGroups() {


        $this->getActualOutput();
        $id_phyto = 1;
        while (sizeof($phytos = DB::table('view_new_phytos3')->select('*')->where('id_phyto','=', $id_phyto)) == 0 || $id_phyto > 200) {
            $id_phyto++;
        }

        $response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@ShowPhytosSpecies',
            [
                'limit' => '15',
                'id_phyto' => $id_phyto
            ]);

        $this->assertEquals(200,$response -> status());

        $i = 0;
        $correct = true;
        foreach ($response->original->phytos as $phyto_current ){

            If (!($phyto_current->id_group_in_phyto == $phytos[$i]->id_group_in_phyto &&
                $phyto_current->id_group == $phytos[$i]->id_group &&
                $phyto_current->id_phyto == $phytos[$i]->id_phyto &&
                $phyto_current->number == $phytos[$i]->number &&
                $phyto_current->biomass == $phytos[$i]->biomass &&
                $phyto_current->total_species_in_group  == $phytos[$i]->total_species_in_group  &&
                $phyto_current->total_percent  == $phytos[$i]->total_percent &&
                $phyto_current->biomass_percent == $phytos[$i]->biomass_percent &&
                $phyto_current->group_name == $phytos[$i]->group_name ))
            {
                $correct = false;
            }
            $i++;
        }
        $this->assertEquals(true, $correct);

    }

    public function testPhytoMaxSpecieID()
    {

        $this->getActualOutput();
        //тест максимального ID в базе данных

        $id_phyto_max = DB::table('view_new_phytos2')->max('id_specie_in_phyto');


        $response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@maxIDSpecies');

        $c_phyto_max_id = $response->original;


        $this->assertEquals($id_phyto_max, $c_phyto_max_id);


    }

    public function testPhytoMaxGroupID()
    {

        $this->getActualOutput();
        //тест максимального ID в базе данных

        $id_phyto_max = DB::table('view_new_phytos3')->max('id_group_in_phyto');


        $response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@maxIDGroups');

        $c_phyto_max_id = $response->original;

        $this->assertEquals($id_phyto_max, $c_phyto_max_id);


    }

    public function testCreateSpecieInPhyto()
    {

        $this->getActualOutput();

        //$response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@maxIDGroups');
        //$phyto_max_id = $response->original;
       // $phyto_max_id++;


        $phytos = DB::table('view_new_phytos1')->select('id_phyto')->get();
        $species = DB::table('species_of_phytoplankton')->select('id_species')->get();

        $species_in_pytos = DB::table('view_new_phytos2')->select('id_phyto','id_species')->get();


        $found = false;
        $wrong = false;
        $phyto_final_id = 0;
        $specie_final_id = 0;
        foreach ($phytos as $phyto) {

            $id = $phyto->id_phyto;
           foreach ($species_in_pytos as $sip)
           {

               if($sip->id_phyto == $id)
               {

                   $found = true;
                   break;

               }
               else {
                   $phyto_final_id = $id;
                   $correct = true;
               }

               if($found == true) {

                   foreach ($species as $sp){

                       $specie_final_id = $sp->id_species;
                       foreach ($species_in_pytos as $sip){

                           if($sip->id_phyto == $id && $sip->id_species == $specie_final_id)
                           {
                               $wrong = true;
                               break;
                           }

                       }

                   }


               }

               if ($correct == true) {
                   $specie_final_id = 1;
                   break;
               }
               if ($wrong == false) break;

           }

        }

        echo "\n",$specie_final_id,"   ", $phyto_final_id, "\n";

        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@insert_species_in_phyto_sample',
            ['dataRow' => [
                'id_phyto' => $phyto_final_id,
                'id_species' => $specie_final_id,
                'percentage_of_total' => 1,
                'percentage_of_the_total_biomass' => 1,
                'number' => 1,
                'biomass' => 1,

            ]]);

        $this->assertEquals(200,$response->status());

        $new_phyto = [
            'id_phyto' => $phyto_final_id,
            'id_species' => $specie_final_id,
            'percentage_of_total' => 1,
            'percentage_of_the_total_biomass' => 1,
            'number' => 1,
            'biomass' => 1,

        ];

        $id_max = DB::table('view_new_phytos2')->max('id_specie_in_phyto');
        $search_new_phyto = DB::table('view_new_phytos2')->select('id_phyto', 'id_species', 'percentage_of_total', 'percentage_of_the_total_biomass', 'number',
            'biomass' )->where('id_specie_in_phyto',$id_max)->get();


        $inserted_data = ['id_phyto' => $search_new_phyto[0]->id_phyto,
            'id_species' => $search_new_phyto[0]->id_species,
            'percentage_of_total' => $search_new_phyto[0]->percentage_of_total,
            'percentage_of_the_total_biomass' => $search_new_phyto[0]->percentage_of_the_total_biomass,
            'number' => $search_new_phyto[0]->number,
            'biomass' => $search_new_phyto[0]->biomass

            ];

        $this->assertEquals($inserted_data, $new_phyto);

    }

    public function testCreateGroupInPhyto()
    {

        $this->getActualOutput();

        //$response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@maxIDGroups');
        //$phyto_max_id = $response->original;
        // $phyto_max_id++;


        $phytos_id = 11;
        $groups_id = 5;



        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@insert_group_in_phyto_sample',
            ['dataRow' => [
                'id_phyto' => $phytos_id,
                'id_group' => $groups_id,
                'number' => 1,
                'biomass' => 1,
                'total_species_in_group' => 1,
                'total_percent' => 1,
                'biomass_percent' => 1
            ]]);

        $this->assertEquals(200,$response->status());

        $new_phyto = [
            'id_phyto' => $phytos_id,
            'id_group' => $groups_id,
            'number' => 1,
            'biomass' => 1,
            'total_species_in_group' => 1,
            'total_percent' => 1,
            'biomass_percent' => 1

        ];

        $id_max = DB::table('view_new_phytos3')->max('id_group_in_phyto');
        $search_new_phyto = DB::table('view_new_phytos3')->select('id_phyto', 'id_group', 'number', 'biomass', 'total_species_in_group',
            'total_percent', 'biomass_percent'  )->where('id_group_in_phyto',$id_max)->get();


        $inserted_data = [
            'id_phyto' => $search_new_phyto[0]->id_phyto,
            'id_group' => $search_new_phyto[0]->id_group,
            'number' => $search_new_phyto[0]->number,
            'biomass' => $search_new_phyto[0]->biomass,
            'total_species_in_group' => $search_new_phyto[0]->total_species_in_group,
            'total_percent' => $search_new_phyto[0]->total_percent,
            'biomass_percent' => $search_new_phyto[0]->biomass_percent

        ];

        $this->assertEquals($inserted_data, $new_phyto);

    }

    public function testDeletePhytoSpecies(){

        $this->getActualOutput();

        $id_phyto_max = DB::table('view_new_phytos2')->max('id_specie_in_phyto');

        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@delete_species_in_phyto_sample',
            ['dataRow' => [   'id_specie_in_phyto' => $id_phyto_max ]]);

        $this->assertEquals(200,$response->status());

        $this->assertEquals(1,$response->original);



    }

    public function testDeletePhytoGroup(){

        $this->getActualOutput();

        $id_phyto_max = DB::table('view_new_phytos3')->max('id_group_in_phyto');

        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@delete_group_in_phyto_sample',
            ['dataRow' => [   'id_group_in_phyto' => $id_phyto_max ]]);

        $this->assertEquals(200,$response->status());

        $this->assertEquals(1,$response->original);



    }

    public function testUpdateSpecieInPhyto()
    {

        $this->getActualOutput();

        //$response = $this->action('GET','ViewNewPhytosSpeciesAndGroupsController@maxIDGroups');
        //$phyto_max_id = $response->original;
        // $phyto_max_id++;


        $phytos = DB::table('view_new_phytos1')->select('id_phyto')->get();
        $species = DB::table('species_of_phytoplankton')->select('id_species')->get();

        $species_in_pytos = DB::table('view_new_phytos2')->select('id_phyto','id_species')->get();


        $found = false;
        $wrong = false;
        $phyto_final_id = DB::table('view_new_phytos2')->max('id_specie_in_phyto');
        $specie_final_id = 0;


            $id = $phyto_final_id;
            foreach ($species_in_pytos as $sip)
            {

                if($sip->id_phyto == $id)
                {

                    $found = true;
                    break;

                }
                else {
                    $phyto_final_id = $id;
                    $correct = true;
                }

                if($found == true) {

                    foreach ($species as $sp){

                        $specie_final_id = $sp->id_species;
                        foreach ($species_in_pytos as $sip){

                            if($sip->id_phyto == $id && $sip->id_species == $specie_final_id)
                            {
                                $wrong = true;
                                break;
                            }

                        }

                    }


                }

                if ($correct == true) {
                    $specie_final_id = 1;
                    break;
                }
                if ($wrong == false) break;

            }

        $maxIdToUpdate =  DB::table('view_new_phytos2')->max('id_specie_in_phyto');

        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@update_species_in_phyto_sample',
            ['dataRow' => [
                'id_specie_in_phyto' => $maxIdToUpdate,
                'id_species' => $specie_final_id,
                'percentage_of_total' => 1,
                'percentage_of_the_total_biomass' => 1,
                'number' => 1,
                'biomass' => 1,

            ]]);

        $this->assertEquals(200,$response->status());

        $new_phyto = [
            'id_specie_in_phyto' => $maxIdToUpdate,

            'id_species' => $specie_final_id,
            'percentage_of_total' => 1,
            'percentage_of_the_total_biomass' => 1,
            'number' => 1,
            'biomass' => 1,

        ];

        $id_max = DB::table('view_new_phytos2')->max('id_specie_in_phyto');
        $search_new_phyto = DB::table('view_new_phytos2')->select('id_specie_in_phyto', 'id_species', 'percentage_of_total', 'percentage_of_the_total_biomass', 'number',
            'biomass' )->where('id_specie_in_phyto',$id_max)->get();


        $inserted_data = [
            'id_specie_in_phyto'=>$search_new_phyto[0]->id_specie_in_phyto,

            'id_species' => $search_new_phyto[0]->id_species,
            'percentage_of_total' => $search_new_phyto[0]->percentage_of_total,
            'percentage_of_the_total_biomass' => $search_new_phyto[0]->percentage_of_the_total_biomass,
            'number' => $search_new_phyto[0]->number,
            'biomass' => $search_new_phyto[0]->biomass

        ];

        $this->assertEquals($inserted_data, $new_phyto);

    }

    public function testUpdateGroupInPhyto()
    {

        $this->getActualOutput();


        $groups_id = 5;

        $maxGroupId = DB::table('view_new_phytos3')->max('id_group_in_phyto');

        $response = $this->action('POST','ViewNewPhytosSpeciesAndGroupsController@update_group_in_phyto_sample',
            ['dataRow' => [
                'id_group_in_phyto' => $maxGroupId,
                'id_group' => $groups_id,
                'number' => 1,
                'biomass' => 1,
                'total_species_in_group' => 1,
                'total_percent' => 1,
                'biomass_percent' => 1
            ]]);

        $this->assertEquals(200,$response->status());

        $new_phyto = [
            'id_group_in_phyto' => $maxGroupId,
            'id_group' => $groups_id,
            'number' => 1,
            'biomass' => 1,
            'total_species_in_group' => 1,
            'total_percent' => 1,
            'biomass_percent' => 1

        ];

        $id_max = DB::table('view_new_phytos3')->max('id_group_in_phyto');
        $search_new_phyto = DB::table('view_new_phytos3')->select('id_group_in_phyto', 'id_group', 'number', 'biomass', 'total_species_in_group',
            'total_percent', 'biomass_percent'  )->where('id_group_in_phyto',$id_max)->get();


        $inserted_data = [
            'id_group_in_phyto'  => $search_new_phyto[0]->id_group_in_phyto,
            'id_group' => $search_new_phyto[0]->id_group,
            'number' => $search_new_phyto[0]->number,
            'biomass' => $search_new_phyto[0]->biomass,
            'total_species_in_group' => $search_new_phyto[0]->total_species_in_group,
            'total_percent' => $search_new_phyto[0]->total_percent,
            'biomass_percent' => $search_new_phyto[0]->biomass_percent

        ];

        $this->assertEquals($inserted_data, $new_phyto);

    }







}
