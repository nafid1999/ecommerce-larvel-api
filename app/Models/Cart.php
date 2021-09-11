<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class Cart extends Model
{
    use HasFactory;

    protected $fillable=[
        "product_id",
        "user_id",
        "qte"
    ];

    protected $with=["product"];
    
    public function product(){
        return $this->belongsTo(Product::class,"product_id","id");
    }
}
