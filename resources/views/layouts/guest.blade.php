<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/guest.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bsUtility.css') }}" rel="stylesheet">
    <script src="{{asset('js/particles.js')}}"></script>
    <script>
        /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
        particlesJS.load('particles-js', '{{asset('js/particles.json')}}', function() {
          console.log('callback - particles.js config loaded');
        });
    </script>
</head>

<body>
    <div style="height:100%" id="particles-js">

    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-5 pt-5 mt-5 text-center lead text-white">
                <a href="{{ url('/') }}" class="mt-0 pt-0">
                    <img src="{{ asset('images/guest_logo.png') }}" class="mt-0 pt-0" alt="" />
                </a><br>
                <p>
                    Achievers Town one of the biggest gatherings of achievers to present ideas, create new innovations
                    and problem solving solutions for advancements now and in the future.
                    The number one source for maximum business developments, achievements, and making connections is
                    here in Achievers Town.
                    The Future's Bright. The Future's<br> <b>Achievers Town</b>.
                </p>

            </div>
            <div class="col-md-1">

            </div>

            <div class="col-md-6">


                <div class="tab_container">
                    <input id="tab1" type="radio" name="tabs" {{ old('tab') != 'register' ? 'checked' : '' }}
                        class="radio_hidden">
                    <label for="tab1" class="head"><i class="fa fa-user"></i><span>LOGIN</span></label>

                    <input id="tab2" type="radio" name="tabs" {{ old('tab') == 'register' ? 'checked' : '' }}
                        class="radio_hidden">
                    <label for="tab2" class="head"><i class="fa fa-user-plus"></i><span>SIGN UP</span></label>

                    <div class="contents">
                        <section id="content1" class="tab-content">

                            @include('auth.login')

                        </section>

                        <section id="content2" class="tab-content">
                            @include('auth.register')

                        </section>
                    </div>
                </div>



            </div>

        </div>


        @include('widgets.footer')
    </div>


    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>