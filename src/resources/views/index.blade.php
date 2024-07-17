@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
<div class="stamp__message">
    @if(Auth::check())
    <p class="stamp__message-text">{{ Auth::user()->name }}さんお疲れ様です！</p>
    @endif
</div>

<div class="stamp__wrapper">
    <div class="stamp__content-left">
        @if(Auth::check())
        <form action="/start_time" method="POST" class="stamp__button">
            @csrf
            <button id="start-time-button" class="stamp__start-time" type="submit" {{ $isStarted ? 'disabled' : '' }}>勤務開始</button>
        </form>

        <form action="/rest_start" method="POST" class="stamp__button">
            @csrf
            <button id="rest-start-button" class="stamp__break-start" type="submit" {{ !$isStarted || $hasOngoingRest || $isEnded ? 'disabled' : '' }}>休憩開始</button>
        </form>
    </div>

    <div class="stamp__content-right">
        <form action="/end_time" method="POST" class="stamp__button">
            @csrf
            <button id="end-time-button" class="stamp__end-time" type="submit" {{ !$isStarted || $isEnded || $hasOngoingRest ? 'disabled' : '' }}>勤務終了</button>
        </form>

        <form action="/rest_end" method="POST" class="stamp__button">
            @csrf
            <button id="rest-end-button" class="stamp__break-end" type="submit" {{ !$hasOngoingRest || $isEnded ? 'disabled' : '' }}>休憩終了</button>
        </form>
        @endif
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isStarted = @json($isStarted);
        const isEnded = @json($isEnded);
        const hasOngoingRest = @json($hasOngoingRest);

        const startTimeButton = document.getElementById('start-time-button');
        const endTimeButton = document.getElementById('end-time-button');
        const restStartButton = document.getElementById('rest-start-button');
        const restEndButton = document.getElementById('rest-end-button');

        // 出勤ボタン
        if (isStarted || isEnded) {
            startTimeButton.disabled = true;
        }

        // 退勤ボタン
        if (!isStarted || isEnded) {
            endTimeButton.disabled = true;
        }

        // 休憩開始ボタン
        if (!isStarted || hasOngoingRest) {
            restStartButton.disabled = true;
        }

        // 休憩終了ボタン
        if (!isStarted || !hasOngoingRest || isEnded) {
            restEndButton.disabled = true;
        }
    });
</script>
