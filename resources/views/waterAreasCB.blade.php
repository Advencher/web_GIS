@foreach ($waterAreas as $waterArea)
    <paper-item value = "{{$waterArea->id_water_area}}">{{$waterArea->name}}</paper-item>
@endforeach

