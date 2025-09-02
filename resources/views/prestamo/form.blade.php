<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">

            <label for="cliente_id" class="form-label">{{ __('Cliente Id') }}</label>
            <select name="cliente_id" id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror">
                <option value="">{{ __('Seleccione un cliente') }}</option>
                @foreach($clientes as $id => $nombre)
                <option value="{{ $id }}"
                    {{ old('cliente_id', $prestamo?->cliente_id) == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
            </select>
            {!! $errors->first('cliente_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="monto" class="form-label">{{ __('Monto') }}</label>
            <input type="text" name="monto" class="form-control @error('monto') is-invalid @enderror"
            value="{{ old('monto', isset($prestamo) && $prestamo->monto ? number_format($prestamo->monto, 0, ',', '.') : '') }}"
            id="monto" placeholder="Monto en pesos colombianos">
            {!! $errors->first('monto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <script>
            document.getElementById('monto').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, ''); // Elimina todo excepto dígitos
                if (value) {
                    e.target.value = new Intl.NumberFormat('es-CO').format(value);
                } else {
                    e.target.value = '';
                }
            });
            </script>
        <div class="form-group mb-2 mb20">
            <label for="cuotas" class="form-label">{{ __('Cuotas') }}</label>
            <input type="text" name="cuotas" class="form-control @error('cuotas') is-invalid @enderror" value="{{ old('cuotas', $prestamo?->cuotas) }}" id="cuotas" placeholder="Ingrese el numero de Cuotas">
            {!! $errors->first('cuotas', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="interes_porcentaje" class="form-label">{{ __('Interes Porcentaje') }}</label>
            <input type="text" name="interes_porcentaje" class="form-control @error('interes_porcentaje') is-invalid @enderror" value="{{ old('interes_porcentaje', $prestamo?->interes_porcentaje) }}" id="interes_porcentaje" placeholder="Interes Porcentaje">
            {!! $errors->first('interes_porcentaje', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="mb-3">
            <label for="modalidad_pago" class="form-label">Modalidad de Pago</label>
            <select name="modalidad_pago" id="modalidad_pago" class="form-select" required>
                <option value="">Seleccione una opción</option>
                <option value="Decadal" {{ old('modalidad_pago', $prestamo?->modalidad_pago) == 'Decadal' ? 'selected' : '' }}>Decadal</option>
                <option value="Quincenal" {{ old('modalidad_pago', $prestamo?->modalidad_pago) == 'Quincenal' ? 'selected' : '' }}>Quincenal</option>
                <option value="Mensual" {{ old('modalidad_pago', $prestamo?->modalidad_pago) == 'Mensual' ? 'selected' : '' }}>Mensual</option>
            </select>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_inicio" class="form-label">{{ __('Fecha Inicio') }}</label>
            <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio', $prestamo?->fecha_inicio) }}" id="fecha_inicio" placeholder="Fecha Inicio">
            {!! $errors->first('fecha_inicio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>