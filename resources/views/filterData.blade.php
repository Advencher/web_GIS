{
"areas": [
    @foreach ($areas as $key => $area)
        "{{$area->name}}"
        @if ($key+1 != $areas->count())
            ,
        @endif
    @endforeach
    ],
@php ($ind = 0)
"stations": [
    @foreach ($areas as $key => $area)
        @php ($begin = true)
        {"values":[
        @for($i = $ind; $i < $stations->count(); $i++)
            @if($key+1 == $stations[$i]->id_water_area)
                @if(!$begin)
                    ,
                @else
                    @php ($begin = false)
                @endif
                {
                "key": {{$stations[$i]->key}}, "value": "{{$stations[$i]->value}}"
                }
            @else
                @php ($ind = $i)
                @break
            @endif
        @endfor

        ]}
        @if ($key+1 != $areas->count())
            ,
        @endif

    @endforeach


    ]
}
