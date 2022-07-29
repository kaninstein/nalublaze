<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_id',
        'roll_time',
        'color',
        'number',
        'seed',
        'roll_id',
        'time_add',
        'duplicated_seed'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'datetime'
    ];

    public function signs()
    {
        return Sign::where('base_color_id', $this->id)->get();
    }
}
