<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\studentCntroller;

Route::get('/students', [studentCntroller::class, 'index']);
Route::get('/students/{id}', [studentCntroller::class, 'show']);

Route::post('/students', [studentCntroller::class,'store']);

Route::put('/students/{id}', [studentCntroller::class, 'update']);
Route::patch('/students/{id}', [studentCntroller::class, 'updatePartial']);

Route::delete('/students/{id}', [studentCntroller::class, 'destroy']);