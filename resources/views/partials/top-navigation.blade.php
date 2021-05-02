{{-- this is my main top navigation --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <span class="mdi mdi-home-variant"></span>
            {{config('app.name')}}
            {{-- El's Animal Shelter --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#top-navbar"
            aria-controls="top-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="top-navbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item text-center">
                    <a class="nav-link {{Route::currentRouteName() == 'animals.index' || Route::currentRouteName() == 'animals.create' || Route::currentRouteName() == 'animals.edit' ? 'active':''}}"
                        href="{{route('animals.index')}}">Animals</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link {{Route::currentRouteName() == 'rescuers.index' || Route::currentRouteName() == 'rescuers.create' || Route::currentRouteName() == 'rescuers.edit' ? 'active':''}}"
                        href="{{route('rescuers.index')}}">Rescuers</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link {{Route::currentRouteName() == 'adopters.index' || Route::currentRouteName() == 'adopters.create' || Route::currentRouteName() == 'adopters.edit' ? 'active':''}}"
                        href="{{route('adopters.index')}}">Adopters</a>
                </li>
                @if(Auth::check())
                {{-- TEMPORARY DELETE MUNA SA DONATIONS --}}
                {{-- <!-- <li class="nav-item dropdown text-center">
                    <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'cash.index' || Route::currentRouteName() == 'cash.create' || Route::currentRouteName() == 'cash.edit' || Route::currentRouteName() == 'materials.index' || Route::currentRouteName() == 'materials.create' || Route::currentRouteName() == 'materials.edit' ? 'active':''}}"
                        href="#" id="donationNav" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Donations
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="donationNav">
                        <li><a class="dropdown-item {{Route::currentRouteName() == 'cash.index' || Route::currentRouteName() == 'cash.create' || Route::currentRouteName() == 'cash.edit' ? 'active':''}}"
                                href="{{route('cash.index')}}">Cash</a></li>
                        <li><a class="dropdown-item {{Route::currentRouteName() == 'materials.index' || Route::currentRouteName() == 'materials.create' || Route::currentRouteName() == 'materials.edit' ? 'active':''}}"
                                href="{{route('materials.index')}}">Materials</a></li>
                    </ul>
                </li> --> --}}
                <li class="nav-item text-center">
                    <a class="nav-link {{Route::currentRouteName() == 'employees.index' || Route::currentRouteName() == 'employees.create' || Route::currentRouteName() == 'employees.edit' ? 'active':''}}"
                        href="{{route('employees.index')}}">Employees</a>
                </li>

                <li class="nav-item dropdown text-center">
                    <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'diseases.index' || Route::currentRouteName() == 'diseases.create' || Route::currentRouteName() == 'diseases.edit' || Route::currentRouteName() == 'injuries.index' || Route::currentRouteName() == 'injuries.create' || Route::currentRouteName() == 'injuries.edit' ? 'active':''}}"
                        href="#" id="donationNav" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sickness
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="sickessNav">
                        <li><a class="dropdown-item {{Route::currentRouteName() == 'diseases.index' || Route::currentRouteName() == 'diseases.create' || Route::currentRouteName() == 'diseases.edit' ? 'active':''}}"
                                href="{{route('diseases.index')}}">Diseases</a></li>
                        <li><a class="dropdown-item {{Route::currentRouteName() == 'injuries.index' || Route::currentRouteName() == 'injuries.create' || Route::currentRouteName() == 'injuries.edit' ? 'active':''}}"
                                href="{{route('injuries.index')}}">Injuries</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::check())
                <li class="nav-item dropdown text-center">
                    <a class="nav-link dropdown-toggle" href="#" id="accountNav" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{Auth::user()->first_name}} ({{Auth::user()->position}})
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="accountNav">
                        <li><button class="dropdown-item" id="logoutBtn">Logout</button></li>
                    </ul>
                    <form action="{{route('logout')}}" method="POST" id="logoutForm">
                        @csrf
                    </form>
                </li>
                @else
                <li class="nav-item text-center">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                @endif
            </ul>
        </div>
        {{-- TEMPORARY SEARCH NAVBAR --}}
        <div class="topnav">
            <input type="text" placeholder="Search...">
        </div> 
    </div>
</nav>