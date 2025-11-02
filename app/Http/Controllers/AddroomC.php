<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\addroom;
use Illuminate\Validation\ValidationException;

class AddroomC extends Controller
{
    /**
     * Guarda una nueva habitación (pensión) asociada al propietario autenticado.
     */
    public function store(Request $request, addroom $addroom)
{
    try {
            // Ejecutar la acción y capturar el objeto creado
            $pension = $addroom->handle(Auth::user(), $request->all());
            return back()->with('success', 'Habitación registrada correctamente.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator->errors())
                ->withInput();

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al registrar la habitación: ' . $e->getMessage());
        }
    }

}
