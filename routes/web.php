<?php

use App\Exports\AgendaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\rekapAgendaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\suratKeluarController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('surat',function(){
//     return view('surat.index');
// });
// Route::get('surat/disposisi',function(){
//     return view('surat.create');
// });
// Route::get('surat/coba',function(){
//     return view('surat.show');
// });

// Testing
// Route::get('beranda', function(){
//     return view('coba');
// });

// Route::get('upload', [App\Http\Controllers\HomeController::class, 'coba']);

Route::resource('/', HomeController::class);
Route::resource('surat', SuratController::class);
Route::resource('suratKeluar', suratKeluarController::class);
Route::patch('/surat/{id}/status/{status}', [SuratController::class, 'updateStatus'])->name('surat.updateStatus');
Route::get('/file/{jenis}/{id}', [HomeController::class, 'showFile'])->name('surat.file');
Route::get('/surat/download/{id}', [HomeController::class, 'downloadFile']);
Route::get('/surat/view/{surat}', [SuratController::class, 'viewFile'])->name('surat_masuk.view');
Route::get('/suratkeluar/view/{surat}', [suratKeluarController::class, 'viewFile'])->name('surat_keluar.view');
Route::resource('agenda', rekapAgendaController::class);
Route::get('/export-surat', function (Request $request) {
    $jenis_surat = $request->input('jenis_surat');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    return Excel::download(new AgendaExport($jenis_surat, $bulan, $tahun), 'rekap_surat.xlsx');
})->name('export.surat');



