<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffRemark extends Model
{
    protected $fillable = [
        'staff_id',
        'remark',
        'date',
        'file',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
