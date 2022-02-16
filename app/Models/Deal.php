<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'deal_name',
        'quantity',
        'claimed',
        'expiry_date'
    ];
    use HasFactory;
}
