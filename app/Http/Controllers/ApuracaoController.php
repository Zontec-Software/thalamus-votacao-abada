<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use Illuminate\Http\Request;

class ApuracaoController extends Controller
{
    public function index()
    {
        $ranking = Voto::selectRaw('pessoa_id, nome_completo, COUNT(*) as total_votos')
            ->groupBy('pessoa_id', 'nome_completo')
            ->orderByDesc('total_votos')
            ->get();

        $totalVotos = Voto::count();

        return view('apuracao.index', compact('ranking', 'totalVotos'));
    }
}

