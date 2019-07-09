<div class="{{ $grid }} form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" {{ isset($action) ?: 'disabled' }}>
        @foreach($options as $value => $option)
            <option value="{{ $value }}" {{ (isset($object) && Arr::get($object, $name) == $value) ? 'selected=selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
    @if($errors->has($name))
        @foreach($errors->get($name) as $message)
            <span class="help-block">{{ $message }}</span>
        @endforeach
    @endif
</div>