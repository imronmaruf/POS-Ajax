<?php

namespace App\Models\Admin;

use App\Models\Owner\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name'];

    public function stores()
    {
        return $this->hasMany(Store::class, 'category_id');
    }
}
