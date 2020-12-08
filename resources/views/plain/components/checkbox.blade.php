@php $checkbox = $checkbox ? 'checked value="1"' : 'value="0"'; @endphp
<label for="{{ $name }}">
    {{ $label }}
</label>
<input name="{{ $name }}" type="hidden" value="0">
<input name="{{ $name }}" class="shadow" id="{{ $name }}" type="checkbox" {{ $checkbox }}>
