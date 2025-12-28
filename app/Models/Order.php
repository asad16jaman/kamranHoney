<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'address_line_1',
        'address_line_2',
        'city',
        'zip_code',
        'delivery_zone',
        'payment_method',
        'subtotal',
        'shipping_cost',
        'discount',
        'coupon_code',
        'total',
        'tracking_number',
        'shipping_carrier',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
