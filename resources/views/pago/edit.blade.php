@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Pago
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Pago</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('pagos.update', $pago->id) }}" role="form" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH') {{-- O usa PUT si estás actualizando todo el recurso --}}
                            
                            @include('pago.form', ['pago' => $pago, 'prestamo' => $prestamo])
                            
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
