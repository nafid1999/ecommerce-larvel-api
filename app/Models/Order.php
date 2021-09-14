<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        "first_name",
        "user_id",
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
         "payment_mode"
         
    ];

     public function orderItems()
    {
       $this->hasMany(OrderItems::class,"order_id","id");
    }
}
