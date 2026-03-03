<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingMessage extends Model
{
    // Nama tabel jika Anda tidak mengikuti konvensional jamak (optional)
    // protected $table = 'counseling_messages';

    protected $fillable = [
        'session_id',
        'sender_id',
        'message',
        'is_read'
    ];

    /**
     * Relasi ke Sesi Konseling (Setiap pesan dimiliki oleh satu sesi)
     */
    public function session()
    {
        return $this->belongsTo(CounselingSession::class, 'session_id');
    }

    /**
     * Relasi ke Pengirim (Pesan dikirim oleh seorang User)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}