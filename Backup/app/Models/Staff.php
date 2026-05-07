<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'address',
        'id_proof',
        'joined_date',
        'salary_type',
        'salary_amount',
        'status',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'status' => 'boolean',
    ];

    public function remarks()
    {
        return $this->hasMany(StaffRemark::class);
    }

    public function leaves()
    {
        return $this->hasMany(StaffLeave::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}
