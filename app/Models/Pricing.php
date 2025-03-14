<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $table    = 'pricing';
    protected $fillable = ['ps_unit_id', 'base_rate', 'weekend_surcharge'];

    public function psUnit()
    {
        return $this->belongsTo(PsUnit::class);
    }
}
