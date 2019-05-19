@foreach ($waterPurites as $waterPurity)
    <paper-item value = "{{$waterPurity->id_class_of_purity}}">{{$waterPurity->name}}</paper-item>
@endforeach
