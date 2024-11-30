<?php

namespace App\Models;

use App\Models\User;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\ProductTransactionFactory> */
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function users(){
        return $this->belongsTo(related: User::class);
    }

    public function transaction_details() {
        return $this->hasMany(TransactionDetail::class);
    }
}
