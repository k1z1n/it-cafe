@extends('includes.template')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Авторизация</div>
                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-group mt-3">
                                <label for="email" class="ms-3 mb-1">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            @error('email')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                            <div class="form-group mt-3">
                                <label for="password" class="ms-3 mb-1">Пароль</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            @error('password')
                            <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                            <div class="form-group mt-3 d-flex align-items-center justify-content-center flex-column">
                                <button type="submit" class="btn btn-primary mt-3 w-100 mb-2">Войти</button>
                                <a href="/register" class="d-block">регистрация</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
