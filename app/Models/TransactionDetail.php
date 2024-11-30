<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function product_transactions() {
        return $this->belongsTo(ProductTransaction::class);
    }
    public function products() {
        return $this->belongsTo(Product::class);
    }
}
