<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TopNew extends Model
{
    public function getTop(int $limit = 3)
    {
        $tables = ['sanpham', 'products', 'product', 'san_pham'];

        foreach ($tables as $table) {
            if (DB::connection()->getSchemaBuilder()->hasTable($table)) {
                $qb = DB::table($table);

                // special handling for the project's `sanpham` table
                if ($table === 'sanpham') {
                    // use NgayCapNhat if available for "newest" ordering
                    if (DB::connection()->getSchemaBuilder()->hasColumn($table, 'NgayCapNhat')) {
                        $qb = $qb->orderBy('NgayCapNhat', 'desc');
                    }
                    return $qb->select('MaSanPham','Ten','HinhAnh','GiaNhap','GiaSauGiam','NgayCapNhat')->limit($limit)->get();
                }

                // fallback: try created_at or any timestamp-like column
                if (DB::connection()->getSchemaBuilder()->hasColumn($table, 'created_at')) {
                    $qb = $qb->orderBy('created_at', 'desc');
                }

                return $qb->limit($limit)->get();
            }
        }

        return collect();
    }
}
