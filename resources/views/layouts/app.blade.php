<!DOCTYPE html>
<html>

<head>

    <title>Booking Ruangan Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">

        <div class="container">

            <a class="navbar-brand" href="#">Booking Ruangan</a>

            <ul class="navbar-nav ms-auto">

                @auth

                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/rooms">Ruangan</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/bookings">Booking</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/rooms">Ruangan</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/booking">Booking Saya</a>
                        </li>
                    @endif

                    <li class="nav-item">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>

                    </li>

                @endauth

            </ul>

        </div>

    </nav>

    <div class="container mt-4">

        @yield('content')

    </div>

</body>

</html>
