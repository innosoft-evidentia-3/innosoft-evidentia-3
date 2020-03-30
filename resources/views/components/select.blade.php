<div class="form-group col-md-{{$col}}">

    <label for="{{ $attr }}">{{ $label }}</label>

    <select

        id="{{ $id }}"

        class="selectpicker form-control @error('comittee') is-invalid @enderror"

        name="{{ $attr }}"

        required autofocus>

        {{ $slot }}

    </select>

    <small class="form-text text-muted">{{ $description }}</small>

    @error($attr)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
