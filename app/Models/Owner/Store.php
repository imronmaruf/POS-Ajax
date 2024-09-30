<?php

namespace App\Models\Owner;

use App\Models\User;
use App\Models\Admin\Report;
use App\Models\Admin\StoreCategory;
use App\Models\Cashier\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['owner_id', 'name', 'logo', 'category_id', 'address'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(StoreCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Relasi untuk admin dan cashier
    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }
}
