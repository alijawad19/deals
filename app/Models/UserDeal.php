<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeal extends Model
{
    protected $fillable = [
        'user_id',
        'deal_id',
    ];
    use HasFactory;
}
