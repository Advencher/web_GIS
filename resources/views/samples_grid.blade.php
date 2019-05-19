
  {"records":[
@foreach ($samples as $key => $sample)
    {"ID": {{ $sample->id_sample }},"StationID": "{{ $sample->id_station }}","Station": "{{ $sample->station_name }}, {{ $sample->water_area_name }}",
    "Comment": "{{ $sample->comment }}", "Date": {{ $sample->date }},"Time": "{{ $sample->time }}","UTC": "{{ $sample->utc }}",
    "SerialNumber": "{{ $sample->serial_number }}","Longitude": {{ $sample->longitude }} ,"Latitude": {{ $sample->latitude }}, "CountPho": {{ $sample->count_photos }} ,
    "CountPhy": {{ $sample->count_phyto }}, "OrderNumber": {{$key+1}}}
    @if ($key+1 != $samples->count())
        ,
    @endif


@endforeach
],"total":{{$count}}}
