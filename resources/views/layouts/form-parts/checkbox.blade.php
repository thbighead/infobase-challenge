<div class="form-group">
    <div class="{{ $grid }}">
        <div class="checkbox" style="line-height: 1.6em;">
            <label>
                <input type="checkbox" name="{{ $name }}"
                       value="{{ $value }}" {{ (isset($object) && Arr::get($object, $name) == $value) ? 'checked=checked' : '' }} {{ isset($action) ? '' : 'disabled' }}/> {{ $label }}
            </label>
        </div>
    </div>
</div>