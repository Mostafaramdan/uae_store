<aside class="main-sidebar open">
      <div class="sidebar-heading d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#"><span class='list-lang' ar='مرحبا' en='hello '></span> {{Auth::guard('dashboard')->user()->name??Auth::guard('stores')->user()->name}}  </a>
        <i class="fas fa-bars fa-lg icon toggle-sidebar-icon d-none d-xl-block"></i>
        <i class="fas fa-times fa-lg icon toggle-sidebar-icon d-block d-xl-none"></i>
      </div>
      <ul class="nav d-block sidebar-links-container">
        <li class="nav-item  statistics ">
          <a class="nav-link {{ Request::is('*statistics*') ? 'active ' : '' }}" href="{{route('dashboard.statistics.index')}}"><i class="fas fa-chart-line mr-2"></i> <span>التقارير</span></a>
        </li>
        <li class="nav-item  users ">
          <a class="nav-link {{ Request::is('*users*') ? 'active ' : '' }}" href="{{route('dashboard.users.index')}}"><i class="fas fa-users mr-2"></i> <span>المستخدمين</span></a>
        </li>
        <li class="nav-item  drivers ">
          <a class="nav-link {{ Request::is('*drivers*') ? 'active ' : '' }}" href="{{route('dashboard.drivers.index')}}"><i class="fas fa-car mr-2"></i> <span>السائقين</span></a>
        </li>
        <li class="nav-item stores ">
          <a class="nav-link {{ Request::is('*stores*') ? 'active ' : '' }}" href="{{route('dashboard.stores.index')}}"><i class="fas fa-store-alt mr-2"></i><span>المتاجر</span></a>
        </li>
        <li class="nav-item categories ">
          <a class="nav-link {{ Request::is('*categories*') ? 'active ' : '' }}" href="{{route('dashboard.categories.index')}}"><i class="fas fa-list mr-2"></i><span>الأقسام</span></a>
        </li>
        <li class="nav-item products ">
          <a class="nav-link {{ Request::is('*products*') ? 'active ' : '' }}" href="{{route('dashboard.products.index')}}"><i class="fas fa-list mr-2"></i><span>المنتجات</span></a>
        </li>
        <li class="nav-item orders ">
          <a class="nav-link {{ Request::is('*orders*') ? 'active ' : '' }}" href="{{route('dashboard.orders.index')}}"><i class="fas fa-luggage-cart mr-2"></i><span>الطلبات</span></a>
        </li>
        <li class="nav-item regions ">
          <a class="nav-link {{ Request::is('*regions*') ? 'active ' : '' }}" href="{{route('dashboard.regions.index')}}"><i class="fas fa-globe-europe mr-2"></i><span> الامارات - المدن-المناطق</span></a>
        </li>
        <!-- <li class="nav-item points ">
          <a class="nav-link {{ Request::is('*points*') ? 'active ' : '' }}" href="{{route('dashboard.points.index')}}"><i class="fab  fa-bitcoin mr-2"></i><span> النقاط </span></a>
        </li> -->
        <li class="nav-item ads ">
          <a class="nav-link {{ Request::is('*ads*') ? 'active ' : '' }}" href="{{route('dashboard.ads.index')}}"><i class="fab fa-adversal fa-1x mr-2"></i><span>الأعلانات</span></a>
        </li>
        <li class="nav-item offers ">
          <a class="nav-link {{ Request::is('*offers*') ? 'active ' : '' }}" href="{{route('dashboard.offers.index')}}"><i class="fas fa-dollar-sign fa-1x mr-2"></i><span >العروض</span></a>
        </li>
        <li class="nav-item notifications ">
          <a class="nav-link {{ Request::is('*notifications*') ? 'active ' : '' }}" href="{{route('dashboard.notifications.index')}}"><i class="far fa-bell  mr-2"></i><span>الإشعارات</span></a>
        </li>
        <li class="nav-item price_list">
            <a class="nav-link {{ Request::is('*price_list*') ? 'active ' : '' }}" href="{{route('dashboard.price_list.index')}}"><i class="fas fa-users mr-2"></i> <span>الاسعار لكل كيلو</span></a>
        </li>
        <li class="nav-item contacts ">
          <a class="nav-link {{ Request::is('*contacts*') ? 'active ' : '' }}" href="{{route('dashboard.contacts.index')}}"><i class="fas fa-envelope-open-text mr-2" ></i><span>الشكاوي والإقتراحات</span></a>
        </li>
        <li class="nav-item reports ">
          <a class="nav-link {{ Request::is('*reports*') ? 'active ' : '' }}" href="{{route('dashboard.reports.index')}}"><i class="fas fa-chart-bar mr-2"></i><span>التقارير المفصلة</span></a>
        </li>
        <li class="nav-item faqs ">
          <a class="nav-link {{ Request::is('*faqs*') ? 'active ' : '' }}" href="{{route('dashboard.faqs.index')}}"><i class="fas fa-question mr-2" ></i><span> الأسئلة الشائعة</span></a>
        </li>
        <li class="nav-item admins">
          <a class="nav-link {{ Request::is('*admins*') ? 'active ' : '' }}" href="{{route('dashboard.admins.index')}}"><i class="fas fa-user-shield mr-2" ></i><span>المسؤولين</span></a>
        </li>
        <li class="nav-item appInfo">
          <a class="nav-link {{ Request::is('*appInfo*') ? 'active ' : '' }}" href="{{route('dashboard.appInfo.index')}}"><i class="fas fa-cogs  mr-2"></i><span>إعدادات التطبيق </span></a>
        </li>
      </li>
  </ul>
</aside>