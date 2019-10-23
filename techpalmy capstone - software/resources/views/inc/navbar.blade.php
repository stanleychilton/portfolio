<nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <!-- TechPalmy is the home button, takes back to index of site (brand of navbar) -->
      <a class="navbar-brand" href="/">{{config('app.name', 'TechPalmy')}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <!-- Search Bar -->
            @include('inc.search')
          </li>
        </ul>
        
        <ul class="navbar-nav">
        <!-- If user is logged in, show profile and Logout button. Elsewise, show login form and signup button. -->
        @guest
        
        <!-- <li class="nav-item">
            <form id='LoginSignup' action="" method='POST'>UserName:<input type='text' name='username' placeholder='Enter UserName'> Password:<input type='password' name='password' placeholder='Enter Password'><input type='submit'/></form>
        </li> -->
        <li class="nav-item">
            <button type='button' class='btn btn-outline-success btn-lg' data-toggle='modal' onclick="location.href='/login'">Login</button>
        </li>
         
        <li><p>Y</p></li>

        <li class="nav-item">
            <button type='button' class='btn btn-success btn-lg' data-toggle='modal' onclick="location.href='/register'">Signup</button>
        </li>
        @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/user">
                    {{ __('My Profile') }}
                </a>
                <a class="dropdown-item" href=""
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        </ul>
        @endguest

      </div>
</nav>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


