<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'apartment',
        'intercom_code',
        'entrance',
        'floor',
        'comments',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
