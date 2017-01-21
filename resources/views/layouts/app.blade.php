<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/calculator.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script>
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();
            $('#submit-calc').click(function (e) {
                e.preventDefault();
                var firstOperand = $('#firstOperand').val();
                var secondOperand = $('#secondOperand').val();
                var operation = $('#operation').val();
                if (firstOperand == '' && secondOperand == '')
                {
                    $("#calc-output").val(0);
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: '/calculate',
                    data: {
                        _token: _token,
                        firstOperand: firstOperand,
                        secondOperand: secondOperand,
                        operation: operation
                    },
                    success: function (msg) {
                        $("#calc-output").val(msg);
                    },
                    error: function (msg) {
                        console.log(msg);
                        $("#calc-output").val('Invalid input. Operands values must be numeric.');
                    },
                });
            });

            $('#operation').on('change', function (e) {
                e.preventDefault();
                var firstOperand = $('#firstOperand').val();
                var secondOperand = $('#secondOperand').val();
                if (firstOperand == '' && secondOperand == '')
                {
                    $("#calc-output").val(0);
                    return;
                }
                var operation = $('#operation').val();
                $.ajax({
                    type: "POST",
                    url: '/calculate',
                    data: {
                        _token: _token,
                        firstOperand: firstOperand,
                        secondOperand: secondOperand,
                        operation: operation
                    },
                    success: function (msg) {
                        $("#calc-output").val(msg);
                    },
                    error: function (msg) {
                        $("#calc-output").val('Invalid input. Operands values must be numeric.');
                    }
                });
            })
        });

    </script>


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(
            [
                'csrfToken' => csrf_token(),
            ]
        ); ?>
    </script>
</head>
<body>
<div id="app">
    {{ csrf_field() }}
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>
