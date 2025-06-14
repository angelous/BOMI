<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'gender',
        'age',
        'weight',
        'height',
        'bmi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
