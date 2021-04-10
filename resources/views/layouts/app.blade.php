<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/favicon-32x32.png')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    @section('styles')

	@show
</head>
<body>
    <div id="app">
        <vue-progress-bar></vue-progress-bar>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        <li class="nav-item dropdown">
                                <a id="customers-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('built.Customers') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customers-dropdown">
                                    <a class="dropdown-item" href="{{ route('customers.create') }}">
                                    {{ __('built.Create') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('customers.index') }}">
                                    {{ __('built.All') }}
                                    </a>

                                </div>
                            </li>

                        <li class="nav-item dropdown">
                                <a id="items-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('built.Items') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="items-dropdown">
                                    <a class="dropdown-item" href="{{ route('items.create') }}">
                                    {{ __('built.Create') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('items.index') }}">
                                    {{ __('built.All') }}
                                    </a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="invoices-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('built.Invoices') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoices-dropdown">
                                    <a class="dropdown-item" href="{{ route('invoices.create') }}">
                                    {{ __('built.Create') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('invoices.index') }}">
                                    {{ __('built.All') }}
                                    </a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @if(Session::has('success'))
	<script>
		toast.fire({
			icon: "success",
			title: "{{Session::get('success')}}"
		});
	</script>
	@endif

	@if(Session::has('error'))
	<script>
		toast.fire({
			icon: "error",
			title: "{{Session::get('error')}}"
		});
	</script>
	@endif

	<script>
		function dataTableErrorFn(e, settings, techNote, message) {
			// console.log(settings.jqXHR.status);
			//logout user if session expired
			if (settings.jqXHR.status == "419") {
				swal.fire({
					title: "Session Expired",
					text: "Your session has expired, please refresh the page",
					icon: "warning",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ok",
					allowOutsideClick: false
				}).then(result => {
					if (result.value) {
						window.location.reload();
					}
				});
			}
		}
	</script>

	@section('scripts')

	@show
</body>
</html>
