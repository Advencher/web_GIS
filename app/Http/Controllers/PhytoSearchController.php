<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PhytoSearchController extends Controller
{

    public function search1(Request $request)

    {
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');
        if ($sortBy === 'ID')
            $sortBy = 'id_sample '  .$direction;

        if ($sortBy === 'Date')
            $sortBy = 'date ' .$direction;
        if ($sortBy === 'Station')
            $sortBy = 'water_area_name ' .$direction  .', station_name ' .$direction;



        $limit = $request->input('limit');
        $count = App\ViewNewSamples::where('station_name', 'LIKE', '%' . $request->search . "%")
            ->orWhere('water_area_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('serial_number', 'LIKE', '%' . $request->search . '%')
            ->count();
        //->orWhereBetween('date', [$request->from , $request->to ]  )


        $samples = App\ViewNewSamples::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->paginate($limit);


            $samples = App\ViewNewSamples::where('station_name', 'LIKE', '%' . $request->search . "%")
                ->orWhere('water_area_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('serial_number', 'LIKE', '%' . $request->search . '%')
                //->orWhere('date', 'LIKE', '%' . $request->search . '%')
                ->paginate($limit);

            foreach  ($samples as  $sample) {
                $sample->longitude = round($sample->longitude, 2);
                $sample->latitude = round($sample->latitude, 2);
                $sample->time = substr($sample->date, 11, 8);
                $sample->utc = substr($sample->date, 19, 3);
                $day = (int) substr($sample->date, 8, 2);
                $month = (int) substr($sample->date, 5, 2);
                $year = (int) substr($sample->date, 0, 4);
                $sample->date = mktime(0, 0, 0, $month, $day, $year)*1000;
            }

                return view('Test2', compact('samples', 'count'));
    }

}
