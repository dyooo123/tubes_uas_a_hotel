<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama_tamu',
        'email',
        'jenis_kelamin',
        'no_telp',
        'alamat',
        'tanggal_lahir',
        'tgl_checkin',
        'tgl_checkout',
        'id_kamar',
    ];

    public function kamar(){
        return $this->belongsTo(Kamar::class,'id_kamar');
    }

    public function getCreatedAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAttribute(){
        if(!is_null($this->attributes['update_at'])){
            return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
        }
    }
}
