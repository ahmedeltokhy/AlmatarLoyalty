<?php

namespace App\Models;

use Carbon\Traits\Date;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        '0' => 'pending',
        '1' => 'confirmed',
        '-1' => 'expired',
    ];

    protected $fillable = [
        'user_from_id',
        'user_to_id',
        'amount',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = ['expired'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user_from()
    {
        return $this->belongsTo(User::class, 'user_from_id');
    }

    public function user_to()
    {
        return $this->belongsTo(User::class, 'user_to_id');
    }

    public function getExpiredAttribute()
    {
        $created_at =  $this->created_at;
        return ($created_at->diffInMinutes() > 10);
    }
}
