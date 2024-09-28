<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai as p';
    protected $primaryKey       = 'nik';
    protected $allowedFields    = [];

    public function getDetailPegawai($nik) 
    {
        $builder = $this->where('p.status', 'AKTIF')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
        ->join('ref_agama a', 'p.fid_agama=a.id_agama')
        ->join('ref_desa d', 'p.fid_keldesa=d.id_desa')
        ->join('ref_status_kawin rsk', 'p.fid_status_kawin=rsk.id_status_kawin')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id', 'left')
        ->where('p.nik', $nik)
        ->get();
        return $builder;
    }

    public function getDetailPegawaiByJabatanId($id) 
    {
        $builder = $this->where('p.status', 'AKTIF')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_desa d', 'p.fid_keldesa=d.id_desa')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('j.id', $id)
        ->get();
        return $builder;
    }

    public function getPendidikanTerakhir($nik)
    {
        $subquery = db_connect()->table('riwayat_pendidikan rp')
        ->select('rp.nama_sekolah,rp.thn_lulus,rp.berkas,tp.nama_tingkat_pendidikan,jp.nama_jurusan_pendidikan')
        ->join('ref_tingkat_pendidikan tp', 'rp.fid_tingkat=tp.id_tingkat_pendidikan')
        ->join('ref_jurusan_pendidikan jp', 'rp.fid_jurusan=jp.id_jurusan_pendidikan')
        ->where('rp.nik', $nik)
        ->orderBy('rp.created_at', 'desc');
        return $subquery->get()->getRow();
    }
    public function getPendidikanTerakhirById($id)
    {
        $subquery = db_connect()->table('riwayat_pendidikan rp')
        ->join('pegawai p', 'p.nik=rp.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_tingkat_pendidikan tp', 'rp.fid_tingkat=tp.id_tingkat_pendidikan')
        ->join('ref_jurusan_pendidikan jp', 'rp.fid_jurusan=jp.id_jurusan_pendidikan')
        ->where('rp.id', $id);
        return $subquery->get()->getRow();
    }
    public function getJabatanTerakhir($nik)
    {
        $subquery = $this->db->table('riwayat_jabatan rj')
        ->select('rj.id, rj.nik, rj.tmt_mulai, rj.tmt_selesai, rj.tgl_pelantikan, rj.pejabat_sk, rj.tgl_sk, rj.no_sk, rj.berkas, 
        u.nama_unit_kerja, ref_jab.nama_jabatan, ref_jab.jenis, ref_jab.usia_bup')
        ->join('ref_jabatan ref_jab', 'rj.fid_jabatan=ref_jab.id')
        ->join('ref_unit_kerja u', 'rj.fid_unit_kerja=u.id_unit_kerja')
        ->where('rj.nik', $nik)
        ->orderBy('rj.created_at', 'desc');
        return $subquery->get()->getFirstRow();
    }
    public function getJabatanTerakhirById($id)
    {
        $subquery = $this->db->table('riwayat_jabatan rj')
        ->select('rj.id, rj.nik, rj.tmt_mulai, rj.tmt_selesai, rj.tgl_pelantikan, rj.pejabat_sk, rj.tgl_sk, rj.no_sk, rj.berkas, 
        u.id_unit_kerja, u.nama_unit_kerja, ref_jab.id as id_jabatan,ref_jab.nama_jabatan, ref_jab.jenis, ref_jab.usia_bup,p.gelar_depan,p.nama,p.gelar_blk')
        ->join('ref_jabatan ref_jab', 'rj.fid_jabatan=ref_jab.id')
        ->join('ref_unit_kerja u', 'rj.fid_unit_kerja=u.id_unit_kerja')
        ->join('pegawai p', 'rj.nik=p.nik')
        ->where('rj.id', $id);
        return $subquery->get()->getRow();
    }
    public function getLHKPNById($id)
    {
        $query = $this->db->table('riwayat_lhkpn rl')
        ->select('rl.*,u.id_unit_kerja,u.nama_unit_kerja,p.gelar_depan,p.nama,p.gelar_blk')
        ->join('pegawai p', 'p.nik=rl.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('rl.id', $id);
        return $query->get()->getFirstRow();
    }
    public function getWorkshopById($id)
    {
        $query = $this->db->table('riwayat_workshop rw')
        ->select('rw.*,u.id_unit_kerja,u.nama_unit_kerja,p.gelar_depan,p.nama,p.gelar_blk,
        jw.id_jenis_workshop,jw.nama_jenis_workshop,
        rd.id_rumpun_diklat,rd.nama_rumpun_diklat')
        ->join('pegawai p', 'p.nik=rw.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_jenis_workshop jw', 'rw.fid_jenis_workshop=jw.id_jenis_workshop')
        ->join('ref_rumpun_diklat rd', 'rw.fid_rumpun_diklat=rd.id_rumpun_diklat')
        ->where('rw.no', $id);
        return $query->get()->getFirstRow();
    }
    public function getSutriById($id)
    {
        $query = $this->db->table('riwayat_sutri rs')
        ->select('rs.*,u.id_unit_kerja,u.nama_unit_kerja,p.gelar_depan,p.nama,p.gelar_blk,p.jns_kelamin')
        ->join('pegawai p', 'p.nik=rs.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('rs.id', $id);
        return $query->get()->getFirstRow();
    }
    public function getAnakById($id)
    {
        $query = $this->db->table('riwayat_anak ra')
        ->select('ra.*,u.id_unit_kerja,u.nama_unit_kerja,p.gelar_depan,p.nama,p.gelar_blk')
        ->join('pegawai p', 'p.nik=ra.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('ra.id', $id);
        return $query->get()->getFirstRow();
    }
}
