<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = '$transactions';

    protected $fillable = [
        'category_id',
        'product_id',
        'qty',
        'unit_price',
        'total_price',
        'snap_token',
        'status',
        'note'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
