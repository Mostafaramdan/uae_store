@extends ('dashboard.layouts.master')
@section('title', 'التقارير')
@section ('content')
    <div class="content" >
      <div  id="alert">
      </div>
      <div class="d-flex align-items-center mb-4">
        <h2 class="m-0"># التقارير</h2>
      </div>
      <form class="mb-4" id="getOptions">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-row"> 
          <div class="m-2">
            <label> <span class="from"> من </span>: </label>
            <input type="date" name="fromDate" class="form-control" placeholder="Search">
          </div>
          <div class="m-2">
            <label> <span class="to"> إلي</span>  : </label>
            <input type="date" name="toDate" class="form-control" placeholder="Search">
          </div>
          <div  style="margin-top:40px">
            <a class="btn btn-primary text-white getByRang mt" > <span class="send"> ارسال<span></a>
          </div>
      </form>  
    </div>
    <div class="row mb-4">
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            <span class="total-users" > أجمالي المستخدمين</span>
            <i class="fas fa-users mr-2 fa-2x "></i>
          </div>
          <div class="card-body">
            <h5 class="card-title usersCount">{{$usersCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-success  mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            <span class="total-drivers"> أجمالي السائقين</span>
            <i class="fas fa-car  mr-2 fa-2x"></i>
          </div>
          <div class="card-body">
          <h5 class="card-title driversCount">{{$driversCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-danger  mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
          <span class="total-stores"> أجمالي المتاجر</span>
            <i class="fas fa-store-alt  mr-2 fa-2x"></i>
          </div>
          <div class="card-body">
          <h5 class="card-title storesCount">{{$storesCount}}   </h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="card text-white bg-info  mb-3" style="max-width: 18rem;">
          <div class="card-header align-items-center font-weight-bold">
            <span class="total-orders"> أجمالي الطلبات</span>
            <i class="fas fa-luggage-cart  mr-2 fa-2x"></i>
          </div>
          <div class="card-body">
          <h5 class="card-title ordersCount">{{$ordersCount}}   </h5>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom: 20px">
        <div class="col-sm-12">
            <canvas id="Chart"></canvas>
        </div>
      </div>  
</div>
@push('script')
<script src="{{ asset('dashboard/chart.js') }}"></script>
<script src="{{ asset('dashboard/sam.js') }}"></script>
<script>
    langWords={
      'Ar':{
        "total users":"إجمالي المستخدمين",
        "total drivers":"إجمالي السائقين",
        "total stores":"إجمالي المتاجر",
        "total orders":"إجمالي الطلبات",
        "total":"إجمالي",
      },
      'En':{
        "total users":"total users",
        "total drivers":"total drivers",
        "total stores":"total stores",
        "total orders":"total orders",
        "total":"total",
      }
    };
    var lang = localStorage.getItem("lang");
    var ctx = document.getElementById('Chart').getContext('2d');
    var labels = [
        '0',
        'يناير',
        'فبراير',
        'مارس',
        'ابريل',
        'مايو',
        'يونيو',
        'يوليو',
        'أغسطس',
        'سيبتمبر',
        'أكتوبر',
        'نوفمبر',
        'ديسمبر',
    ];

    var datasets = [
        { 
          fill: false,
          label: langWords[lang]['total users'],
          data: sam.fillTheMissedMonthes({!! $users !!}, true),
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          borderWidth: 3
        },
        { 
            fill: false,
            label: langWords[lang]['total drivers'],
            data: sam.fillTheMissedMonthes({!! $drivers !!}, true),
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            borderWidth: 3
        },
        { 
            fill: false,
            label: langWords[lang]['total stores'],
            data: sam.fillTheMissedMonthes({!! $stores !!}, true),
            backgroundColor: '#dc3545',
            borderColor: '#dc3545',
            borderWidth: 3
        },
        { 
            fill: false,
            label: langWords[lang]['total orders'],
            data: sam.fillTheMissedMonthes({!! $orders !!}, true),
            backgroundColor: '#17a2b8',
            borderColor: '#17a2b8',
            borderWidth: 3
        }
    ];
    var title =langWords[lang]['total'];
    sam.loadMultiLineChart(ctx, labels, datasets, title);
    $("body").on("click",".getByRang",function(){
      var data = new FormData();
      data.append('from',$("#getOptions input[name='fromDate']").val());
      data.append('to',$("#getOptions input[name='toDate']").val());
      data.append('_token', $('input[name=_token]').val());
      $.ajax({
        url: "{{Request::segment(2)}}/getByDateRange",
        type: 'POST',
        data:data,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $(".loading-container").toggleClass("d-none d-flix");
        },
        success: function(record) {
          $(".loading-container").toggleClass("d-none d-flix");
          $(".usersCount").html(record.usersCount);
          $(".driversCount").html(record.driversCount);
          $(".storesCount").html(record.storesCount);
          $(".ordersCount").html(record.ordersCount);
        }
      });
    });
</script>
@endpush
@endsection
        