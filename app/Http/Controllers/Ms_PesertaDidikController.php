<?php

namespace App\Http\Controllers;

use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use App\Imports\PesertaDidikImport;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PesertaDidikTemplateExport;

class Ms_PesertaDidikController extends Controller
{
    public function index()
    {
        $data_peserta_didik = PesertaDidik::where('sekolah_npsn', auth()->user()->bio->asal_satuan_pendidikan)->get();
        return view('data_peserta_didik.index', compact('data_peserta_didik'));
    }

    public function export_template()
    {
        return Excel::download(new PesertaDidikTemplateExport(), 'template_peserta_didik.xlsx');
    }

    public function import(Request $request)
    {

        // validasi
        $this->validate($request, [
            'dokumen' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('dokumen');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('unggahan_excel', $nama_file);

        // import data
        Excel::import(new PesertaDidikImport, public_path('/unggahan_excel/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect(URL::to('data-peserta-didik'))->with('success', 'Data berhasil unggah.');
    }
}
