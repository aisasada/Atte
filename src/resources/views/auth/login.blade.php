@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__wrapper">
    <div class="login__heading">
        <p class="login__heading-text">ログイン</p>
    </div>

    <div class="login__content">
        <form class="login-form" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <div class="login-form__content">
                    <input type="email" name="email" id="email" placeholder="メールアドレス" value="{{ old('email') }}" />
                    <p class="login-form__error-message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__content">
                    <input type="password" name="password" id="password" placeholder="パスワード" />
                    <p class="login-form__error-message">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__button">
                    <button class="login-form__button-submit" type="submit">ログイン</button>
                </div>
            </div>
        </form>
        <div class="register__link">
            <p class="register__link-text">アカウントをお持ちでない方はこちらから</p>
            <a class="register__button-submit" href="/register">会員登録</a>
        </div>
            </div>
        </form>
    </div>
</div>
@endsection