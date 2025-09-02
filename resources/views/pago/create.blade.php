@extends('layouts.app')

@section('template_title')
    Registrar Abono
@endsection

@section('content')
<div class="container">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h4>Datos del Préstamo</h4>
        <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}"> {{ __('Atras') }}</a>
    </div>
    
    <ul>
        <li><strong>Cliente:</strong> {{ $prestamo->cliente?->nombres ?? 'Cliente no asignado' }}</li>
        <li><strong>Cuotas:</strong> {{ $prestamo->cuotas }}</li>
        <li><strong>Modalidad:</strong> {{ $prestamo->modalidad_pago }}</li>
        <li><strong>Fecha Inicio:</strong> {{ $prestamo->fecha_inicio }}</li>
        <li><strong>Monto Base:</strong> {{ '$' . number_format($prestamo->monto, 0, ',', '.') }}</li>
    </ul>
    
    <hr>
    
    @php
        // Datos base
        $modalidad = $prestamo->modalidad_pago;
        $cuotas = $prestamo->cuotas;
        $monto = $prestamo->monto;
        $interes_porcentaje = $prestamo->interes_porcentaje;
    
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
    
        // Duración en meses
        $duracionMeses = $cuotasPorMes > 0 ? ceil($cuotas / $cuotasPorMes) : 0;
    
        // Interés total
        $interesTotal = ($monto * $interes_porcentaje / 100) * $duracionMeses;
    
        // Saldo final con interés
        $saldoFinal = $monto + $interesTotal;
    
        // Total abonado
        $totalPagado = $prestamo->pagos->sum('monto_abono');
    
        // Saldo pendiente real
        $saldoPendiente = $saldoFinal - $totalPagado;

    @endphp
    
    <div class="alert alert-info mt-3">
        <strong>Saldo pendiente con interés:</strong> {{ '$' . number_format($saldoPendiente, 0, ',', '.') }}<br>
        <strong>Interés total aplicado:</strong> {{ '$' . number_format($interesTotal, 0, ',', '.') }}<br>
        <strong>Total abonado:</strong> {{ '$' . number_format($totalPagado, 0, ',', '.') }}
    </div>
    <form action="{{ route('pagos.store') }}" method="POST">
        @csrf
        @include('pago.form', ['pago' => $pago, 'prestamo' => $prestamo])
    </form>

    <hr>

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
        </table>
    @else
        <p>No hay abonos registrados aún.</p>
    @endif
</div>
@endsection