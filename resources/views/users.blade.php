{"records":[
@foreach ($users as $key => $user)
    {"ID": {{ $user->id }},"Name": "{{ $user->name }}","Email": "{{ $user->email }}",
    "RightID": "{{ $user->id_right }}", "Right": "{{ $user->right_name }}", "OrderNumber": {{$key+1}}}
    @if ($key+1 != $users->count())
        ,
    @endif


@endforeach
],"total":{{$count}}}

