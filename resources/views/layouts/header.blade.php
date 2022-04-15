<div class="super_container">
  <!-- Header -->
  

     <!-- Header -->
     <header class="header">
      <!-- Header Main -->
          <div class="header_main">
              <div class="container">
                  <div class="row align-items-center">
                      <!-- Logo -->
                      <div class="col-lg-2 col-sm-3 col-12 order-1">
                          <div class="logo_container">
                            <div class="logo"><a href="{{ route("home") }}"><img src="{{ url('img/logo.png') }}"></a></div>
                          </div>
                      </div> <!-- Search -->
                      <div class="col-lg-8 col-sm-9 col-12 mobileview order-lg-2 order-3 text-lg-left text-right mt-2">
                        <div class="main_nav_content d-flex flex-row">
                              <!-- Categories Menu -->
                              <!-- Main Nav Menu -->
                              
                                <div class=" navbar-collapse main_nav_menu ml-auto mr-auto" id="navbarSupportedContent">
                                  <ul class="standard_dropdown main_nav_dropdown justify-content-center">
                                    <li><a href="{{ route("home") }}">Home</a></li>
                                      <li class="hassubs"> <a href="#">About<i class="fa fa-angle-down"></i></a>
                                          <ul>
                                              <li><a href="shop.html">About 1</a></li>
                                              <li><a href="product.html">service 2</a></li>
                                              <li><a href="contact.html">Service 3</a></li>
                                          </ul>
                                      </li>
                                      <li class="hassubs"> <a href="#">Services<i class="fa fa-angle-down"></i></a>
                                         <ul>
                                              <li><a href="shop.html">Service 1</a></li>
                                              <li><a href="product.html">service 2</a></li>
                                              <li><a href="contact.html">Service 3</a></li>
                                          </ul>
                                      </li>
                                      <li class="hassubs"> <a href="#">Tour</a>
                                          
                                      </li>
                                      <li><a href="blog.html">Blog</a></li>
                                      <li  class="hassubs conborder"><a href="#">Contact<i class="fa fa-angle-down"></i></a>
   <ul>
                                              <li><a href="shop.html">Contact 1</a></li>
                                              <li><a href="product.html">service 2</a></li>
                                              <li><a href="contact.html">Service 3</a></li>
                                          </ul>
                                      </li>
                                      <li class="d-md-block d-lg-none"> <button class="btn btn-primary w-100 btn-form-sbmt">Appointment <img src="{{ url('img/arrow-right.png') }}"></button></li>
                                  </ul>
                              </div> <!-- Menu Trigger -->
                              <div class="menu_trigger_container ml-auto">
                                  <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                          <div class="menu_trigger_text">menu</div>
                                          <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div> <!-- Wishlist -->
                       <div class="col-lg-2 col-sm-2 col-12 mobileviewn order-lg-3 order-3 text-lg-left text-right">
                     

                      <a href="{{ route("home")}}">
                        <button class="btn btn-primary btn-form-sbmt">Appointment <img src="{{ url('img/arrow-right.png') }}"></button>
                      </a>
                    </div>
  
                  </div>
              </div>
          </div> <!-- Main Navigation -->
          <nav class="main_nav">
              <div class="container">
                  <div class="row">
                      <div class="col">
                          
                      </div>
                  </div>
              </div>
          </nav> <!-- Menu -->
        
      </header>

</div>