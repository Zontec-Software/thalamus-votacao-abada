@extends('layouts.app')

@section('title', 'Apuração - Ranking')

@section('content')
    <h1>📊 Apuração - Ranking</h1>

    <a href="{{ route('votacao.index') }}" class="btn-apuracao">← Voltar para Votação</a>

    @if($ranking->count() > 0)
        <div class="ranking-list">
            @foreach($ranking as $index => $item)
                <div class="ranking-item">
                    <div class="ranking-posicao">
                        @if($index === 0)
                            🥇
                        @elseif($index === 1)
                            🥈
                        @elseif($index === 2)
                            🥉
                        @else
                            {{ $index + 1 }}º
                        @endif
                    </div>
                    <div class="ranking-info">
                        <div class="ranking-nome">{{ $item->nome_completo }}</div>
                        <div class="ranking-votos">{{ $item->total_votos }} {{ $item->total_votos == 1 ? 'voto' : 'votos' }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-votos">
            Total de votos: {{ $totalVotos }}
        </div>
    @else
        <div class="loading">
            <p>Ainda não há votos registrados.</p>
        </div>
    @endif
@endsection

