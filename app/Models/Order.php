<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $appends = ["order_code"];

    public function getOrderCodeAttribute()
    {
        $nameWords = strtoupper(substr($this->event->name, 0, 2));
        $fullNameWords = strtoupper(substr($this->customer->full_name, 0, 2));
        return "{$nameWords}{$this->id}{$fullNameWords}";
    }

    protected $with = ["customer", "tortas", "event"];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->where('rol_user_id', 2);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function tortas()
    {
        return $this->belongsToMany(Torta::class, 'order_details', 'order_id', 'torta_id')
            ->withPivot('quantity');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
