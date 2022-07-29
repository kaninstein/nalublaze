<?php

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Models\Sign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\Blaze;
use Illuminate\Support\Facades\DB;

class BlazeController extends Controller
{

    private $blaze;
    private $roll;
    private $sign;

    public function __construct(Blaze $Blaze, Roll $Roll, Sign $Sign)
    {

        $this->blaze = $Blaze;
        $this->roll = $Roll;
        $this->sign = $Sign;

    }

    public function check()
    {

        $signs = $this->sign->all()->sortBy('sign_time');
        //$result = $this->getResult();


        return view("blaze.check")->with([
            'signs' => $signs,
            //'result' => $result
        ]);

    }

    public function analisys($base = null)
    {


        //$signs = $this->sign->all()->sortBy('sign_time');
        $signs = $this->sign
            ->whereDay('sign_time', Carbon::now()
                ->format('d'))
            ->orderBy('sign_time', 'asc')
            ->orderBy('base_blank_id', 'asc')
            ->paginate(100);


        return view("blaze.analisys")->with([
            'signs' => $signs
        ]);

    }

    public function blankAnalisys($base)
    {
        $signs = $this->sign->where('base_blank_id', $base)->orderBy('sign_time', 'asc')->paginate(100);


        return view("blaze.analisys")->with([
            'signs' => $signs
        ]);

    }

    public function rollAnalisys($base)
    {
        $signs = $this->sign->where('base_color_id', $base)->orderBy('sign_time', 'asc')->paginate(100);


        return view("blaze.analisys")->with([
            'signs' => $signs
        ]);

    }

    public function secondsAnalisys($start, $end)
    {

        $rolls = $this->roll
            ->where('roll_time', '>=', Carbon::parse($start)->format('Y-m-d H:i'))
            ->where('roll_time', '<=', Carbon::parse($end)->format('Y-m-d H:i'))
            ->orderBy('number')
            ->get();


        return view("blaze.roll")->with([
            'rolls' => $rolls
        ]);

    }

    public function calc()
    {

        $rollZeros = $this->roll
            ->where('number', 0)
            ->orderBy('roll_time', 'asc')
            ->get();


        foreach ($rollZeros as $rollZero) {

            $calcDirection = $this->roll
                ->where('roll_time', '>', Carbon::parse($rollZero->roll_time)->format('Y-m-d H:i'))
                ->where('roll_time', '<', Carbon::parse($rollZero->roll_time)->addMinute()->format('Y-m-d H:i'))
                ->count();

            if ($calcDirection > 0){

                $rolls = $this->roll
                    ->where('roll_time', '>=', Carbon::parse($rollZero->roll_time)->format('Y-m-d H:i:s'))
                    ->orderby('roll_time', 'asc')
                    ->get();

            } else {

                $rolls = $this->roll
                    ->where('roll_time', '<=', Carbon::parse($rollZero->roll_time)->format('Y-m-d H:i:s'))
                    ->orderby('roll_time', 'desc')
                    ->get();

            }


            $count = 5;

            foreach ($rolls as $roll) {

                $count += ($roll->color == 0) ? 5 : 0;

                $count += $roll->number;

                $verifyRoll = $this->sign
                    ->where('base_blank_id', $rollZero->id)
                    ->where('base_color_id', $roll->id)->count();

                if ($verifyRoll == 0) {

                    $this->sign->create([
                        'base_blank_id' => $rollZero->id,
                        'base_color_id' => $roll->id,
                        'sign_time' => Carbon::parse($rollZero->roll_time)->addMinutes($count)
                    ]);

                }


            }


        }

        return view('blaze.refresh')->with(['time' => 30]);

    }

    public function filterBlanks()
    {

        $rollZeros = $this->roll
            ->where('number', 0)
            ->get();

        foreach ($rollZeros as $rollZero) {

            $rollBefore = $this->roll
                ->where('roll_time', '<', $rollZero->roll_time)
                ->first();

            $rollAfter = $this->roll
                ->where('roll_time', '>', $rollZero->roll_time)
                ->first();

        }

    }

    public function checkSigns($id, $time)
    {

        $signs = $this->sign
            ->where('base_blank_id', $id)
            ->where('sign_time', '>=', Carbon::parse($time)->format('Y-m-d H:i:s'))
            ->get();

        foreach ($signs as $sign) {

            $newSign = $this->sign->find($sign->id);

            $newSign->sign_time = Carbon::parse($sign->sign_time)->addMinute();

            $newSign->save();

        }

    }

    public function storeRolls()
    {
        $blaze_rolls = array_reverse($this->blaze->getRecentRolls());


        foreach ($blaze_rolls as $blaze_roll) {


            $seedVerify = $this->roll->where('seed', $blaze_roll->server_seed)->count();


            Roll::firstOrCreate([
                'roll_time' => $this->blaze->getDateTimeZone($blaze_roll->created_at)
            ],
                [
                    'roll_id' => $blaze_roll->id,
                    'duplicated_seed' => ($seedVerify != 0 ? 1 : 0),
                    'color' => $blaze_roll->color,
                    'number' => $blaze_roll->roll,
                    'seed' => $blaze_roll->server_seed
                ]);

        }

        return view('blaze.refresh')->with(['time' => 10]);


    }

    public function getResult()
    {

        $signs = $this->sign->all()->sortBy('id');

        foreach ($signs as $sign) {

            $finalSign = [
                0,
                $sign->color
            ];


            $rolls = $this->roll->all();


            foreach ($rolls as $roll) {


                if ($roll->datetime->format('Y-m-d H:i') == $sign->datetime->format('Y-m-d H:i')) {

                    if (in_array($roll->color, $finalSign)) {
                        $resultSigns[] = $sign->id;
                    }

                }

            }


        }

        return $resultSigns;

    }
}
