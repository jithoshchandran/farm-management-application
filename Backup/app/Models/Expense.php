<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'expiry_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function item()
    {
        return $this->belongsTo(ExpenseItem::class, 'expense_item_id');
    }
}
