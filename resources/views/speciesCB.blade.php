<select>
    @foreach ($species as $key => $specie)
        <option value="{{ $specie->id_species }}">{{ $specie->name }}</option>
    @endforeach
</select>