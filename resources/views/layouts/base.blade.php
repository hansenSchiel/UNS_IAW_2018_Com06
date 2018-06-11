<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Prode IAW</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="{{asset('css/customB.css')}}"  rel="stylesheet" type="text/css" title="blue" />
    <link href="{{asset('css/customR.css')}}" rel="alternate stylesheet" type="text/css" title="red" >
    <link href="{{asset('css/customs.css')}}" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/readme">
                        <img src="{{asset('/img/logo.png')}}"/>
        				Prode IAW (Readme)
                    </a>
                </div>
                <span class="logout-spn" >
                    <img src="<%= user.photo %>"/>
                    <a href="/pronosticos">Usuario</a>
                    <a href="/logout">Logout</a> 
                    <a href="/auth/twitter" style="color:#fff;"> Login </a>
                </span>
            </div>
        </div>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="#" onclick="switch_style()"><i class="fa fa-exchange "></i>Cambiar estilo</a>
                    </li>
                    <li class="">
                        <a href="/torneo" ><i class="fa fa-desktop "></i>Torneos</a>
                    </li>
                    <li class="">
                        <a href="/equipo"><i class="fa fa-table "></i>Equipos</a>
                    </li>
                </ul>
        	</div>
        </nav>

        @yield('contenido')



    </div>

    <div class="footer">
        <div class="row">
            <div class="col-lg-12" >
                IAW - Schiel Juan Jose - LU: 94123 - Proyecto 2 - Comision 21
            </div>
        </div>
    </div>

    <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/customs.js')}}"></script>
</body>
</html>
