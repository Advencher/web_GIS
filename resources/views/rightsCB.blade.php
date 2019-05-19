
<select>
@foreach ($rights as $key => $right)
    <option value="{{ $right->id_right }}">{{ $right->name }}</option>
@endforeach
</select>