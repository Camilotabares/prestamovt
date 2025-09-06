@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h4>Detalle del Préstamo</h4>
        <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}"> {{ __('Atras') }}</a>
    </div>

    <div class="card-body bg-white">
        {{-- Información del préstamo --}}
        <div class="form-group mb-2">
            <strong>Cliente Id:</strong> {{ $prestamo->cliente_id }}
        </div>
        <div class="form-group mb-2">
            <strong>Monto:</strong> {{ '$' . number_format($prestamo->monto, 0, ',', '.') }}
        </div>
        <div class="form-group mb-2">
            <strong>Cuotas:</strong> {{ $prestamo->cuotas }}
        </div>
        
        <div class="form-group mb-2">
            <strong>Interés Porcentaje:</strong> {{ $prestamo->interes_porcentaje }}%
        </div>
        <div class="form-group mb-2">
            <strong>Modalidad de Pago:</strong> {{ ucfirst($prestamo->modalidad_pago) }}
        </div>
        <div class="form-group mb-2">
            <strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}
        </div>

        {{-- Estado del préstamo --}}
        @php
            $totalAbonado = $prestamo->pagos->sum('monto_abono');
            $estado = $totalAbonado >= $prestamo->monto ? 'Pagado' : 'Pendiente';

            // Cálculo de cuotas restantes
            $modalidad = $prestamo->modalidad_pago;
            $cuotasTotales = $prestamo->cuotas;

            // Cuotas por mes según modalidad
            if ($modalidad === 'Mensual') {
                $cuotasPorMes = 1;
            } elseif ($modalidad === 'Quincenal') {
                $cuotasPorMes = 2;
            } elseif ($modalidad === 'Decadal') {
                $cuotasPorMes = 3;
            } else {
                $cuotasPorMes = 1;
            }

            // Cuotas restantes
            $cuotasRestantes = $cuotasTotales - $prestamo->pagos->count();

            // Si el saldo está saldado, forzar a 0 cuotas restantes
            if (($prestamo->monto - $totalAbonado) <= 0) {
                $cuotasRestantes = 0;
            }

        @endphp

        <div class="alert alert-info mt-3">
            <strong>Saldo pendiente:</strong> {{ '$' . number_format($prestamo->monto - $totalAbonado, 0, ',', '.') }}<br>
            <strong>Estado:</strong>
            @if($estado === 'Pagado')
                <span class="badge badge-success">Pagado</span>
            @else
                <span class="badge badge-warning">Pendiente</span>
            @endif
        </div>
        <div class="form-group mb-2">
            <strong>Cuotas restantes:</strong> {{ $cuotasRestantes }}
        </div>


        {{-- Tabla de abonos realizados --}}
        <h5>Abonos realizados</h5>
        @if($prestamo->pagos->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamo->pagos as $pagoRealizado)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pagoRealizado->fecha_pago)->format('d/m/Y') }}</td>
                            <td>{{ '$' . number_format($pagoRealizado->monto_abono, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Total abonado:</strong></td>
                        <td>{{ '$' . number_format($totalAbonado, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>No hay abonos registrados aún.</p>
        @endif
    </div>
</div>
@endsection

