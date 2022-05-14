<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'transaction_number',
        'firstname',
        'lastname',
        'email',
        'amount',
        'tel',
        'payment_method',
        'message',
        'campaigns',
        'feda_id',
    ];
}
