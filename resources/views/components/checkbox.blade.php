@php $checkbox = $checkbox ? 'checked value="1"' : 'value="0"'; @endphp
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $name }}">
        {{ $label }}
    </label>
    <input name="{{ $name }}" type="hidden" value="0">
    <input name="{{ $name }}" class="shadow" id="{{ $name }}" type="checkbox" {{ $checkbox }}>
</div>