<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrangThaiGhe extends Model
{
    use HasFactory;
    protected $table = 'trangthaighe';


    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['IDLICHCHIEU', 'IDGHE', 'IDPHONGCHIEU', 'STATUS'];

    public $timestamps = false; 

    public function lichChieu()
    {
        return $this->belongsTo(LichChieu::class, 'IDLICHCHIEU', 'IDLICHCHIEU');
    }
}