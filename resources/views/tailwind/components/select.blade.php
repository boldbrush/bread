<label for="{{ $name }}">
    {{ $label }}
</label>

<select name="{{ $name }}">
    <option value="false">Select One</option>
    @foreach ($options as $value => $text)
    @if ($value === $selected)
    <option selected="true" value="{{ $value }}">{{ $text }}</option>
    @else
    <option value="{{ $value }}">{{ $text }}</option>
    @endif
    @endforeach
</select>