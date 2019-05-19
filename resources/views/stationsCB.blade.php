{{--<select><option value="18">Bulgaria</option><option value="12">Brazil</option><option value="16">England</option><option value="17">Germany</option><option value="14">Colombia</option><option value="19">Poland</option>
    </select>--}}
{{--
[
@foreach ($stations as $key => $station)
    {"id": "{{ $station->id_station }}" ,"text": "{{ $station->station_name }}, {{ $station->water_area_name }}"}
    @if ($key+1 != $stations->count())
        ,
    @endif


@endforeach
]--}}

<select>
@foreach ($stations as $key => $station)
    <option value="{{ $station->id_station }}">{{ $station->station_name }}, {{ $station->water_area_name }}</option>
@endforeach
</select>