<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
    ];

//    public $incrementing = false; // Disable auto-incrementing for the 'id' field
    protected $fillable = [
        'id',
        'user_id',
        'order_for',
        'note',
        'total_ammount',
        'payment_id',
        'payment_status',
        'status',
        'approved_at',
        'approved_by',
        'created_by',
        'updated_by'
    ];

    public function scopeWeekly(Builder $builder, ?string $status = null, ?string $payment_status = null): void
    {
        $builder->conditions($status, $payment_status)
            //    ->whereYear('created_at',Carbon::now()->year)
            ->where('created_at', '>', Carbon::now()->subDays(7));
    }

    public function scopeMonthly(Builder $builder, ?string $status = null, ?string $payment_status = null): void
    {
        $builder->conditions($status, $payment_status)
            //    ->whereYear('created_at',Carbon::now()->year)
            // ->whereMonth('created_at', Carbon::now()->month);
            ->where('created_at', '>', Carbon::now()->subDays(30));
    }

    public function scopeYearly(Builder $builder, ?string $status = null, ?string $payment_status = null): void
    {
        $builder->conditions($status, $payment_status)
            ->where('created_at', '>', Carbon::now()->subDays(365));
    }

    public function scopeLast90Days(Builder $builder, ?string $status = null, ?string $payment_status = null): void
    {
        $builder->conditions($status, $payment_status)
            ->where('created_at', '>', Carbon::now()->subDays(90));
    }

    public function scopeDaily(Builder $builder, ?string $status = null, ?string $payment_status = null): void
    {
        $builder->conditions($status, $payment_status)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereDay('created_at', Carbon::now()->day);
    }

    public function scopeConditions($builder, ?string $status = null, ?string $payment_status = null)
    {
        if ($status || $payment_status) {
            $builder->when($status, function ($q) use ($status) {
                $q->where('order_for', $status);
            })->when($payment_status, function ($q) use ($payment_status) {
                $q->where('payment_status', $payment_status);
            });
        }

    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function shippingDetails()
    {
        return $this->hasOne(ShippingDetail::class, 'order_id');
    }

    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function paymentdetails()
    {
        return $this->hasOne(PaymentDetail::class, 'order_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // Accessor for email attribute
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

   public function shippingDetail()
   {
       return $this->hasOne(ShippingDetail::class, 'order_id');
   }

}
