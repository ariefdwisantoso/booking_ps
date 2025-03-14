<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    use HasFactory;
    protected $table    = 'rentals';
    protected $fillable = [
        'ps_unit_id', 
        'customer_name', 
        'customer_contact', 
        'customer_email', 
        'start_date', 
        'end_date', 
        'cost', 
        'weekend_surcharge',
        'amount',
        'status'
    ];

    public function psUnit()
    {
        return $this->belongsTo(PsUnit::class, 'ps_unit_id');
    }
}
