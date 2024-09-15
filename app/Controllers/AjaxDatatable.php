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

    public function tingkat_pendidikan()
    {
        $builder = $this->db->table('ref_tingkat_pendidikan');
        return DataTable::of($builder)->toJson();
    }

    public function jurusan_pendidikan()
    {
        $builder = $this->db->table('ref_jurusan_pendidikan t')
        ->select('t.id_jurusan_pendidikan, t.nama_jurusan_pendidikan, k.nama_tingkat_pendidikan')
        ->join('ref_tingkat_pendidikan k', 't.fid_tingkat_pendidikan=k.id_tingkat_pendidikan', 'left');
        
        return DataTable::of($builder)->toJson();
    }

    public function rumpun_diklat()
    {
        $builder = $this->db->table('ref_rumpun_diklat')->select('id_rumpun_diklat, nama_rumpun_diklat');
        
        return DataTable::of($builder)->toJson();
    }

    public function satuan_unit_kerja()
    {
        helper(['googlemap']);

        $builder = $this->db->table('ref_unit_kerja u')
        ->select('u.id_unit_kerja,u.nama_unit_kerja,u.aktif,u.latitude,u.longitude,u.link_google_map,k.nama_kecamatan')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan', 'left');

        return DataTable::of($builder)
        ->format('nama_kecamatan', function($value){
            return strtoupper($value);
        })
        ->format('aktif', function($value){
            if($value === 'Y') return "<span class='badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> enable</span>";
            return"<span class='badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> disabled</span>";
        })
        ->add('action', function($row){
            $map_address = extractAddressFromGoogleMapsURL($row->link_google_map);
            $map_title = $row->nama_unit_kerja;
            $flagIs = $row->aktif === "Y" ? "Off" : "On";
            return '<div class="d-flex gap-2">
                    <button type="button" class="btn '.($row->aktif === "Y" ? "btn-secondary" : "btn-success").' btn-sm" onClick="FlagFn('.$row->id_unit_kerja.',\''.$row->aktif.'\')"><i class="bx bx-flag"></i>Flag '.$flagIs.'</button>
                    <button type="button" class="btn btn-info btn-sm" onClick="LocationFn(\''.$map_title.'\',\''.$row->latitude.'\',\''.$row->longitude.'\')"><i class="bx bx-map-alt"></i> Maps</button> 
                        <button type="button" class="btn btn-danger btn-sm" onClick="HapusFn('.$row->id_unit_kerja.')"><i class="bx bx-trash-alt"></i>Hapus</button> 
                        <a href="'.base_url("app/referensi/satuan_unit_kerja/edit/".$row->id_unit_kerja).'" class="btn btn-warning btn-sm"><i class="bx bx-message-square-edit"></i>Edit</a>
                    </div>';
        }, 'first')
        ->toJson(true);

    }

    public function jabatan_atasan(int $id)
    {
        $builder = $this->db->table('ref_jabatan')->select('nama_jabatan')->where('id', $id)->get();
        $row = $builder->getRow();
        return $row->nama_jabatan;
    }

    public function jabatan() 
    {
        helper('number');

        $builder = $this->db->table('ref_jabatan')->select('id,nama_jabatan,id_atasan,jenis,gaji,tunjangan');
        
        return DataTable::of($builder)
        ->setSearchableColumns(['nama_jabatan', 'jenis', 'gaji', ])
        ->format('id_atasan', function($value) {
            if($value === "0") return "-";
            return $this->jabatan_atasan($value);
        })
        ->format('gaji', function($value) {
            return number_to_currency($value, 'IDR', 'id_ID', 0);
        })
        ->format('tunjangan', function($value) {
            return number_to_currency($value, 'IDR', 'id_ID', 0);
        })
        ->postQuery(function($query){

            $query->orderBy('id', 'desc');
    
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="EditFn" data-uid="'.$row->id.'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="HapusFn" data-uid="'.$row->id.'">Hapus <i class="bx bx-trash-alt"></i></button></li>
                        </ul>
                    </div>';
        })
        ->addNumbering("no")->toJson(true);
    }

    public function pegawai() {
    
        helper(["hash", "pegawai"]);

        $builder = $this->db->table('pegawai')
        ->select('nik,nipd,nama,gelar_depan,gelar_blk,jns_kelamin,fid_unit_kerja,photo,status,nama_unit_kerja')
        ->join('ref_unit_kerja', 'pegawai.fid_unit_kerja=ref_unit_kerja.id_unit_kerja', 'left')
        ->orderBy("created_at", 'desc');
        
        return DataTable::of($builder)
        ->setSearchableColumns(['nik', 'nipd', 'nama', 'status'])
        ->format('status', function($value){
            if($value === 'ENTRI') return "<span class='badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> entri</span>";
            if($value === 'ENTRI_ULANG') return "<span class='badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> entri ulang</span>";
            if($value === 'VERIFIKASI') return "<span class='badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> verifikasi</span>";
            if($value === 'AKTIF') return "<span class='badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> aktif</span>";
            if($value === 'NON_AKTIF') return "<span class='badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> non aktif</span>";
            return"<span class='badge rounded-pill text-white-50 bg-dark p-2 text-uppercase px-3'><i class='bx bxs-circle me-1'></i> NON AKTIF-NIK DITOLAK</span>";
        })
        ->edit('nama', function($row) {
            return namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        })
        ->format('photo', function($value) {
            return '<a href="'.base_url("assets/images/users/".$value).'" target="_blank"><img src="'.base_url("assets/images/users/".$value).'" class="user-img" alt="'.$value.'"></a>';
        })
        ->add('action', function($row) {
            $verif = $row->status === 'VERIFIKASI' || $row->status === 'AKTIF' || $row->status === 'NON_AKTIF' || $row->status === 'NON_AKTIF_NIK_DITOLAK' ? 
            '<li><a href="'.base_url("/app/master/pegawai/peremajaan?token=".dohash($row->nik)).'" id="verifikasi" data-uid="'.dohash($row->nik).'" class="dropdown-item text-primary d-flex justify-content-between align-items-center">Verifikasi <i class="bx bx-check-circle"></i></a></li>' : 
            '<li><a href="'.base_url("/app/master/pegawai/peremajaan?token=".dohash($row->nik)).'" class="dropdown-item text-secondary d-flex justify-content-between align-items-center">Perbaharui <i class="bx bx-edit-alt"></i></a></li>';
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            '.$verif.'
                        </ul>
                    </div>';
        })->toJson(true);
    }

    public function users() {
    
        helper(["hash", "pegawai"]);

        $builder = $this->db->table('users s')
        ->select('p.nik,p.nipd,p.nama,s.username,s.is_disabled,s.role,p.gelar_depan,p.gelar_blk,p.jns_kelamin,p.fid_unit_kerja,p.photo,u.nama_unit_kerja')
        ->join('pegawai p','s.nik=p.nik', 'left')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
        ->orderBy("p.created_at", 'desc');
        
        return DataTable::of($builder)
        ->setSearchableColumns(['p.nik', 'p.nipd', 'p.nama', 's.username'])
        ->edit('nama', function($row) {
            return namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk)."<br/><span class='badge bg-light-primary text-primary'>".$row->role."</span>";
        })
        ->format('photo', function($value) {
            return '<a href="'.base_url("assets/images/users/".$value).'" target="_blank"><img src="'.base_url("assets/images/users/".$value).'" class="user-img" alt="'.$value.'"></a>';
        })
        ->add('action', function($row) {
            $isDisabled = $row->is_disabled === 'Y' ? 'Enabled' : 'Disabled';
            $isDisabledTextColor = $row->is_disabled === 'Y' ? 'text-success' : 'text-danger';
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="EditFn" data-uid="'.$row->nik.'">Reset Password <i class="bx bx-key"></i></button></li>
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="SetRoleFn" data-uid="'.$row->nik.'" data-rolenow="'.$row->role.'">Setting Role <i class="bx bx-lock-open"></i></button></li>
                            <li><button type="button" class="dropdown-item '.$isDisabledTextColor.' d-flex justify-content-between align-items-center" id="DisabledFn" data-status="'.$row->is_disabled.'" data-uid="'.$row->nik.'">'.$isDisabled.' <i class="bx bx-block"></i></button></li>
                        </ul>
                    </div>';
        })->toJson(true);
    }
}

?>