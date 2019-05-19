<select>
    @foreach ($groups as $key => $group)
        <option value="{{ $group->id_group }}">{{ $group->name }}</option>
    @endforeach
</select>