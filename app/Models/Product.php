<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'metaDesc',
        'metaKeywords',
        'metaTitle',
        'brand',
        'status',
        'image',
        'price',
        'o_price',
        'qte',
        'category_id'

    ];

    protected $with=["category"];
     public function category(){
        
        return $this->belongsTo(Category::class,"category_id","id");
   }
}