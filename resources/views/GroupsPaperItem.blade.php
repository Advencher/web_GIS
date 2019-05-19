@foreach ($groups as $group)
    <paper-item value = "{{$group->id_group}}">{{$group->name}}</paper-item>
@endforeach
