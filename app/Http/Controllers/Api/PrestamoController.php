<?php

namespace App\Http\Controllers\Api;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrestamoResource;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prestamos = Prestamo::paginate();

        return PrestamoResource::collection($prestamos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrestamoRequest $request): JsonResponse
    {
        $prestamo = Prestamo::create($request->validated());

        return response()->json(new PrestamoResource($prestamo));
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo): JsonResponse
    {
        return response()->json(new PrestamoResource($prestamo));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrestamoRequest $request, Prestamo $prestamo): JsonResponse
    {
        $prestamo->update($request->validated());

        return response()->json(new PrestamoResource($prestamo));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Prestamo $prestamo): Response
    {
        $prestamo->delete();

        return response()->noContent();
    }
}
