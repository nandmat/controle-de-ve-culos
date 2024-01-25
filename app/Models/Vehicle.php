<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable =[
        'owner_id',
        'model',
        'brand',
        'license_plate',
        'model_date',
        'fabrication_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function owner(){
        return $this->belongsTo(Owner::class);
    }
}
