<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsUnit extends Model
{
    use HasFactory;
    protected $table    = 'ps_units';
    protected $fillable = ['type', 'stock'];

    public function pricing()
    {
        return $this->hasOne(Pricing::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rentals::class, 'ps_unit_id');
    }
}
