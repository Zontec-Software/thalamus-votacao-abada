<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VotacaoController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get(env('API_THALAMUS_URL', 'https://api.thalamus.ind.br') . '/api/pessoas-abada');
            
            if ($response->successful()) {
                $funcionarios = $response->json();
            } else {
                $funcionarios = [];
            }
        } catch (\Exception $e) {
            Log::error('Erro ao buscar funcionários: ' . $e->getMessage());
            $funcionarios = [];
        }

        return view('votacao.index', compact('funcionarios'));
    }

    public function votar(Request $request)
    {
        $request->validate([
            'pessoa_id' => 'required|integer',
            'nome_completo' => 'required|string',
            'mac_address' => 'required|string',
        ]);

        // Verifica se já votou com este MAC address
        $votoExistente = Voto::where('mac_address', $request->mac_address)->first();
        
        if ($votoExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Você já votou! Cada dispositivo pode votar apenas uma vez.'
            ], 400);
        }

        // Registra o voto
        Voto::create([
            'pessoa_id' => $request->pessoa_id,
            'nome_completo' => $request->nome_completo,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voto registrado com sucesso!'
        ]);
    }
}

