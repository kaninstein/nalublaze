<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="10">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="px-4 py-8 sm:px-8">
    <table class="border-collapse w-full border border-slate-400 dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm">
        <thead class="bg-slate-50 dark:bg-slate-700">
        <tr>
            <th class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">Hora</th>
            <th class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">Sinal</th>
            <th class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">Pedras Base</th>
            <th class="w-1/2 border border-slate-300 dark:border-slate-600 font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">Resultado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($signs as $sign)
            <tr>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($sign->sign_time)->format('H:i') }}</td>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"> ⚪️ e

                    @if($sign->getColor()->color == 1)
                        🔴
                    @elseif($sign->getColor()->color == 2)
                        ⚫️
                    @else
                        ⚪️
                    @endif

                </td>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">⚪ as {{ \Carbon\Carbon::parse($sign->getBlank()->roll_time)->format('H:i') }}   ||  {{ $sign->getColor()->number }} @if($sign->getColor()->color == 1)
                        🔴
                    @elseif($sign->getColor()->color == 2)
                        ⚫️
                    @else
                        ⚪️
                    @endif as {{ \Carbon\Carbon::parse($sign->getColor()->roll_time)->format('H:i') }}</td>
                <td class="border border-slate-300 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                                    @if($sign->getResult())
                                        ✅
                                    @else
                                        ❌
                                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
