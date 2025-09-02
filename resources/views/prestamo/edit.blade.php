@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Prestamo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="card-title">{{ __('Update') }} Prestamo</span>
                        <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}"> {{ __('Atras') }}</a>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('prestamos.update', $prestamo->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('prestamo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
