<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PagoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Prestamo;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagos = Pago::paginate();

        return view('pago.index', compact('pagos'))
            ->with('i', ($request->input('page', 1) - 1) * $pagos->perPage());
            $pagos = Pago::with('prestamo.cliente')->paginate();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        
        $prestamoId = $request->prestamo;
        $prestamo = Prestamo::with('cliente', 'pagos')->findOrFail($prestamoId);
        $pago = new Pago(); // Para el formulario
    
        return view('pago.create', compact('pago', 'prestamo'))
        ->with('success', 'Abono registrado correctamente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request): RedirectResponse
    {
        
        Pago::create($request->validated());

        
        return redirect()->route('pagos.create', ['prestamo' => $request->prestamo_id])
        ->with('success', 'Abono registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $prestamo = Prestamo::find($id);

        return view('prestamo.show', compact('prestamo'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pago = Pago::findOrFail($id);
        $prestamo = $pago->prestamo;
    
        return view('pago.edit', compact('pago', 'prestamo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago): RedirectResponse
    {
        $pago->update($request->validated());

        return Redirect::route('prestamos.show', $pago->prestamo_id)
            ->with('success', 'Pago actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Pago::find($id)->delete();

        return Redirect::route('pagos.index')
            ->with('success', 'Pago eliminado exitosamente');
    }
}
