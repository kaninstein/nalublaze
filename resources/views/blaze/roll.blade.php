<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        .roulette-tile {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sm-box {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            border-radius: 4px;
        }

        .sm-box .number {
            font-size: 9px;
            letter-spacing: -.5px;
            color: #bcbfc7;
            padding: 0;
            border: 2px solid #bcbfc7;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -1px;
            border-radius: 50%;
        }

        .sm-box.red .number {
            color: #8c1024;
            border: 2px solid #8c1024;
        }

        .sm-box.white img {
            height: 16px;
        }

        .white {
            background-color: #fff;
        }

        .red {
            background-color: #f12c4c;
        }

        .black {
            background-color: #262f3c;
        }


    </style>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div>
    <table
        class="border-collapse w-full border border-slate-400 dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm">
        <thead class="bg-slate-50 dark:bg-slate-700">
        <tr>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Hora
            </th>
            <th class="border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">
                Pedra
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($rolls as $roll)
            <tr>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">{{ \Carbon\Carbon::parse($roll->roll_time)->format('H:i:s') }}</td>
                    <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400 text-center">
                        <div class="entry">

                            <div class="roulette-tile">
                                <div
                                    class="sm-box {{ (($roll->color == 0) ? 'white' : (($roll->color == 1) ? 'red' : 'black')) }}">
                                    @if($roll->color == 0)
                                        <img alt="0" src="{{ asset('svg/blaze.svg') }}">
                                    @else

                                        <div class="number">
                                            {{ $roll->number }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
