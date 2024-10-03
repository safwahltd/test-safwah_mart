<nav class="navbar navbar-expand-lg fixed-top" style="border-bottom: 4px solid #346cb0; background-color: #efefef">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"> <img src="{{ asset($company['favicon_icon']) }}" alt="" height="25"> {{ $company->name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item bg-light dropdown">
                    <a class="nav-link d-flex align-items-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" href="javascript:void(0)">
                        <i class="fas fa-user-circle" style="font-size: 30px !important;"></i>
                        <span style="line-height: 15px !important; margin-left: 5px;">
                            Welcome, <br>
                            {{ optional(auth()->user())->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                        style="margin-left: -20px !important;">
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                               <i class="fa fa-sign-out-alt"></i> 
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>