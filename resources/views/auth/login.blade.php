<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Login | {{$info->company_name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{$info->company_name}}" name="description" />
        <meta content="{{$info->company_name}}" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/logo2.jpeg">

        <!-- Bootstrap Css -->
        <link href="/backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/backend/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/backend/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="bg-primary bg-pattern">
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-3">
                          <img src="/logo.jpeg" height="80" alt="logo">
                          <h5 class="font-size-16 text-white-50 mt-2">Please Enter Your Email & Password</h5>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2">
                                    <h5 class="mb-5 text-center">Log In</h5>
                                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-4">
                                                    <label for="username">User Email</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" required id="username" placeholder="Enter user email" name="email">
                                                </div>
                                                @error('email')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                                @enderror
                                                <div class="form-group mb-4">
                                                    <label for="userpassword">Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" required id="userpassword" placeholder="Enter password" name="password">
                                                </div>
                                                @error('password')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                                @enderror
                                                <div class="mt-4">
                                                    <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->

        <!-- JAVASCRIPT -->
        <script src="/backend/assets/libs/jquery/jquery.min.js"></script>
        <script src="/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/backend/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/backend/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/backend/assets/libs/node-waves/waves.min.js"></script>

        <script src="/backend/assets/js/app.js"></script>

    </body>
</html>
