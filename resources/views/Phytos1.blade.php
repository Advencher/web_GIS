
    {"records":[
    @foreach ($phytos as $key => $phyto)
    {"IDSample": {{ $phyto->id_sample }}, "ID": {{ $phyto->id_phyto }}, "StationID": "{{ $phyto->id_station }}","Station": "{{ $phyto->station_name }}, {{ $phyto->water_area_name }}",
    "HorizonID": "{{ $phyto->id_horizon }}",
    "Horizon": "{{ $phyto->horizon }}@if (!is_null($phyto->upper_horizon_level)){{ $phyto->upper_horizon_level }}-{{ $phyto->lower_horizon_level }}@endif",
    "Date": {{ $phyto->date }},"Time": "{{ $phyto->time }}","UTC": "{{ $phyto->utc }}",
    "Total": "{{ $phyto->total }}", "TotalSpecies": "{{ $phyto->total_species }}", "TotalBiomass": "{{ $phyto->total_biomass }}",
    "TotalPercent": "{{ $phyto->total_percent }}", "BiomassPercent": "{{ $phyto->biomass_percent }}", "SaprobityID": "{{ $phyto->id_saprobity }}","WaterPurityID": {{ $phyto->id_class_of_purity }}, "Latitude":{{ $phyto->latitude }}, "Longitude":{{ $phyto->longitude }},
    "UpholdingTime": "{{ $phyto->upholding_sample_time }}", "ConcentratedSampleVolume": "{{ $phyto->concentrated_sample_volume }}", "CamerasViewedNumber": "{{ $phyto->cameras_viewed_number }}","OrderNumber": {{$key+1}}}
    @if ($key+1 != $phytos->count())
        ,
    @endif
@endforeach
],"total":{{$count}}}