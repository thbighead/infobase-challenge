<div class="{{ $grid }} form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" placeholder="{{ isset($hint) ? $hint : '' }}"
           value="{{ (bool)old($name) ? old($name) : (isset($object) ? Arr::get($object, $name) : '') }}" {{ isset($action) ? '' : 'readonly' }}>
    @isset($help)
        <span class="help-block">{{ $help }}</span>
    @endisset
    @if($errors->has($name))
        @foreach($errors->get($name) as $message)
            <span class="help-block">{{ $message }}</span>
        @endforeach
    @endif
</div>