<?php

namespace App\Models\Owner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['store_id', 'description', 'amount', 'category'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
