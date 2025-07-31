<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['limit_amount', 'month', 'year', 'category_id', 'user_id'];

    protected $casts = [
        'limit_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getUsedAmountAttribute()
    {
        return $this->category->expenses()
            ->where('user_id', $this->user_id)
            ->whereMonth('expense_date', $this->month)
            ->whereYear('expense_date', $this->year)
            ->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->limit_amount - $this->used_amount;
    }

    public function getUsagePercentageAttribute()
    {
        return $this->limit_amount > 0 ? ($this->used_amount / $this->limit_amount) * 100 : 0;
    }

    public function getStatusAttribute()
    {
        $percentage = $this->usage_percentage;
        if ($percentage >= 100) return 'over';
        if ($percentage >= 80) return 'warning';
        if ($percentage >= 60) return 'moderate';
        return 'good';
    }
}
