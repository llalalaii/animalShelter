@extends('layouts.master')

@section('contents')

<section id="login-wrapper">
    <div class="d-flex justify-content-center">
        <div>
            @include('partials.alerts')
            <div class="card mt-3" style="width: 500px;">
                <div class="card-body">
                    <form action="{{route('login.submit')}}" method="POST">
                        @csrf
                        <h2 class="text-center">
                            <span class="mdi mdi-home"></span>
                            {{config('app.name')}}
                        </h2>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button class="btn btn-outline-success">
                                <span class="mdi mdi-login"></span>
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection