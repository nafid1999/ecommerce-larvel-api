<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        "first_name",
         "last_name",
         "zip_code",
         "state",
         "city",
         "phone",
         "email",
         "adress",
         "status",
         "no_tracking",
         "payment_id",
         
    ];
}
