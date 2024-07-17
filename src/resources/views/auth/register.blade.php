@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__wrapper">
    <div class="register__heading">
        <p class="register__heading-text">会員登録</p>
    </div>

    <div class="register__content">
        <form class="register-form" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <div class="register-form__content">
                    <input type="name" name="name" id="name" placeholder="名前" value="{{ old('name') }}" />
                    <p class="register-form__error-message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__content">
                    <input type="email" name="email" id="email" placeholder="メールアドレス" value="{{ old('email') }}" />
                    <p class="register-form__error-message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__content">
                    <input type="password" name="password" id="password" placeholder="パスワード">
                    <p class="register-form__error-message">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__content">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="確認用パスワード" />
                    <p class="register-form__error-message">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__button">
                    <button class="register-form__button-submit" type="submit">会員登録</button>
                </div>
            </div>
        </form>
        <div class="login__link">
            <p class="login__link-text">アカウントをお持ちの方はこちらから</p>
            <a class="login__button-submit" href="/login">ログイン</a>
        </div>
    </div>
</div>
@endsection