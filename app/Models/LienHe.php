<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LienHe extends Model
{
    protected $table = 'lienhe';

    protected $primaryKey = 'MaLienHe';

    public $imcrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'Ten',
        'SoDienThoai',
        'Email',
        'TieuDe',
        'NoiDung',
        'TrangThai',
        'IDUser',
    ];

    public function user() {
        return $this->belongsTo(NguoiDung::class, 'IDUser', 'IDUser');
    }
}
