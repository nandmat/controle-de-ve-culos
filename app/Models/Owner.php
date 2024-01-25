<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'telephone_number',
        'email',
        'status',
        'gender'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
