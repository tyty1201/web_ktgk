<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Chỉ định tên bảng (rất quan trọng)
    protected $table = 'san_pham';

    // Khóa chính (nếu không phải là 'id' thì phải khai báo)
    protected $primaryKey = 'id';

    // Các trường được phép mass assignment
    protected $fillable = [
        'ten', 
        'gia', 
        'hinh_anh', 
        'tieu_de',
        'id_danh_muc',
        'bao_hanh',
        'series_model',
        'mau_sac',
        'nhu_cau',
        'cpu',
        'chip_do_hoa',
        // thêm các cột khác nếu cần
    ];

    // Nếu muốn format giá tiền đẹp
    public function getGiaFormattedAttribute()
    {
        return number_format($this->gia, 0, ',', '.') . ' đ';
    }
}