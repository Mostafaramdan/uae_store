@push('script')
    <script type="text/javascript"> 
        function changeLang(){

            var lang = localStorage.getItem("lang");
            if(lang == null ){
                localStorage.setItem("lang", "Ar");
                lang= "Ar";
            } 

            // change href file 
            if(lang=="En"){
                $('link[href="{{url("/")}}/dashboard/bootstrapRTL.min.css"]').attr('href',"{{url('/')}}/dashboard/bootstrap.min.css");
                $("body").css("direction","ltr").addClass("en").removeClass("ar");
                $("table").css("direction","ltr");
                $("#sign-out").css('transform', 'rotate(360deg)');
            }else{
                $('link[href="{{url("/")}}/dashboard/bootstrap.min.css"]').attr('href',"{{url('/')}}/dashboard/bootstrapRTL.min.css");
                $("body").css("direction","rtl").addClass("ar").removeClass("en");
                $("table").css("direction","rtl");
                $("#sign-out").css('transform', 'rotate(180deg)');
            }
            $.ajax({
                url: "{{route('dashboard.changeLang')}}?lang="+lang,
            });
            //changeLangButton
            $("#changeLanguage").find("span").html(languagesWords[lang].changeLangButton);
            $("#view-modal h5").html(languagesWords[lang].detailViewModal);

            
            // slidbar
            $(this).find("span").html(languagesWords[lang].changeLangButton);
            $(".main-sidebar .statistics span").html(languagesWords[lang].statistics);
            $(".main-sidebar .users span").html(languagesWords[lang].users);
            $(".main-sidebar .drivers span").html(languagesWords[lang].drivers);
            $(".main-sidebar .stores span").html(languagesWords[lang].stores);
            $(".main-sidebar .categories span").html(languagesWords[lang].categories);
            $(".main-sidebar .products span").html(languagesWords[lang].products);
            $(".main-sidebar .orders span").html(languagesWords[lang].orders);
            $(".main-sidebar .reports span").html(languagesWords[lang].reports);
            $(".main-sidebar .regions span").html(languagesWords[lang].regions);
            $(".main-sidebar .points span").html(languagesWords[lang].points);
            $(".main-sidebar .contacts span").html(languagesWords[lang].contacts);
            $(".main-sidebar .faqs span").html(languagesWords[lang].faqs);
            $(".main-sidebar .ads span").html(languagesWords[lang].ads);
            $(".main-sidebar .notifications span").html(languagesWords[lang].notifications);
            $(".main-sidebar .admins span").html(languagesWords[lang].admins);
            $(".main-sidebar .appInfo span").html(languagesWords[lang].appInfo);
            

            // above table 
            $(".m-0").html(languagesWords[lang]["{{\Request::segment(2)}}"]);
  

            // title 
            document.title=languagesWords[lang]["{{\Request::segment(2)}}"];

            // form option 
            $("input[name='search']").attr('placeholder',languagesWords[lang].search);
            $("input[type='search']").attr('placeholder',languagesWords[lang].search);

            $("select[name='sortType']  option:eq(0)").html(languagesWords[lang].sortType);
            $("select[name='sortType']  option:eq(1)").html(languagesWords[lang].sortByACS);
            $("select[name='sortType']  option:eq(2)").html(languagesWords[lang].sortByDesc);

            $("select[name='sortBy']  option:eq(0)").html(languagesWords[lang].sortBy);
            $("select[name='sortBy'] option[value='name'").html(languagesWords[lang].sortByName);
            $("select[name='sortBy'] option[value='createdAt'").html(languagesWords[lang].sortByCreatedAt);
            $("select[name='sortBy'] option[value='isApproved'").html(languagesWords[lang].sortByIsApproved);
      
            $(".add").html(languagesWords[lang].addNewButton+ ' '+ ` <i class="ml-2 fas fa-plus-circle"></i>`) ;
       
            // addEditModal 
            $(".imageuploadify-message").html(languagesWords[lang].insertPhotos);
            //viewModal 
            $(".view-modal .modal-body h5").html(languagesWords[lang].detailViewModal);
            $(".view-modal .modal-header h5").html(languagesWords[lang].detailViewModal);

            // statictics module
            $("span.from").html(languagesWords[lang].from);
            $("span.to").html(languagesWords[lang].to);
            $("span.send").html(languagesWords[lang].send);
            $("span.total-users").html(languagesWords[lang]['total users']);
            $("span.total-drivers").html(languagesWords[lang]['total drivers']);
            $("span.total-stores").html(languagesWords[lang]['total stores']);
            $("span.total-orders").html(languagesWords[lang]['total orders']);


            // users Module 
            $("th.name").html(languagesWords[lang]['name']);
            $("th.phone").html(languagesWords[lang]['phone']);
            $("th.email").html(languagesWords[lang]['email']);
            $("th.balance-details").html(languagesWords[lang]['balance details']);
            $("th.created_at").html(languagesWords[lang]['created_at']);
            $("th.activation").html(languagesWords[lang]['activation']);
            $("th.acceptable").html(languagesWords[lang]['acceptable']);
            $("th.category").html(languagesWords[lang]['category']);
            $("th.relate-to-category").html(languagesWords[lang]['relate to category']);
            
            $("label[for='name']").html(languagesWords[lang]['name']);
            $("label[for='phone']").html(languagesWords[lang]['phone']);
            $("label[for='email']").html(languagesWords[lang]['email']);
            $("label[for='balance-details']").html(languagesWords[lang]['balance details']);
            $("label[for='balance']").html(languagesWords[lang]['balance']);
            $("label[for='created_at']").html(languagesWords[lang]['created_at']);
            $("label[for='activation']").html(languagesWords[lang]['activation']);
            $(":file").parents(".row").find("button").html(languagesWords[lang]['changeImageButton']);
            $("label[for='nameAr']").html(languagesWords[lang]['name ar']);
            $("label[for='nameEn']").html(languagesWords[lang]['name en']);
            $("label[for='descriptionAr']").html(languagesWords[lang]['description ar']);
            $("label[for='descriptionEn']").html(languagesWords[lang]['description en']);
            $("label[for='stores_id']").html(languagesWords[lang]['choose store']);
            $("label[for='categoriess_id']").html(languagesWords[lang]['choose category']);
            $(".relate_to_category").html(languagesWords[lang]['relate to category']);
            $(".stores_has_offer").html(languagesWords[lang]['stores has offer']);
            
            $("label[for='password']").html(languagesWords[lang]['password']);
            $("label[for='deliveryTime']").html(languagesWords[lang]['delivery time']);
            $("label[for='fees']").html(languagesWords[lang]['fees']);
            $("label[for='quantity']").html(languagesWords[lang]['quantity']);
            $("label[for='price']").html(languagesWords[lang]['price']);
            $("label[for='timeType']").html(languagesWords[lang]['time type']);
            $(".add-discount-code").html(languagesWords[lang]['add discount code']);
            $("label[for='categories_id']").html(languagesWords[lang]['choose category']);
            $("label[for='discountCode']").html(languagesWords[lang]['discount code']);
            $("label[for='discount-percentage']").html(languagesWords[lang]['discount percentage']);
            $("select[name='timeUnit']  option:eq(0)").html(languagesWords[lang].minutes);
            $("select[name='timeUnit']  option:eq(1)").html(languagesWords[lang].hours);
            $("select[name='timeUnit']  option:eq(2)").html(languagesWords[lang].days);
            $(".locate-the-store").html(languagesWords[lang]['locate the store from here then copy the link'])
            $("label[for='mapUrl']").html(languagesWords[lang]['mapUrl']);
            $("label[for='address']").html(languagesWords[lang]['address']);
            $(".code").html(languagesWords[lang]['code']);
            $(".store").html(languagesWords[lang]['store']);
            $(".status").html(languagesWords[lang]['status']);
            $(".details").html(languagesWords[lang]['details']);
            $("label[for='status']").html(languagesWords[lang]['status']);

            $("select[name='status'] option[value='waiting']").html(languagesWords[lang]['waiting']);
            $("select[name='status'] option[value='cancel']").html(languagesWords[lang]['cancel']);
            $("select[name='status'] option[value='accept']").html(languagesWords[lang]['accept']);
            $("select[name='status'] option[value='finished']").html(languagesWords[lang]['finished']);
            
            $("#delete-modal .modal-body").html(languagesWords[lang]['confirmation delete message']);
            $("#delete-modal .btn-danger").html(languagesWords[lang]['delete']);
            $("#delete-modal .btn-secondary").html(languagesWords[lang]['cancel']);

            // view modal 
            $("#view-modal .btn-secondary, .balaneInfo-modal .btn-secondary").html(languagesWords[lang]['closedBtnInViewModal'])
            $(".list-lang").each(function(){
                $(this).html($(this).attr(lang));
            });




        //    $("span.name").parents('.list-group-item ').text(languagesWords[lang]['name'] ).html($("span.name").clone());
            // $("span.phone").parents('.list-group-item ').text(languagesWords[lang]['phone'] +  $("span.phone").clone());
            // $("span.email").parents('.list-group-item ').text(languagesWords[lang]['email'] + $("span.email").clone() );
            // $("span.balance-details").parents('.list-group-item ').text(languagesWords[lang]['balance details'] +  $("span.balance-details").clone() );
            // $("span.created_at").parents('.list-group-item ').text(languagesWords[lang]['created_at']+ $("span.created_at").clone());
            // $("span.activation").parents('.list-group-item ').text(languagesWords[lang]['activation']+ $("span.activation").clone());

        }    
         var languagesWords= {
            "Ar":{
                "statistics":"الاحصائيات",
                "users":"المستخدمين ",
                "drivers":"السائقين",
                "stores":"الفروع",
                "categories":"الاقسام",
                "offers":'العروض',
                "products":"المنتجات",
                "orders":"الطلبات",
                "reports":"التقارير",
                "regions":"الامارات-المدن ",
                "points":"النقاط",
                "notifications":"الاشعارات",
                "contacts":"الشكاوي ",
                "faqs":"الاسالة الشائعة",
                "admins":"المسؤولين",
                "ads":"الاعلانات",
                "notifications":"الاشعارات",
                "appInfo":"اعدادات التطبيق",
                "changeLangButton":"English",
                "search":"بحث",
                "sortBy":"الترتيب علي حسب",
                "sortByName":"الاسم",
                "sortByIsApproved":"في انتظار الموافقة",
                "sortByCreatedAt":"تاريخ الانشاء",
                "sortType":" نوع الترتيب ",
                "sortByACS":"تصاعدي",
                "sortByDesc":"تنازلي",
                'addNewButton':"إضافة جديد",
                "closedBtnInModal":"إلغاء",
                "saveNewBtnInModal":"حفظ",
                "editBtnInModal":"تعديل",
                "detailViewModal":"التفاصيل",
                "price_list":"اسعار التوصيل",
                
                "closedBtnInViewModal":"إغلاق",

                //  this excute by text direct ; 
                "from":"من",
                "to":"إلي",
                "send":"إرسال",
                "total users":"إجمالي المستخدمين",
                "total drivers":"إجمالي السائقين",
                "total stores":"إجمالي الفروع",
                "total orders":"إجمالي الطلبات",

                "name":"الاسم",
                "phone":"التليفون",
                "email":"البريد الالكتروني",
                "fees" :"الرسوم",
                "balance ":" الرصيد",
                "balance details":"تفاصيل الرصيد",
                "created_at":"وقت الانشاء",
                "activation":"التفعيل",
                "changeImageButton":"اختر صورة",
                "acceptable" : "الموافقة" ,
                'category' :'القسم',
                'relate to category':"تابع لقسم",
                "name ar":"الاسم بالعربي",
                "name en":"الاسم بالانجليزي",
                "description ar":"الوصف بالعربي",
                "description en":"الوصف بالانجليزي",

                "quantity":"الكمية",
                "price":"السعر",
                "choose category":"اختر قسم ",
                "choose store":"اختر متجر ",
                "free delivery":"توصيل مجانا",
                "offer":"عرض  ",
                "stores has offer":"فروع لها خصومات  ",
                "discount percentage":"نسبة الخصم ",
                "start date":"تاريخ البداية     ",
                "end date":" تاريخ النهاية ",
                "choose image" : "ادخل الصور ",
                "put your image her":"ضع الصور التي تريد تحمليها هنا",
                "choose your image from your pc ":"اختر الصور من جهازك",

                "password" : "الرقم السري",
                "delivery time":"وقت التوصيل",
                "time type":"وقت التوصيل",

                "discount code":"كود الخصم",
                "minutes":"دقائق",
                "hours":"ساعات",
                "days":"ايام",

                "add discount code":"إضافة كود خصم",
                "mapUrl":"ادخل عنوان الخريطة",
                "locate the store from here then copy the link":"حدد مكان المتجر من هنا ثم انسخ الرابط",
                "address":"العنوان",
                "code":"الكود",
                "store":"المتجر",
                "status":"الحالة",
                "details":"التفاصيل",
                "waiting":"في الانتظار",
                "cancel":"إلغاء  ",
                "accept":"قبول ",
                "finished":"تم الانتهاء ",
                "insertPhotos" :"ضع الصور التي تريد تحمليها هنا",
                'move to the map':'الإنتقال إلي الخريطة',
                'confirmation delete message':'هل أنت متأكد من مسح هذا العنصر ؟',
                'delete':'مسح',
                'uploading':'تم الرفع بنجاح',
            },
            "En":{ 
                'uploading':'uploading successfully',
                "statistics":"statistics",
                "price_list":"delivery prices ",
                "offers":'offers',
                "users":"users",
                "drivers":"drivers",
                "stores":"branches",
                "categories":"categories",
                "products":"products",
                "orders":"orders",
                "reports":"reports",
                "regions":"Emirates-cities",
                "points":"points",
                "notifications":"notifications",
                "contacts":"contacts",
                "faqs":"faqs",
                "admins":"admins",
                "ads":"ads",
                "notifications":"notifications",
                "appInfo":"appInfo",
                "changeLangButton":"العربية",
                "search":"search",
                "sortBy":"sort By",
                "sortByName":"name",
                "sortByIsApproved":"waiting to approved",
                "sortByCreatedAt":"created at  ",
                "sortType":" sort type ",
                "sortByACS":"ACS",
                "sortByDesc":"DESC",
                "addNewButton":" Add New ",
                "closedBtnInModal":"cancel",
                "saveNewBtnInModal":"save",
                "editBtnInModal":"edit",
                "detailViewModal":"details",

                //  this excute by text direct ; 
                "from":"from",
                "to":"to",
                "send":"send",
                "total users":" total users  ",
                "total drivers":" total drivers  ",
                "total stores":" total stores ",
                "total orders":" total orders ",

                // users module 
                "name":"name",
                "phone":"phone",
                "email":" email  ",
                "fees ":" fees ",
                "balance ":" balance ",
                "balance details":" balance details  ",
                "created_at":" created_at  ",
                "activation":" activation ",
                "changeImageButton":"change Image   ",
                "acceptable" : "acceptable" ,
                'category' :'category',
                'relate to category':"relate to category",

                "name ar":"name ar",
                "name en":"name en ",
                "description ar":"description ar  ",
                "description en":"description en  ",
               
                "closedBtnInViewModal":"cancel",

                "quantity":"quantity",
                "price":"price",
                "choose category":"choose category   ",
                "choose store":"  choose store ",
                "free delivery":"free delivery  ",
                "offer":"offer  ",
                "discount percentage":"discount percentage   ",
                "start date":"start date  ",
                "end  date":"end  date ",
                "choose image" : "choose image   ",
                "put your image her":" put your image her",
                "choose your image from your pc ":"choose your image from your pc",
                "stores has offer":"stores has offer  ",

                "password" : "  password",
                "delivery time":"delivery time",
                "time type":"time type",
                "discount code":"discount code",

                "minutes":"minutes",
                "hours":"hours",
                "days":"days",
                "fees" :"fees",
                "add discount code":"add discount code",
                "mapUrl":"insert map url",
                "locate the store from here then copy the link":"Locate the store from here, then copy the link",
                "address":"address",

                "code":"code",
                "store":"store",
                "status":"status",
                "details":"details",

                "waiting":"waiting  ",
                "cancel":"cancel  ",
                "accept":"accept  ",
                "finished":"finished  ",

                "insertPhotos" :"Place the photos you want to upload here",
                'move to the map':'move to the map',

                'confirmation delete message':'Are you sure to delete this item?',
                'delete':'delete',
            }
         };
        $("body").on("click","#changeLanguage",function(e){
            e.preventDefault();
            var lang = localStorage.getItem("lang");
            if(lang == null ){
                localStorage.setItem("lang", "Ar");
            }else if(lang == "Ar"){
                localStorage.setItem("lang", "En");
                lang= "En";
            }else{
                localStorage.setItem("lang", "Ar");
                lang= "Ar";
            }
            // localStorage.setItem("lang", "Ar");
            changeLang();
        });
        $("body").on("click",".edit, .settings",function(){
            var lang = localStorage.getItem("lang");
            $(".modal-footer .btn-danger").html(languagesWords[lang].closedBtnInModal);
            $(".modal-footer .btn-success").html(languagesWords[lang].editBtnInModal);
            $(".addEdit-new-modal .modal-title").html(languagesWords[lang].editBtnInModal);

        });
        $("body").on("click",".add",function(){
            var lang = localStorage.getItem("lang");
            $(".modal-footer .btn-danger").html(languagesWords[lang].closedBtnInModal);
            $(".modal-footer .btn-success").html(languagesWords[lang].addNewButton);
            $(".addEdit-new-modal .modal-title").html(languagesWords[lang].addNewButton);
        });

        changeLang();
        
        function getNodesThatContain(text,textReplacement) {

            // $('th:contains("'+text+'")').text( textReplacement);

            $('th').contents().filter(function() {
                return this.nodeType == 3
            }).each(function(){
                this.textContent = this.textContent.replace(text,textReplacement);
            });
        };

    </script>
@endpush