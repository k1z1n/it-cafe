@extends('includes.template')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Регистрация</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                @error('email')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror()
                            </div>
                            <div class="form-group mt-3">
                                <label for="username">Имя пользователя</label>
                                <input type="text" class="form-control" id="username" name="username">
                                @error('username')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror()
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Пароль</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror()
                            </div>
                            <div class="form-group mt-3">
                                <label for="password_confirmation">Подтверждение пароля</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                @error('password_confirmation')
                                <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror()
                            </div>
                            <div class="form-group mt-3 d-flex align-items-center justify-content-center flex-column">
                                <button type="submit" class="btn btn-primary mt-3 w-100 mb-2">Зарегистрироваться</button>
                                <a href="/login" class="d-block">авторизация</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
