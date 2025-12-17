<?php

use App\Http\Controllers\VotacaoController;
use App\Http\Controllers\ApuracaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VotacaoController::class, 'index'])->name('votacao.index');
Route::post('/votar', [VotacaoController::class, 'votar'])->name('votacao.votar');
Route::get('/apuracao', [ApuracaoController::class, 'index'])->name('apuracao.index');

