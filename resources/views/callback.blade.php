<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            svg {
                width: 100px;
                height: 100px;
            }
            .successsvg {
                margin: 20px auto;
                display: table;
            }
            .error {
                color: red;
            }
            .success {
                color: green;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    DON
                </div>
                <div>
                    <img src="https://shoppity.azurewebsites.net/jacket1.png" alt="">
                </div>
                <div class="links">
                    @if ($message == 'Transaction approuvée.')
                        <div class="successsvg">
                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="-10 -10 40 40">
                                <path class="success1" d="M22,10.1a.94.94,0,0,0-1,1V12a9,9,0,0,1-9,9h0A9,9,0,0,1,12,3h0a9.46,9.46,0,0,1,3.7.8A1,1,0,0,0,16.5,2,11.38,11.38,0,0,0,12,1h0a11,11,0,0,0,0,22h0A11,11,0,0,0,23,12v-.9A.94.94,0,0,0,22,10.1Z" transform="translate(-1 -1)" style="fill: #8fd01f"/>
                                <path class="success2" d="M23.7,2.3a1,1,0,0,0-1.4,0L12,12.6,9.7,10.3a1,1,0,0,0-1.4,1.4l3,3a1,1,0,0,0,1.4,0l11-11A1,1,0,0,0,23.7,2.3Z" transform="translate(-1 -1)" style="fill: #8fd01f"/>
                            </svg>
                            <h4 class="success">{{ $message }}</h4>
                        </div>
                    @else
                        <h4 class="error">{{ $message }}</h4>
                        <a href=" {{ route('process') }} ">Try again</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>


