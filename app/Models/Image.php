<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'url'
    ];




    public function product()
    {
        //return $this->belongsTo(Product::class, 'id', 'product_id');
        //framework knows that attributes have writtent in that certain way
        return $this->belongsTo(Product::class);
    }
}
