<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Cliente;
use App\Models\Pago;


class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $buscar = $request->get('buscar');

    $prestamos = Prestamo::with('cliente','pagos')
        ->when($buscar, function ($query, $buscar) {
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('nombres', 'like', '%' . $buscar . '%');
            });
        })
        ->paginate(10);
        

        return view('prestamo.index', compact('prestamos'))
            ->with('i', ($request->input('page', 1) - 1) * $prestamos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $prestamo = new Prestamo();
        $clientes = Cliente::pluck('nombres', 'id');
        return view('prestamo.create', compact('prestamo', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrestamoRequest $request): RedirectResponse
    {
        Prestamo::create($request->validated());

        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
       $prestamo = Prestamo::find($id);
       $pago = new Pago();

        return view('prestamo.show', compact('prestamo','pago'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $prestamo = Prestamo::find($id);
        $clientes = Cliente::pluck('nombres', 'id'); // Esto genera un array [id => nombre]

        return view('prestamo.edit', compact('prestamo', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrestamoRequest $request, Prestamo $prestamo): RedirectResponse
    {
        
        $prestamo->update($request->validated());
        
        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo Actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Prestamo::find($id)->delete();

        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo eliminado  correctamente');
    }
}
