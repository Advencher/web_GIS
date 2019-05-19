{"records":[
@foreach ($phytos as $key => $phyto)
    {"IDSpecies": {{ $phyto->id_species }},
    "ID": {{ $phyto->id_specie_in_phyto }},
    "IDphyto": {{ $phyto->id_phyto }},
    "PercentageOfTotal": "{{ $phyto->percentage_of_total }}",
    "PercentageOfTheTotalBiomass": "{{ $phyto->percentage_of_the_total_biomass }}",
    "Number": "{{ $phyto->number }}",
    "Biomass": {{ $phyto->biomass }},
    "SpecieName":"{{ $phyto->specie_name }}",
    "IDGroup":"{{ $phyto->id_group }}",
    "GroupName": "{{ $phyto->group_name }}",
    "OrderNumber": {{$key+1}}}
    @if ($key+1 != $phytos->count())
        ,
    @endif
@endforeach
],"total":{{$count}}}