@extends('layouts.app')

@section('template_title')
    Clientes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Clientes') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo Cliente') }}
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
                        <form action="{{ route('clientes.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="buscar" class="form-control" placeholder="Buscar Por cedula del cliente" value="{{ request('buscar') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                </div>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Cedula</th>
									<th >Nombres</th>
									<th >Direccion</th>
									<th >Telefono</th>
									<th >Empresa</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $cliente->cedula }}</td>
                                        <td>{{ $cliente->nombres }}</td>
                                        <td class="d-none d-md-table-cell">{{ $cliente->direccion }}</td>
                                        <td class="d-none d-md-table-cell">{{ $cliente->telefono }}</td>
                                        <td class="d-none d-md-table-cell">{{ $cliente->empresa }}</td>
                                        <td>
                                            <div class="d-flex flex-column flex-md-row gap-1">
                                                <a class="btn btn-sm btn-secondary" href="{{ route('clientes.show', $cliente->id) }}">Ver</a>
                                                <a class="btn btn-sm btn-primary" href="{{ route('clientes.edit', $cliente->id) }}">Editar</a>
                                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar cliente?')">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $clientes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
