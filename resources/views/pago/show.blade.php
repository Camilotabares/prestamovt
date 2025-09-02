@extends('layouts.app')

@section('template_title')
    {{ $pago->name ?? __('Show') . " " . __('Pago') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Pago</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('pagos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                                <h5 class="mb-3">
                                    {{ $pago->prestamo->cliente->nombre }} - {{ $pago->prestamo->created_at->format('d/m/Y') }}
                                </h5>
                                <div class="form-group mb-2 mb20">
                                    <strong>p</strong>
                                    {{ $pago->prestamo_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Pago:</strong>
                                    {{ $pago->fecha_pago }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Monto Abono:</strong>
                                    {{ $pago->monto_abono }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
