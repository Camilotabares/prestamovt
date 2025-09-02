@extends('layouts.app')

@section('template_title')
    Prestamos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Prestamos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('prestamos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear nuevo Prestamo ') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <form action="{{ route('prestamos.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre de cliente" value="{{ request('buscar') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                    <th>No</th>
                                    <th >Estado</th>
									<th >Cliente</th>
									<th >Monto</th>
									<th >Cuotas</th>
									<th >Interes Porcentaje</th>
                                    <th>Modalidad de pagos</th>
									<th >Fecha Inicio</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $prestamo)
                                    @php
                                        $modalidad = $prestamo->modalidad_pago;
                                        $cuotas = $prestamo->cuotas;
                                        $monto = $prestamo->monto;
                                        $interes_porcentaje = $prestamo->interes_porcentaje;

                                        // Cuotas por mes según modalidad
                                        $cuotasPorMes = match($modalidad) {
                                            'Mensual' => 1,
                                            'Quincenal' => 2,
                                            'Decadal' => 3,
                                            default => 1,
                                        };

                                        // Duración en meses
                                        $duracionMeses = $cuotasPorMes > 0 ? ceil($cuotas / $cuotasPorMes) : 0;

                                        // Interés total
                                        $interesTotal = ($monto * $interes_porcentaje / 100) * $duracionMeses;

                                        // Saldo final
                                        $saldoFinal = $monto + $interesTotal;

                                        // Pagos realizados
                                        $totalPagado = $prestamo->pagos->sum('monto_abono');

                                        // Saldo pendiente
                                        $saldoPendiente = $saldoFinal - $totalPagado;
                                    @endphp

                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            @if($saldoPendiente <= 0)
                                           
                                                <span class="badge badge-success">Estado: Pagado</span>
                                            @else
                                                <span class="badge badge-warning">Estado: Pendiente</span>
                                            @endif
                                           
                                            <br>
                                            <strong>Saldo pendiente:</strong> {{ '$' . number_format($saldoPendiente, 0, ',', '.') }}<br>
                                            
                                        </td>
                                    
                                
                                            
										<td >{{ $prestamo->cliente->nombres }}</td>
										<td >{{ number_format($prestamo->monto, 0, ',', '.') }}</td>
										<td >{{ $prestamo->cuotas }}</td>
										<td >{{ $prestamo->interes_porcentaje }}%</td>
                                        <td >{{ $prestamo->modalidad_pago }}</td>
										<td >{{ $prestamo->fecha_inicio }}</td>

                                            <td>
                                                <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-secondary " href="{{ route('prestamos.show', $prestamo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('prestamos.edit', $prestamo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    <a href="{{ route('pagos.create', ['prestamo' => $prestamo->id]) }}" class="btn btn-sm btn-success">
                                                        Abonar
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Esta seguro de Eliminar el Prestamo?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $prestamos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
