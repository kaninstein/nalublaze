<?php

namespace App\Models;

use App\Helpers\Blaze;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_blank_id',
        'base_color_id',
        'count_mode',
        'sign_time'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'sign_time'
    ];

    public function getBlank()
    {
        return $this->belongsTo(Roll::class, 'base_blank_id')->first();
    }

    public function getColor()
    {
        return $this->belongsTo(Roll::class, 'base_color_id')->first();
    }

    public function getRolls(){

        $rolls = Roll::where('roll_time', ">=" , Blaze::getDateTime($this->sign_time))
            ->where('roll_time', "<" , Blaze::getDateTimeNext($this->sign_time))
            ->get();

        return $rolls;

    }

    public function getResult(){

        $double = [
            0,
            $this->getColor()->color
        ];

//        $double = [
//            $this->getColor()->color
//        ];



        foreach($this->getRolls() as $roll){

            if(in_array($roll->color, $double)){

                return true;

            }

        }


        return false;

    }
}
