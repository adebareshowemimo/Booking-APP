@extends('admin.layouts.app')

@section('content')
<div class="container my-4 container-login100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end sr-only">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end sr-only">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>


                 
                    <div class="row col  flex-c-m text-center mt-3 social-login">
                        <div class="flex items-center justify-end mb-2 mr-3">
                          <a href="{{ route("auth.redirect", ["provider" => "google"]) }}">
                            <button class="btn btn-outline-primary"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/800px-Google_%22G%22_Logo.svg.png" width="20" class="mr-2">Sign In with Google</button>
                          </a>
                        </div>
                        <div class="flex items-center justify-end mb-2 mr-3">
                          <a href="{{ route("auth.redirect", ["provider" => "wordpress"]) }}">
                            <button class="btn btn-outline-info"><img src="https://www.pngall.com/wp-content/uploads/2016/05/WordPress-Logo-PNG-HD.png" width="20" class="mr-2">Sign In with Wordpress</button>
                          </a>
                        </div>
                        <div class="flex items-center justify-end mb-2 mr-3">
                          <a href="{{ route("auth.redirect", ["provider" => "microsoft"]) }}">
                            <button class="btn btn-outline-success"><img src="https://cdn-icons-png.flaticon.com/512/732/732221.png" width="20" class="mr-2">Sign In with Microsoft</button>
                          </a>
                        </div>
                      </div>
                </div>

              
            </div>

          
        </div>
    </div>
</div>
@endsection
