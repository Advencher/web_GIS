@foreach ($saprobities as $saprobity)
    <paper-item value = "{{$saprobity->id_saprobity}}">{{$saprobity->name}}</paper-item>
@endforeach
