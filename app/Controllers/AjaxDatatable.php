<?php  
namespace App\Controllers;

use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

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

    public function pegawai() 
    {
    
        helper(["hash"]);

        $builder = $this->db->table('pegawai p')
        ->select('p.nik,p.nipd,p.nama,p.gelar_depan,p.gelar_blk,p.jns_kelamin,p.fid_unit_kerja,p.photo,p.status,
        u.nama_unit_kerja,j.nama_jabatan,s.role')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id','left')
        ->join('users s', 'p.nik=s.nik', 'left')
        ->whereNotIn('status', ['ENTRI','ENTRI_ULANG']);
        
        return DataTable::of($builder)
        ->setSearchableColumns(['p.nik', 'p.nipd', 'p.nama', 'p.status'])
        ->postQuery(function($query){
            $query->orderBy('p.created_at', 'desc');
        })
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
        ->edit('nama_unit_kerja', function($row) {
            return $row->nama_unit_kerja."<br><b>".isNull(ucwords(strtolower($row->nama_jabatan)))."</b>";
        })
        ->format('photo', function($value) {
            return '<a href="'.base_url("assets/images/users/".$value).'" target="_blank"><img src="'.base_url("assets/images/users/".$value).'" class="user-img" alt="'.$value.'"></a>';
        })
        ->format('role', function($value) {
            if ($value && $value === "OPERATOR") return "<span class='badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3'><i class='bx bxs-user me-1'></i> ".$value."</span>";
            if ($value && $value === "USER") return "<span class='badge rounded-pill text-white bg-success p-2 text-uppercase px-3'><i class='bx bxs-user me-1'></i> ".$value."</span>";
            if ($value && $value === "ADMIN") return "<span class='badge rounded-pill text-white bg-primary p-2 text-uppercase px-3'><i class='bx bxs-user me-1'></i> ".$value."</span>";
            return "";
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

    public function users() 
    {
    
        helper(["hash"]);

        $builder = $this->db->table('users s')
        ->select('s.nik,p.nipd,p.nama,s.username,s.is_disabled,s.role,p.gelar_depan,p.gelar_blk,p.jns_kelamin,p.fid_unit_kerja,p.photo,u.nama_unit_kerja')
        ->join('pegawai p','s.nik=p.nik', 'left')
        ->join('ref_unit_kerja u', 's.fid_unit_kerja=u.id_unit_kerja', 'left')
        ->when(session()->role, static function($query, $status) {
            if($status === 'USER') {
                $query->whereIn('role', ['OPERATOR']);
            }
        });
        
        return DataTable::of($builder)
        ->setSearchableColumns(['p.nik', 'p.nipd', 'p.nama', 's.username'])
        ->postQuery(function($query){
            $query->orderBy('p.created_at', 'desc');
        })
        ->edit('nama', function($row) {
            if($row->nama === null) {
                return "- <br/><span class='badge bg-light-primary text-primary'>".$row->role."</span>";
            }
            return namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk)."<br/><span class='badge bg-light-primary text-primary'>".$row->role."</span>";
        })
        ->format('photo', function($value) {
            if($value === null) {
                return '<a href="'.base_url("assets/images/users/default.png").'" target="_blank"><img src="'.base_url("assets/images/users/default.png").'" class="user-img" alt="default.png"></a>';
            }
            return '<a href="'.base_url("assets/images/users/".$value).'" target="_blank"><img src="'.base_url("assets/images/users/".$value).'" class="user-img" alt="'.$value.'"></a>';
        })
        ->add('action', function($row) {
            $isDisabled = $row->is_disabled === 'Y' ? 'Enabled' : 'Disabled';
            $isDisabledTextColor = $row->is_disabled === 'Y' ? 'text-success' : 'text-danger';

            if(session()->role === 'USER') {
                return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="EditFn" data-uid="'.$row->nik.'">Reset Password <i class="bx bx-key"></i></button></li>
                            <li><button type="button" class="dropdown-item '.$isDisabledTextColor.' d-flex justify-content-between align-items-center" id="DisabledFn" data-status="'.$row->is_disabled.'" data-uid="'.$row->nik.'">'.$isDisabled.' <i class="bx bx-block"></i></button></li>
                        </ul>
                    </div>';
            }
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

    public function riwayat_pendidikan()
    {
        helper(["hash","tgl_indo"]);

        $builder = $this->db->table('riwayat_pendidikan rp')
        ->select('rp.id,rp.nik,rp.thn_lulus,rp.nama_sekolah,rp.nama_kepsek,rp.no_sttb,rp.tgl_sttb,rp.gelar_dpn,rp.gelar_blk,rp.berkas,tp.nama_tingkat_pendidikan,jp.nama_jurusan_pendidikan')
        ->join('ref_tingkat_pendidikan tp', 'rp.fid_tingkat=tp.id_tingkat_pendidikan')
        ->join('ref_jurusan_pendidikan jp', 'rp.fid_jurusan=jp.id_jurusan_pendidikan')
        ->where('rp.nik', $this->request->getPost('nik'));

        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('rp.created_at', 'desc');
        })
        ->edit('nama_tingkat_pendidikan', function($row) {
            $gd = $row->gelar_dpn !== "-" || $row->gelar_dpn !== "" ? "<span class='badge bg-light-primary text-primary'>$row->gelar_dpn</span>" : '';
            $gb = $row->gelar_blk !== "-" || $row->gelar_blk !== "" ? "<span class='badge bg-light-primary text-primary'>$row->gelar_blk</span>" : '';
            return $row->nama_tingkat_pendidikan."<br>".$row->nama_jurusan_pendidikan."<br>".$gd." ".$gb;
        })
        ->edit('no_sttb', function($row) {
            return $row->nama_kepsek."<br> Nomor : ".$row->no_sttb." <br> Tanggal : ".date_indo($row->tgl_sttb);
        })
        ->add('berkas', function($row) {
            if($row->berkas !== null && $row->berkas !== ""):
                return '<a href="'.base_url("assets/file_pendidikan/".$row->berkas).'" target="_blank" class="d-flex align-items-center justify-content-center text-success" title="'.$row->berkas.'"><i class="bx bxs-file bx-sm"></i></a>';
            else:
                return '<div class="w-100 text-center text-secondary">Belum ada</div>';
            endif;
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="upload-berkas" data-uid="'.$row->id.'" data-nik="'.$row->nik.'">Upload Berkas <i class="bx bx-upload"></i></button></li>
                            <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.$row->nik.'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.$row->id.'" data-nik="'.$row->nik.'" data-file="'.$row->berkas.'">Hapus <i class="bx bx-trash"></i></button></li>
                        </ul>
                    </div>';
        })
        ->toJson(true);
    }

    public function riwayat_jabatan()
    {
        helper(["hash","tgl_indo"]);
        $builder = $this->db->table('riwayat_jabatan rj')
        ->select('rj.id, rj.nik, rj.tmt_mulai, rj.tmt_selesai, rj.tgl_pelantikan, rj.pejabat_sk, rj.tgl_sk, rj.no_sk, rj.berkas, 
        u.nama_unit_kerja, ref_jab.nama_jabatan, ref_jab.jenis')
        ->join('ref_jabatan ref_jab', 'rj.fid_jabatan=ref_jab.id')
        ->join('ref_unit_kerja u', 'rj.fid_unit_kerja=u.id_unit_kerja')
        ->where('rj.nik', $this->request->getPost('nik'));
        
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('rj.created_at', 'desc');
        })
        ->edit('nama_jabatan', function($row) {
            return $row->nama_jabatan."<br><b>".$row->nama_unit_kerja."</b>";
        })
        ->edit('tmt_mulai', function($row) {
            return date_indo($row->tmt_mulai)." s/d ".date_indo($row->tmt_selesai);
        })
        ->edit('no_sk', function($row) {
            return $row->pejabat_sk."<br> Nomor : ".$row->no_sk." <br> Tanggal : ".date_indo($row->tgl_sk);
        })
        ->add('berkas', function($row) {
            if($row->berkas !== null && $row->berkas !== ""):
                return '<a href="'.base_url("assets/file_jabatan/".$row->berkas).'" target="_blank" class="d-flex align-items-center justify-content-center text-success" title="'.$row->berkas.'"><i class="bx bxs-file bx-sm"></i></a>';
            else:
                return '<div class="w-100 text-center text-secondary">Belum ada</div>';
            endif;
        })
        ->add('action', function($row) {
            if($this->db->resultID->num_rows > 1) {
                return '<div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                    <ul class="dropdown-menu" data-popper-placement="bottom-start">
                    <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="upload-berkas" data-uid="'.$row->id.'" data-nik="'.$row->nik.'">Upload Berkas <i class="bx bx-upload"></i></button></li>
                    <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.$row->nik.'">Edit <i class="bx bx-edit-alt"></i></button></li>
                    <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.$row->id.'" data-nik="'.$row->nik.'" data-file="'.$row->berkas.'">Hapus <i class="bx bx-trash"></i></button></li>
                    </ul>
                </div>';
            }
            return '<div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                    <ul class="dropdown-menu" data-popper-placement="bottom-start">
                    <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="upload-berkas" data-uid="'.$row->id.'" data-nik="'.$row->nik.'">Upload Berkas <i class="bx bx-upload"></i></button></li>
                    <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.$row->nik.'">Edit <i class="bx bx-edit-alt"></i></button></li>
                    </ul>
                </div>';
        })
        ->toJson(true);
    }

    protected function detail_sutri($nip)
    {
        helper(["hash"]);
        if($nip !== "" && $nip !== null)
        {
            $builder = $this->db->table('pegawai p')->select('status,nik,nipd,photo,nama')->where('nik', $nip)->get()->getRow();
            if($builder !== null)
            {
                if($builder->status === 'AKTIF'):
                    return '<div class="mb-2 chip chip-md">
                    <img src="'.base_url("assets/images/users/".$builder->photo).'" alt="'.$builder->nama.'" width="150" class="user-img"/><a href="'.base_url("app/pegawai/detail/".dohash($builder->nik)).'" title="'.$builder->nik.'">NIPD. '.$builder->nipd.'</a></div> <br>';
                endif;
                return '<div class="mb-2 chip chip-md"><img src="'.base_url("assets/images/users/".$builder->photo).'" alt="'.$builder->nama.'" width="150" class="user-img"/>NIPD. '.$builder->nipd.'</div><br>';
            }
            return "";
        }
    }

    public function riwayat_keluarga_sutri()
    {
        helper(["hash","tgl_indo"]);

        $builder = $this->db->table('riwayat_sutri')
        ->select('id,nik,nama_sutri,tgl_nikah,no_akta_nikah,tmp_lahir,tgl_lahir,status_kawin,status_hidup,tanggungan,
        tgl_cerai,no_akta_cerai,tgl_meninggal,no_akta_meninggal,nip_sutri,sutri_ke')
        ->where('nik', $this->request->getPost('nik'));
        
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('created_at', 'desc');
        })
        ->edit('nama_sutri', function($row) {
            return $this->detail_sutri($row->nip_sutri)."<b>".$row->nama_sutri."</b>";
        })
        ->edit('tgl_nikah', function($row) {
            return "<u>".date_indo($row->tgl_nikah)."</u><br><b>".$row->no_akta_nikah."</b>";
        })
        ->edit('tmp_lahir', function($row) {
            return "<u>".$row->tmp_lahir."</u><br><b>".date_indo($row->tgl_lahir)."</b>";
        })
        ->edit('status_kawin', function($row) {
            return "<u>".$row->status_kawin."</u><br>Status Hidup : <b>".$row->status_hidup."</b><br> Tanggungan : <b>".$row->tanggungan."</b>";
        })
        ->edit('tgl_cerai', function($row) {
            return "<u>".@date_indo($row->tgl_cerai)."</u><br><b>".$row->no_akta_cerai."</b>";
        })
        ->edit('tgl_meninggal', function($row) {
            return "<u>".@date_indo($row->tgl_meninggal)."</u><br><b>".$row->no_akta_meninggal."</b>";
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="status-cerai" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'" data-detail=\''.json_encode($row).'\'>Cerai <i class="bx bx-user-minus"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="status-meninggal" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'" data-detail=\''.json_encode($row).'\'>Meninggal <i class="bx bx-user-minus"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'" data-sutrike="'.$row->sutri_ke.'">Hapus <i class="bx bx-trash"></i></button></li>
                        </ul>
                    </div>';
        })
        ->toJson(true);
    }

    public function riwayat_keluarga_anak()
    {
        helper(["hash","tgl_indo"]);
        
        $pegawai = $this->db->table('pegawai')->select('jns_kelamin')->where('nik', $this->request->getPost('nik'))->get()->getRow();
        $sutri = $this->db->table('riwayat_sutri')->select('nik,nip_sutri,sutri_ke')->where('nik', $this->request->getPost('nik'))->get()->getRow();

        $builder = $this->db->table('riwayat_anak ra')
        ->select('ra.id,ra.nik,ra.nama_anak,ra.fid_sutri_ke,ra.jns_kelamin,ra.tmp_lahir,ra.tgl_lahir,ra.status,ra.status_hidup,ra.tanggungan,rs.nama_sutri')
        ->join('riwayat_sutri rs', 'ra.fid_sutri_ke=rs.sutri_ke', 'left')
        ->where('rs.nik', $this->request->getPost('nik'))
        ->groupStart()
            ->where('ra.nik', @$sutri->nip_sutri)
            ->orWhere('ra.nik', @$sutri->nik)
        ->groupEnd();
        
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('ra.created_at', 'desc');
        })
        ->edit('fid_sutri_ke', function($row) {
            return $row->nama_sutri;
        })
        ->edit('tmp_lahir', function($row) {
            return "<u>".$row->tmp_lahir."</u><br>".date_indo($row->tgl_lahir);
        })
        ->edit('status', function($row) {
            return "<u>".$row->status."</u><br>Status Hidup : <b>".$row->status_hidup."</b><br> Tanggungan : <b>".$row->tanggungan."</b>";
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'">Hapus <i class="bx bx-trash"></i></button></li>
                        </ul>
                    </div>';
        })
        ->toJson(true);
    }

    public function riwayat_workshop()
    {
        helper(["hash","tgl_indo"]);

        $builder = $this->db->table('riwayat_workshop rw')
        ->select('rw.no,rw.nik,rw.nama_workshop,rw.tahun,rw.instansi_penyelenggara,rw.tempat,rw.tanggal,rw.pejabat_sk,rw.no_sk,rw.tgl_sk,
        jw.nama_jenis_workshop,rd.nama_rumpun_diklat,rw.lama_bulan,rw.lama_hari,rw.lama_jam')
        ->select('CONCAT_WS(" ",rw.lama_bulan,rw.lama_hari,rw.lama_jam) as lama', false)
        ->join('ref_rumpun_diklat rd', 'rw.fid_rumpun_diklat=rd.id_rumpun_diklat')
        ->join('ref_jenis_workshop jw', 'rw.fid_jenis_workshop=jw.id_jenis_workshop')
        ->where('rw.nik', $this->request->getPost('nik'));
        
        return DataTable::of($builder)
        ->addNumbering('no_urut')
        ->postQuery(function($query){
            $query->orderBy('rw.created_at', 'desc');
        })
        ->edit('nama_workshop', function($row) {
            return "<span class='text-primary'>".$row->nama_jenis_workshop."</span><br>".$row->nama_workshop."<br><span class='text-success'>Rumpun : ".$row->nama_rumpun_diklat."</span>";
        })
        ->edit('instansi_penyelenggara', function($row) {
            return "<u>".$row->instansi_penyelenggara."</u><br>".$row->tempat;
        })
        ->edit('tanggal', function($row) {
            return $row->lama." ".satuanWorkshop($row->lama_jam,$row->lama_hari,$row->lama_bulan)." / ".date_indo($row->tanggal);
        })
        ->edit('no_sk', function($row) {
            return "No : ".$row->no_sk." <br> Tanggal : ".date_indo($row->tgl_sk)." <br> Pejabat : ".$row->pejabat_sk;
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->no).'" data-nik="'.dohash($row->nik).'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.dohash($row->no).'" data-nik="'.dohash($row->nik).'">Hapus <i class="bx bx-trash"></i></button></li>
                        </ul>
                    </div>';
        })
        ->toJson(true);
    }

    public function riwayat_lhkpn()
    {
        helper(["hash","tgl_indo"]);
        $builder = $this->db->table('riwayat_lhkpn')
        ->where('nik', $this->request->getPost('nik'));
        
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('created_at', 'desc');
        })
        ->edit('tahun_wajib', function($row) {
            return "<b>".$row->tahun_wajib."</b> <br> <span class='text-secondary'> Disampaikan tanggal : ".date_indo($row->tgl_penyampaian)."</span>";
        })
        ->format('file_tbn', function($value) {
            return $value === "" ? "<span class='text-secondary'>Belum ada</span>" : "<a href='".base_url("assets/file_lhkpn/".$value)."' target='_blank'><i class='bx bx-file'></i> $value </a>"; 
        })
        ->add('action', function($row) {
            return '<div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                        <ul class="dropdown-menu" data-popper-placement="bottom-start">
                            <li><button type="button" class="dropdown-item text-secondary d-flex justify-content-between align-items-center" id="upload-berkas" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'" data-tahun="'.$row->tahun_wajib.'">Upload Berkas <i class="bx bx-upload"></i></button></li>
                            <li><button type="button" class="dropdown-item text-primary d-flex justify-content-between align-items-center" id="edit" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'">Edit <i class="bx bx-edit-alt"></i></button></li>
                            <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.dohash($row->id).'" data-nik="'.dohash($row->nik).'" data-file="'.$row->file_tbn.'">Hapus <i class="bx bx-trash"></i></button></li>
                        </ul>
                    </div>';
        })
        ->toJson(true);
    }

    public function riwayat_tunjangan()
    {
        helper(["number","tgl_indo"]);
        $builder = $this->db->table('riwayat_tunjangan')
        ->where('nik', $this->request->getPost('nik'));
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('created_at', 'desc');
        })
        ->format('jumlah_uang', function($value) {
            return number_to_currency($value, "IDR", "id_ID");
        })
        ->format('pph21', function($value) {
            return number_to_currency($value, "IDR", "id_ID");
        })
        ->format('bulan', function($value) {
            return bulan($value);
        })
        ->toJson(true);
    }

    public function hitung_tunjangan()
    {
        helper(["number","tgl_indo","hash"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');
        
        $request = $this->request;

        $builder = $this->db->table('riwayat_tunjangan rt')
        ->select('rt.nik,rt.id,rt.nama_unit_kerja,rt.nama_desa,rt.nama_jabatan,rt.bulan,rt.tahun,rt.jumlah_bulan,rt.jumlah_uang,rt.pph21,
        p.nama,p.gelar_depan,p.gelar_blk,rt.created_at,u.nama_unit_kerja')
        ->join('pegawai p', 'rt.nik=p.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->when(session()->role, static function($query, $status) {
            if($status === 'OPERATOR') {
                $query->where('p.fid_unit_kerja', session()->id_unit_kerja);
            }
        })
        ->whereIn('bulan', [$now->getMonth(), $now->addMonths(-1)->getMonth()])
        ->whereIn('tahun', [$now->getYear(), $now->addYears(-1)->getYear()]);
        
        return DataTable::of($builder)
        ->addNumbering('no')
        ->postQuery(function($query){
            $query->orderBy('rt.created_at', 'desc');
        })
        ->edit('bulan', function($row) {
            return bulan($row->bulan)." ".$row->tahun;
        })
        ->edit('nama', function($row) {
            return namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk);
        })
        ->format('jumlah_uang', function($value) {
            return number_to_currency($value, "IDR", "id_ID");
        })
        ->format('pph21', function($value) {
            return number_to_currency($value, "IDR", "id_ID");
        })
        ->add('action', function($row) {
            if(checkDaysAfterCreation($row->created_at, 1)) {
                return '<div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-edit"></i></button>
                <ul class="dropdown-menu" data-popper-placement="bottom-start">
                <li><button type="button" class="dropdown-item text-danger d-flex justify-content-between align-items-center" id="hapus" data-uid="'.dohash($row->id).'">Batalkan Perhitungan <i class="bx bx-trash"></i></button></li>
                </ul>
                </div>';
            }
            return "<i class='bx bx-lock text-primary'></i>";

        })
        ->toJson(true);
    }
}

?>