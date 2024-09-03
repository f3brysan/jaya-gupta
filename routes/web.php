<?php

use App\Http\Controllers\AksiNyataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataGTKNonAktifController;
use App\Http\Controllers\DataGuruController;
use App\Http\Controllers\DataPengawasController;
use App\Http\Controllers\DataTendikController;
use App\Http\Controllers\IndoController;
use App\Http\Controllers\InovasiController;
use App\Http\Controllers\Ms_BidangPengembanganController;
use App\Http\Controllers\Ms_MapelController;
use App\Http\Controllers\Ms_MataPelajaranController;
use App\Http\Controllers\Ms_PesertaDidikController;
use App\Http\Controllers\Ms_SatuanPendidikanController;
use App\Http\Controllers\Ms_Sekolah;
use App\Http\Controllers\Ms_SekolahController;
use App\Http\Controllers\Ms_UsersController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RekapGuruPenggerak;
use App\Http\Controllers\RekapPensiunController;
use App\Http\Controllers\RekapSebaranGuru;
use App\Http\Controllers\RekapSebaranTendik;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\SebaranGuruController;
use App\Http\Controllers\SebaranGuruKelasController;
use App\Http\Controllers\StatusInovasiController;
use App\Models\Ms_MataPelajaran;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'auth']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('get-praktik-baik', [DashboardController::class, 'get_praktik_baik']);
    Route::get('detil-praktik-baik/{id}', [DashboardController::class, 'detil_praktik_baik']);

    Route::get('biodata', [BiodataController::class, 'show']);
    Route::post('biodata/simpan', [BiodataController::class, 'store']);
    Route::post('biodata/tambah-bidang-pengembangan', [BiodataController::class, 'tambah_bidang_pengembangan']);
    Route::delete('biodata/hapus-bidang-pengembangan/{id}', [BiodataController::class, 'hapus_bidang_pengembangan']);

    Route::get('ganti-password', [BiodataController::class, 'show_password']);
    Route::post('ganti-password/simpan', [BiodataController::class, 'store_password']);
});

Route::middleware(['auth:web', 'role:superadmin|guru'])->group(function () {
    Route::get('guru/inovasi', [InovasiController::class, 'index']);
    Route::get('guru/inovasi/tambah/', [InovasiController::class, 'tambah']);
    Route::post('guru/inovasi/store/', [InovasiController::class, 'store']);
    Route::get('guru/inovasi/edit/{id}', [InovasiController::class, 'edit']);
    Route::post('guru/inovasi/hapus', [InovasiController::class, 'hapus']);

    Route::get('guru/aksi-nyata', [AksiNyataController::class, 'index']);
    Route::get('guru/aksi-nyata/tambah/', [AksiNyataController::class, 'tambah']);
    Route::post('guru/aksi-nyata/store/', [AksiNyataController::class, 'store']);
    Route::get('guru/aksi-nyata/edit/{id}', [AksiNyataController::class, 'edit']);
    Route::post('guru/aksi-nyata/hapus', [AksiNyataController::class, 'hapus']);
});

Route::middleware(['auth:web', 'role:superadmin|kurator'])->group(function () {
    Route::get('kurator/inovasi', [StatusInovasiController::class, 'index_inovasi']);
    Route::get('kurator/aksi-nyata', [StatusInovasiController::class, 'index_aksi']);
    Route::post('kurator/nilai', [StatusInovasiController::class, 'nilai']);
});

Route::middleware(['auth:web', 'role:superadmin|pimpinan'])->group(function () {
    Route::get('master/satuan-pendidikan', [Ms_SatuanPendidikanController::class, 'index']);

    Route::get('master/bidang-pengembangan', [Ms_BidangPengembanganController::class, 'index']);
    Route::post('master/bidang-pengembangan/store', [Ms_BidangPengembanganController::class, 'store']);
    Route::get('master/bidang-pengembangan/edit/{id}', [Ms_BidangPengembanganController::class, 'show']);
    Route::delete('master/bidang-pengembangan/delete/{id}', [Ms_BidangPengembanganController::class, 'delete']);

    Route::get('master/mata-pelajaran', [Ms_MapelController::class, 'index']);
    Route::post('master/mata-pelajaran/store', [Ms_MapelController::class, 'store']);
    Route::get('master/mata-pelajaran/edit/{id}', [Ms_MapelController::class, 'show']);
    Route::delete('master/mata-pelajaran/delete/{id}', [Ms_MapelController::class, 'delete']);

    Route::get('master/user', [Ms_UsersController::class, 'index']);
    Route::get('master/user-role/{id}', [Ms_UsersController::class, 'user_role']);
    Route::post('master/user-role/store', [Ms_UsersController::class, 'user_role_store']);
    Route::post('master/user/store', [Ms_UsersController::class, 'user_store']);
    Route::delete('master/user/delete/{id}', [Ms_UsersController::class, 'destroy']);
    Route::POST('master/user/loginas/{id}', [Ms_UsersController::class, 'loginas']);
    Route::get('master/sync-halo-guru', [Ms_UsersController::class, 'syncHaloGuru']);

    Route::get('rekap/data-pensiun', [RekapPensiunController::class, 'index']);
    Route::get('rekap/data-pensiun/negeri/{thn}/{bp}', [RekapPensiunController::class, 'show_pendidikan']);
    Route::get('rekap/data-pensiun/sekolah/{npsn}/{thn}', [RekapPensiunController::class, 'show_sekolah']);

    // Route::get('rekap/data-sebaran-guru', [RekapSebaranGuru::class, 'index']);
    Route::get('rekap/data-sebaran-guru/{bentuk_pendidikan}', [SebaranGuruController::class, 'index']);
    Route::get('rekap/data-sebaran-guru/kelas/{bentuk_pendidikan}', [SebaranGuruController::class, 'guru_kelas']);
    Route::get('rekap/data-sebaran-guru/kelas/rombel/{bentuk_pendidikan}/{status_sekolah}', [SebaranGuruController::class, 'rombel_sekolah']);
    Route::get('rekap/data-sebaran-guru/kelas/guru-kelas/{bentuk_pendidikan}/{status_sekolah}', [SebaranGuruController::class, 'guru_kelas_sekolah']);
    Route::get('rekap/data-sebaran-guru/kelas/kekurangan/{bentuk_pendidikan}/{status_sekolah}', [SebaranGuruController::class, 'kurang_guru']);
    Route::get('rekap/data-sebaran-guru/kelas/detil-guru-kelas/{npsn}', [SebaranGuruController::class, 'detil_guru_kelas_sekolah']);

    Route::get('rekap/data-sebaran-guru/mapel/{bentuk_pendidikan}/{mapel}', [SebaranGuruController::class, 'guru_mapel']);
    Route::get('rekap/data-sebaran-guru/mapel/sekolah/{bentuk_pendidikan}/{mapel}/{status_sekolah}', [SebaranGuruController::class, 'guru_mapel_sekolah']);
    Route::get('rekap/data-sebaran-guru/mapel/detil-guru-mapel/{npsn}/{mapel}', [SebaranGuruController::class, 'detil_guru_mapel_sekolah']);

    Route::get('rekap/data-sebaran-tendik', [RekapSebaranTendik::class, 'index']);
    Route::get('rekap/data-guru-penggerak', [RekapGuruPenggerak::class, 'index']);
});

Route::middleware(['auth:web', 'role:superadmin|kepalasekolah|operator|pimpinan'])->group(function () {
    Route::get('data-sekolah', [Ms_SekolahController::class, 'index']);
    Route::get('data-sekolah/show/{id_level_wil}/{kode_wil}', [Ms_SekolahController::class, 'sekolah_kec']);
    Route::get('data-sekolah/show-detail/{npsn}', [Ms_SekolahController::class, 'detil_sekolah']);
    Route::post('data-sekolah/pull-data', [Ms_SekolahController::class, 'pull_data']);

    route::get('data-guru', [DataGuruController::class, 'index']);
    // route::get('data-guru/tambah', [DataGuruController::class, 'create']);
    // route::post('data-guru/simpan', [DataGuruController::class, 'store']);
    route::get('data-guru/ubah/{id}', [DataGuruController::class, 'edit']);
    route::post('data-guru/update', [DataGuruController::class, 'update']);
    Route::post('data-guru/hapus', [DataGuruController::class, 'destroy']);
    Route::get('data-guru/export-template', [DataGuruController::class, 'export_template']);
    Route::POST('data-guru/import', [DataGuruController::class, 'import']);

    route::get('admin/data-guru', [DataGuruController::class, 'index_admin']);
    Route::get('admin/data-guru/show/{idwil}', [DataGuruController::class, 'show_admin']);
    Route::get('admin/data-guru/detail/{npsn}', [DataGuruController::class, 'detail_admin']);

    route::get('data-tendik', [DataTendikController::class, 'index']);
    Route::get('data-tendik/export-template', [DataTendikController::class, 'export_template']);
    Route::POST('data-tendik/import', [DataTendikController::class, 'import']);
    route::get('data-tendik/ubah/{id}', [DataTendikController::class, 'edit']);
    route::post('data-tendik/update', [DataTendikController::class, 'update']);
    Route::post('data-tendik/hapus', [DataTendikController::class, 'destroy']);

    route::get('admin/data-tendik', [DataTendikController::class, 'index_admin']);
    Route::get('admin/data-tendik/show/{idwil}', [DataTendikController::class, 'show_admin']);
    Route::get('admin/data-tendik/detail/{npsn}', [DataTendikController::class, 'detail_admin']);

    route::get('data-gtk-nonaktif', [DataGTKNonAktifController::class, 'index']);
    route::get('data-gtk-nonaktif/ubah/{id}', [DataGTKNonAktifController::class, 'edit']);
    route::post('data-gtk-nonaktif/update', [DataGTKNonAktifController::class, 'update']);
    route::get('admin/data-gtk-nonaktif', [DataGTKNonAktifController::class, 'index_admin']);
    route::get('admin/data-gtk-nonaktif/show/{idwil}', [DataGTKNonAktifController::class, 'show_admin']);
    route::get('admin/data-gtk-nonaktif/detail/{npsn}', [DataGTKNonAktifController::class, 'detail_admin']);

    Route::get('data-sekolah/edit-detail/{npsn}', [Ms_SekolahController::class, 'edit_sekolah']);
    Route::post('data-sekolah/update-detail', [Ms_SekolahController::class, 'update_sekolah']);

    Route::get('data-peserta-didik', [Ms_PesertaDidikController::class, 'index']);
    Route::get('data-peserta-didik/edit/{id}', [Ms_PesertaDidikController::class, 'edit']);
    Route::post('data-peserta-didik/simpan/', [Ms_PesertaDidikController::class, 'store']);
    Route::post('data-peserta-didik/hapus/', [Ms_PesertaDidikController::class, 'destroy']);
    Route::get('data-peserta-didik/export-template', [Ms_PesertaDidikController::class, 'export_template']);
    Route::POST('data-peserta-didik/import', [Ms_PesertaDidikController::class, 'import']);

    Route::get('admin/data-peserta-didik', [Ms_PesertaDidikController::class, 'index_admin']);
    Route::get('admin/data-peserta-didik/show/{idwil}', [Ms_PesertaDidikController::class, 'detail_sekolah_admin']);
    Route::get('admin/data-peserta-didik/detail/{idwil}', [Ms_PesertaDidikController::class, 'detail_pd_admin']);

    Route::get('data-rombel', [RombelController::class, 'index']);
    Route::get('data-rombel/tambah', [RombelController::class, 'create']);
    Route::get('data-rombel/edit/{id}', [RombelController::class, 'edit']);
    Route::post('data-rombel/simpan', [RombelController::class, 'store']);
    Route::post('data-rombel/hapus', [RombelController::class, 'destroy']);
    
    Route::get('admin/data-rombel', [RombelController::class, 'index_admin']);
    Route::get('admin/data-rombel/show/{idwil}', [RombelController::class, 'show_admin']);
    Route::get('admin/data-rombel/detail/{npsn}', [RombelController::class, 'detail_admin']);
    
    Route::get('admin/data-pengawas', [DataPengawasController::class, 'index_admin']);
    Route::get('admin/data-pengawas/tambah', [DataPengawasController::class, 'create']);
    Route::post('admin/data-pengawas/store', [DataPengawasController::class, 'store']);
});

Route::get('ajax/getkabupaten/{id}', [IndoController::class, 'getkabupaten']);
Route::get('ajax/getkecamatan/{id}', [IndoController::class, 'getkecamatan']);
Route::get('ajax/getkelurahan/{id}', [IndoController::class, 'getkelurahan']);