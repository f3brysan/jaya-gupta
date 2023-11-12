<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\PesertaDidik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PesertaDidikImport implements ToModel, WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {

        $bin = PesertaDidik::get();

        // Get all bin number from the $bin collection
        $bin_number = $bin->pluck('nik');
        // $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('Y-m-d');
        if ($bin_number->contains($row['7']) == false) {
            return new PesertaDidik([
                'sekolah_npsn' => auth()->user()->bio->asal_satuan_pendidikan,
                'nama' => $row[1],
                'nipd' => $row[2],
                'jk' => $row[3],
                'nisn' => $row[4],
                'tempatlahir' => $row[5],
                // 'tanggal_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])),
                'tgllahir' => $row[6],
                // 'tgllahir' => $date,
                'nik' => $row[7],
                'agama' => $row[8],
                'alamat' => $row[9],
                'hp' => $row[10],
                'nama_ayah' => $row[11],
                'pendidikan_ayah' => $row[12],
                'pekerjaan_ayah' => $row[13],
                'nama_ibu' => $row[14],
                'pendidikan_ibu' => $row[15],
                'pekerjaan_ibu' => $row[16],
                'nama_wali' => $row[17],
                'pendidikan_wali' => $row[18],
                'pekerjaan_wali' => $row[19],
                'rombel' => $row[20],
                'kebutuhan_khusus' => $row[21],
                'sekolah_asal' => $row[22],
                'anak_ke' => $row[23],
                'no_kk' => $row[24],
                'bb' => $row[25],
                'tb' => $row[26],
                'lingkar_kepala' => $row[27],
                'jml_saudara' => $row[28],
                'jarak_sekolah' => $row[29],
            ]);
        }else{
            NULL;
        }
       
    }

    public function startRow(): int
    {
        return 3;
    }
}
