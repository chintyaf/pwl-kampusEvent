  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky background-header">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="/" class="logo">
                          <h1>Evoria</h1>
                      </a>
                      <!-- ***** Logo End ***** -->

                      <!-- ***** Serach Start ***** -->

                      {{-- <div class="search-input">
                          <form id="search" action="#">
                              <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword"
                                  onkeypress="handle" />
                              <i class="fa fa-search"></i>
                          </form>
                      </div> --}}
                      <!-- ***** Serach Start ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                          <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                          <!-- <li class="scroll-to-section"><a href="#services">Services</a></li> -->
                          <!-- <li class="scroll-to-section"><a href="#courses">Courses</a></li> -->
                          <!-- <li class="scroll-to-section"><a href="#team">Team</a></li> -->
                          <li class="scroll-to-section"><a href="#events">Events</a></li>
                          <li class="scroll-to-section"><a href="">Account</a></li>
                          @if (!session()->has('token'))
                              <li class="scroll-to-section"><a href="{{ route('login') }}">Log in</a></li>
                              <li class="scroll-to-section"><a href="{{ route('register') }}">Register</a></li>
                          @else
                              <li class="scroll-to-section"><a href="{{ route('member.profile') }}">Profile</a></li>
                              <li class="scroll-to-section"><a class="logout-btn" data-url="/logout">Log Out</a></li>
                              <form id="logout-form" method="POST" style="display: none;">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </form>
                          @endif
                      </ul>
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                      <!-- ***** Menu End ***** -->
                  </nav>
              </div>
          </div>
      </div>
  </header>
  <!-- ***** Header Area End ***** -->
