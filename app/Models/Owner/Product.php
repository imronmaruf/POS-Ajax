<?php

namespace App\Models\Owner;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cashier\TransactionDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['store_id', 'name', 'category', 'price', 'stock'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
