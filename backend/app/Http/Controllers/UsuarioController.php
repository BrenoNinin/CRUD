<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        return Usuario::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'senha' => $request->senha
        ]);

        return $usuario;
    }

    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}
