<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      {{ link_to_route('home', 'Chain of Memories', null, ['class' => 'navbar-brand']) }}
    </div>
    <div class="collapse navbar-collapse" id="navigation">
      <ul class="nav navbar-nav">
        <li class="{{ Active::pattern('/') }}">{{ link_to_route('home', 'Home') }}</li>

        @if (Session::has('access_token'))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Journals <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li>{{ link_to_route('journals.create', 'Write Entry') }}</li>
                <li role="separator" class="divider"></li>
                <li>{{ link_to_route('journals.index', 'View Volumes') }}</li>
                <li>{{ link_to_route('journals.random', 'Random Entry') }}</li>
                <li role="separator" class="divider"></li>
                <li>{{ link_to_route('journals.search', 'Search') }}</li>
              </ul>
            </li>
            <li>{{ link_to_route('auth.logout', 'Sign Out') }}</li>
        @else
            @if (Route::currentRouteName() != 'auth.login')
                <li>{{ link_to_route('auth.login', 'Sign In') }}</li>
            @endif
        @endif

      </ul>
    </div>
  </div>
</nav>