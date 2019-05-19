
  {"records":[
@foreach ($pigments as $key => $pigment)
    {"ID": {{ $pigment->id_pps }},"SerialNumber": "{{ $pigment->pps_serial }}","Date": "{{ $pigment->date }}","ChlA": "{{ $pigment->chla }}"
	,"Longitude": {{ $pigment->longitude }} ,"Latitude": {{ $pigment->latitude }},"Station": "{{ $pigment->station }}, {{ $pigment->waterarea }}"
	,"ChlB": "{{ $pigment->chlb }}","ChlC": "{{ $pigment->chlb }}","TropCh": "{{ $pigment->trophiccharacteristics }}","VolumeOfPW": "{{ $pigment->volumeoffilteredwater }}"
	,"A665k": "{{ $pigment->a665k }}","Pigmentindex": "{{ $pigment->pigmentindex }}","Pheopigments": "{{ $pigment->pheopigments }}","Comment": "{{ $pigment->comment }}"
	,"TropId": "{{ $pigment->trop_id }}","StationId": "{{ $pigment->id_station }}"
	,"OrderNumber": {{$key+1}}}
    @if ($key+1 != $pigments->count())
        ,
    @endif
@endforeach
],"total":{{$count}}}
