<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nếu tên bảng khác mặc định, đặt tên bảng ở đây
    protected $table = 'nguoidung';

    // Nếu khóa chính khác 'id'
    protected $primaryKey = 'IDUser';

    // Nếu bảng không có created_at/updated_at
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TenDangNhap',
        'HoTen',
        'Email',
        'MatKhau',
        // ...thêm các trường khác nếu cần...
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'MatKhau',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    // Mutator: tự hash mật khẩu khi gán
    public function setMatKhauAttribute($value)
    {
        $this->attributes['MatKhau'] = $value ? Hash::needsRehash($value) ? Hash::make($value) : $value : null;
    }

    // Các helper method dùng Eloquent

    /** @return \Illuminate\Database\Eloquent\Collection */
    public static function getAll()
    {
        return self::all();
    }

    /** @param mixed $id @return self|null */
    public static function findById($id)
    {
        return self::find($id);
    }

    /** @param string $username @return self|null */
    public static function findByUsername(string $username)
    {
        return self::where('TenDangNhap', $username)->first();
    }

    /** @param array $data @return self */
    public static function createUser(array $data)
    {
        // Nếu incoming key 'password', chấp nhận cả 'password' hoặc 'MatKhau'
        if (isset($data['password']) && !isset($data['MatKhau'])) {
            $data['MatKhau'] = $data['password'];
            unset($data['password']);
        }
        return self::create($data);
    }

    /** @param mixed $id @param string $newPassword @return bool */
    public static function updatePassword($id, string $newPassword): bool
    {
        $user = self::findOrFail($id);
        $user->MatKhau = $newPassword; // mutator sẽ hash
        return $user->save();
    }
}
