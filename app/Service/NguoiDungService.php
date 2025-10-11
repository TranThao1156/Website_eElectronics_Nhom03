<?php 
namespace App\Service;
use Illuminate\Support\Facades\DB;


class NguoiDungService 
{
    public function getAll() {
        return DB::table('nguoidung')->get();
    }
    public function find($id)
    {
        return DB::table('nguoidung')->where('IDUser', $id)->first();
    }
}