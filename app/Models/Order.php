<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'receiver_name',
        'receiver_phone',
        'address',
        'shipping_method',
        'payment_method',
        'total_amount',
        'payment_deadline',
        'status',
        'payment_proof',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    // RELASI USER
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // RELASI ITEM ORDER
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
