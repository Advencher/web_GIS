{"records":[
@foreach ($phytos as $key => $phyto)
    { "ID":{{ $phyto->id_group_in_phyto }},
    "IDGroup":{{ $phyto->id_group }},
    "IDphyto": {{ $phyto->id_phyto }},
    "Number": "{{ $phyto->number }}",
    "Biomass": "{{ $phyto->biomass }}",
    "TotalSpecies": "{{ $phyto->total_species_in_group }}",
    "TotalPercent": "{{ $phyto->total_percent }}",
    "BiomassPercent":"{{ $phyto->biomass_percent }}",
    "GroupName": "{{ $phyto->group_name }}","OrderNumber": {{$key+1}}}
    @if ($key+1 != $phytos->count())
        ,
    @endif
@endforeach
],"total":{{$count}}}