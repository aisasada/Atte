@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('nav')
<nav>
    <ul class="header-nav">
        @if (Auth::check())
        <li class="header-nav__item">
            <a class="header-nav__link" href="/">ホーム</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="/attendance">日付一覧</a>
        </li>
        <li class="header-nav__item">
            <form class="form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">ログアウト</button>
            </form>
        </li>
        @endif
    </ul>
</nav>
@endsection

@section('content')
<div class="attendance__container">
    <div class="date">
        <form action="/attendance" method="get">
            @csrf
            <button name="date" id="prev" value="{{ $yesterday->format('Y-m-d')}}">&lt;</button>
        </form>
        <p class="date__today">{{ $today->format('Y-m-d') }}</p>
        <form action="/attendance" method="get">
            @csrf
            <button name="date" type="date" id="next" value="{{ $tomorrow->format('Y-m-d') }}">&gt;</button>
        </form>
    </div>

    <div class="attendance__table">
        <table class="attendance__table-inner">
            <tr class="attendance__table-row">
                <th class="attendance__table-header">名前</th>
                <th class="attendance__table-header">出勤時間</th>
                <th class="attendance__table-header">退勤時間</th>
                <th class="attendance__table-header">休憩時間</th>
                <th class="attendance__table-header">勤務時間</th>
            </tr>
            <tbody class="attendance__table-item">
                @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ $attendance->start_time ? $attendance->start_time->format('H:i:s') : '' }}</td>
                    <td>{{ $attendance->end_time ? $attendance->end_time->format('H:i:s') : '' }}</td>
                    <td>{{ $attendance->rests->sum(function ($rest) use ($attendance) {
                        return $rest->rest_end ? $rest->getDuration()->format('%H:%I:%S') : '';
                    }) }}</td>
                    <td>{{ $attendance->getDuration() ? $attendance->getDuration()->format('%H:%I:%S') : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
