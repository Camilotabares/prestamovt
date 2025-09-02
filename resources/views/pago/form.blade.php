<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_pago" class="form-label">{{ __('Fecha Pago') }}</label>
            <input type="date" name="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror"
                   value="{{ old('fecha_pago', $pago?->fecha_pago ?? \Carbon\Carbon::now()->format('Y-m-d')) }}"
                   id="fecha_pago">
            {!! $errors->first('fecha_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="monto_abono" class="form-label">{{ __('Monto Abono') }}</label>
            <input type="text" name="monto_abono" class="form-control" @error('monto_abono') is-invalid @enderror" value="{{ old('monto_abono', isset($pago) && $pago?->monto_abono ? number_format($pago->monto_abono, 0, ',', '.') : '') }}"  id="monto_abono" placeholder="Monto Abono">
            {!! $errors->first('monto_abono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <script>
            document.getElementById('monto_abono').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, ''); // Elimina todo excepto dígitos
                if (value) {
                    e.target.value = new Intl.NumberFormat('es-CO').format(value);
                } else { 
                    e.target.value = '';
                }
            });
            </script>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <input type="hidden" name="prestamo_id" value="{{ $prestamo->id }}">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>