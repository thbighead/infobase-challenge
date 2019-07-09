@php
    $inputUniqueId = time();
@endphp

@push('js')
    @if(!isset($autocompleteScriptAlreadyIncluded))
        <!-- JS file -->
        <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>
        @php
            $autocompleteScriptAlreadyIncluded = true;
        @endphp
    @endif
    <script>
        $("#{{ $inputUniqueId }}").easyAutocomplete({
            data: {!! $string_json_list !!},
            getValue: "name",

            list: {
                match: {
                    enabled: true
                }
            }
        });
    </script>
@endpush

@push('css')
    @if(!isset($autocompleteCssAlreadyIncluded))
        <!-- CSS file -->
        <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.min.css') }}">

        <!-- Additional CSS Themes file - not required-->
        <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.themes.min.css') }}">

        <style>
            .easy-autocomplete {
                width: 100% !important;
            }

            .easy-autocomplete input {
                border-radius: 0;
                box-shadow: none;
                border-color: #d2d6de;
                float: inherit;
            }
        </style>

        @php
            $autocompleteCssAlreadyIncluded = true;
        @endphp
    @endif
@endpush

<div class="{{ $grid }} form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $inputUniqueId }}" class="form-control" name="{{ $name }}"
           placeholder="{{ isset($hint) ? $hint : '' }}"
           value="{{ (bool)old($name) ? old($name) : (isset($object) ? Arr::get($object, $name) : '') }}" {{ isset($action) ?: 'readonly' }}/>
    @isset($help)
        <span class="help-block">{{ $help }}</span>
    @endisset
    @if($errors->has($name))
        @foreach($errors->get($name) as $message)
            <span class="help-block">{{ $message }}</span>
        @endforeach
    @endif
</div>