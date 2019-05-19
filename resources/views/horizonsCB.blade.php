<select>
    @foreach ($horizons as $key => $horizon)
        <option value="{{ $horizon->id_horizon }}">{{ $horizon->name }} @if (!is_null($horizon->upper_horizon_level)) {{$horizon -> upper_horizon_level}}-{{$horizon -> lower_horizon_level}} @endif</option>
    @endforeach
</select>