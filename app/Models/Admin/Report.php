<?php

namespace App\Models\Admin;

use App\Models\Owner\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['store_id', 'type', 'total', 'period'];

    protected $casts = [
        'period' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
