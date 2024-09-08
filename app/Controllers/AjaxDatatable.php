<?php  
namespace App\Controllers;

use \Hermawan\DataTables\DataTable;

class AjaxDatatable extends BaseController
{

    public function __construct() {
        $this->db = db_connect();
    }
    
    public function agama()
    {
        $builder = $this->db->table('ref_agama')->select('id_agama, nama_agama');
        
        return DataTable::of($builder)->toJson();
    }

    public function kecamatan()
    {
        $builder = $this->db->table('ref_kecamatan')->select('id_kecamatan, nama_kecamatan');
        
        return DataTable::of($builder)->toJson();
    }

    public function desa()
    {
        $builder = $this->db->table('ref_desa as t')
        ->select('t.id_desa, t.nama_desa, k.nama_kecamatan')
        ->join('ref_kecamatan as k', 't.fid_kecamatan=k.id_kecamatan', 'left');
        
        return DataTable::of($builder)->toJson();
    }

    public function jenis_workshop()
    {
        $builder = $this->db->table('ref_jenis_workshop')->select('id_jenis_workshop, nama_jenis_workshop');
        
        return DataTable::of($builder)->toJson();
    }

    public function jurusan_pendidikan()
    {
        $builder = $this->db->table('ref_jurusan_pendidikan as t')
        ->select('t.id_jurusan_pendidikan, t.nama_jurusan_pendidikan, k.nama_tingkat_pendidikan')
        ->join('ref_tingkat_pendidikan as k', 't.fid_tingkat_pendidikan=k.id_tingkat_pendidikan', 'left');
        
        return DataTable::of($builder)->toJson();
    }

    public function rumpun_diklat()
    {
        $builder = $this->db->table('ref_rumpun_diklat')->select('id_rumpun_diklat, nama_rumpun_diklat');
        
        return DataTable::of($builder)->toJson();
    }

    public function satuan_unit_kerja()
    {
        $builder = $this->db->table('ref_unit_kerja u')
        ->select('u.id_unit_kerja,u.nama_unit_kerja,u.aktif,u.link_google_map,k.nama_kecamatan')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan');

        return DataTable::of($builder)
        ->format('nama_kecamatan', function($value){
            return strtoupper($value);
        })
        ->format('aktif', function($value){
            if($value === 'Y') return "<span class='badge bg-success p-2'>Enable</span>";
            return"<span class='badge bg-secondary p-2'>Disabled</span>";
        })
        ->add('action', function($row){
            $flagIs = $row->aktif === "Y" ? "Off" : "On";
            return '<button type="button" class="btn btn-danger btn-sm" onClick="HapusFn('.$row->id_unit_kerja.')"><i class="bx bx-trash-alt"></i>Hapus</button> 
            <button type="button" class="btn '.($row->aktif === "Y" ? "btn-secondary" : "btn-success").' btn-sm" onClick="FlagFn('.$row->id_unit_kerja.',\''.$row->aktif.'\')"><i class="bx bx-flag"></i>Flag '.$flagIs.'</button>
            <a href="'.base_url("app/referensi/satuan_unit_kerja/edit/".$row->id_unit_kerja).'" class="btn btn-warning btn-sm"><i class="bx bx-message-square-edit"></i>Edit</a>
            <button type="button" class="btn btn-info btn-sm" onClick="LocationFn(\''.$row->link_google_map.'\')"><i class="bx bx-map-alt"></i>Maps</button> ';
        }, 'first')
        ->toJson(true);
    }
}

?>