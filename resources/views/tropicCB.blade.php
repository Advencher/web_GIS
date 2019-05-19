<select>
<option value="0">Нет</option>
@foreach ($tropics as $key => $tropic)
    <option value="{{ $tropic->id_trophic_characterization }}">{{  $tropic->name }}</option>
@endforeach
</select>