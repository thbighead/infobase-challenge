@php
    if (isset($object))
        $array_set = array_pluck($object[$name], 'id');
@endphp

<div class="{{ $grid }} form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control select2"
            name="{{ $name . ((isset($type) && $type === 'multiple') ? '[]' : '') }}" {{ isset($type) ? $type : '' }} {{ isset($action) ?: 'disabled' }}>
        @if(array_key_exists('optgroup', $options))
            @foreach($options['data'] as $major_option)
                <optgroup label="{{ $major_option[$options['optgroup']] }}">
                    @foreach($major_option[$options['items']] as $option)
                        <option value="{{ $option[$options['key']] }}" {{ (bool)session()->getOldInput() ? ((old($name) && in_array($option[$options['key']], old($name))) ? 'selected=selected' : '') : ((isset($object) && in_array($option[$options['key']], $array_set)) ? 'selected=selected' : '') }}>
                            {{ $option[$options['value']] }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        @else
            @foreach($options as $value => $option)
                <option value="{{ $value }}" {{ (bool)session()->getOldInput() ? ((old($name) && in_array($value, old($name))) ? 'selected=selected' : '') : ((isset($object) && in_array($value, $array_set)) ? 'selected=selected' : '') }}>{{ $option }}</option>
            @endforeach
        @endif
    </select>
    @if($errors->has($name))
        @foreach($errors->get($name) as $message)
            <span class="help-block">{{ $message }}</span>
        @endforeach
    @endif
</div>

@push('js')
    @if(!isset($select2ScriptAlreadyIncluded))
        <script src="{{ asset('js/select2-initializer.min.js') }}"></script>
        @php
            $select2ScriptAlreadyIncluded = true;
        @endphp
    @endif
@endpush