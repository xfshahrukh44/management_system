@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-12 col-md-12 col-lg-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="m-0 text-dark"><i class="nav-icon far fa-copyright"></i> Brands</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- fancybox styles -->
<style>
  /* The switch - the box around the slider */
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
</style>

<!-- see more (description) -->
<style>
  div.text-container {
      margin: 0 auto;
      width: 75%;    
  }

  .hideContent {
      overflow: hidden;
      line-height: 1em;
      height: 2em;
  }

  .showContent {
      line-height: 1em;
      height: auto;
  }
  .showContent{
    height: auto;
  }

  h1 {
    font-size: 24px;        
  }
  p {
      padding: 10px 0;
  }
  
  .show-more {
      padding: 10px 0;
      text-align: center;
  }
</style>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addBrandModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_brands')}}" class="form-wrapper">
          <div class="row">
              <!-- search bar -->
              <div class="topnav col-md-4 col-sm-4">
                <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
              </div>
              <!-- search button-->
              <button type="submit" class="btn btn-primary col-md-0 col-sm-0 justify-content-start" id="search_button">
                <i class="fas fa-search"></i>
              </button>
          </div>
        </form>
      </div>
      
      <!-- /.card-header -->
      <div class="card-body">
        <div class="col-md-12 col-sm-12" style="overflow-x:auto;">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Image</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Link</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($brands) > 0)
                @foreach($brands as $brand)
                  <tr role="row" class="odd">
                    <!-- image (fancybox) -->
                    <td class="{{'image'.$brand->id}}" width="140">
                        <a class="fancybox" href="{{($brand->image) ? (asset('img/brands') . '/' . $brand->image) : (asset('img/noimg.jpg'))}}">
                            <img src="{{($brand->image) ? (asset('img/brands') . '/' . $brand->image) : (asset('img/noimg.jpg'))}}" width="60%" alt="">
                        </a>
                    </td>

                    <!-- name -->
                    <td class="{{'name'.$brand->id}}">{{$brand->name}}</td>

                    <!-- link -->
                    <td class="{{'link'.$brand->id}}"><a href="{{$brand->link}}" target="_blank">{{$brand->link}}</a></td>

                    <!-- actions -->
                    <td width="100">
                        <!-- Detail -->
                        <!-- <a href="#" class="detailButton" data-id="{{$brand->id}}">
                          <i class="fas fa-eye green ml-1"></i>
                        </a> -->
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$brand->id}}">
                          <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$brand->id}}">
                          <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="4"><h6 align="center">No brand(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($brands) > 0)
        {{$brands->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('brand.store')}}" enctype="multipart/form-data">
        @csrf
        @include('admin.brand.brand_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('brand.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @csrf
        @include('admin.brand.brand_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Brand Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- TABS -->
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active bci" data-toggle="tab" href="#bci">Basic Brand Information</a>
              </li>
              <li class="nav-item" role="presentation" >
                <a class="nav-link" data-toggle="tab" href="#si">Shop Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#pi">Payment Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#ig">Image Gallery</a>
              </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content" id="myTabContent">
              <!-- basic brand info -->
              <div class="tab-pane fade show active" id="bci">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <img class="shop_keeper_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Name</td>
                                <td class="name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Contact #</td>
                                <td class="contact_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Whatsapp #</td>
                                <td class="whatsapp_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Brand Type</td>
                                <td class="type"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Shop info -->
              <div class="tab-pane fade" id="si">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <img class="shop_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Shop Name</td>
                                <td class="shop_name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Shop #</td>
                                <td class="shop_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Floor #</td>
                                <td class="floor"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Area</td>
                                <td class="area"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Market</td>
                                <td class="market"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Payment info -->
              <div class="tab-pane fade" id="pi">
                <div class="card-body">
                  <div class="col-md-12 col-sm-12">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Status</td>
                                <td class="status"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Visting Days</td>
                                <td class="visiting_days"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Cash on Delivery</td>
                                <td class="cash_on_delivery"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Opening Balance</td>
                                <td class="opening_balance"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Business to Date</td>
                                <td class="business_to_date"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Outstanding Balance</td>
                                <td class="outstanding_balance"></td>
                            </tr>
                            <tr role="row" class="odd" hidden>
                                <td class="">Special Discount</td>
                                <td class="special_discount"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Image Gallery -->
              <div class="tab-pane fade" id="ig">
                <div class="card-body row overflow-auto col-md-12 p-3 gallery_wrapper" style="height:28rem;">
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                    <a target="_blank" href="{{asset('img/logo.png')}}" class="col-md-4 mb-3">
                      <img class="col-md-12 shop_keeper_picture" src="{{asset('img/logo.png')}}">
                    </a>
                  <!-- </div> -->
                </div>
              </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteBrandModal" tabindex="-1" role="dialog" aria-labelledby="deleteBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBrandModalLabel">Delete Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('brand.destroy', 1)}}">
        <!-- hidden input -->
        @method('DELETE')
        @csrf
        <input class="hidden" type="hidden" name="hidden">
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger" id="deleteButton">Yes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    // $('#area_id').select2();
    // $('#market_id').select2();
    // datatable
    // $('#example1').DataTable();
    // $('#example1').dataTable({
    //   "bPaginate": false,
    //   "bLengthChange": false,
    //   "bFilter": true,
    //   "bInfo": false,
    //   "searching":false
    // });

    // get url params
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    }
  
    // persistent active sidebar
    var element = $('li a[href*="'+ window.location.pathname +'"]');
    element.parent().parent().parent().addClass('menu-open');
    element.addClass('active');

    // fancybox init
    $(".fancybox").fancybox({
        helpers: {
            title : {
                type : 'float'
            }
        }
    });

    // global vars
    var brand = "";

    // fetch brand
    function fetch_brand(id){
        $.ajax({
            url: '<?php echo(route("brand.show", 0)); ?>',
            type: 'GET',
            data: {id: id},
            dataType: 'JSON',
            async: false,
            success: function (data) {
                brand = data.brand;
            }
        });
    }

    // create
    $('#add_brand').on('click', function(){
        
    });

    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_brand(id);
        $('#hidden').val(id);

        $('#editForm .name').val(brand.name ? brand.name : '');
        $('#editForm .link').val(brand.link ? brand.link : '');

        // image
        // un hide preview div
        $('#editForm .preview_wrapper').prop('hidden', false);
        // update preview image
        if(brand.image){
          var src = `<?php echo(asset('img/brands') . '/temp'); ?>`;
          src = src.replace('temp', brand.image);
        }
        else{
          var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#editForm .preview_image').prop('src', src);
        
        $('#editBrandModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
      $('.bci').trigger('click');
      var id = $(this).data('id');
      fetch_brand(id);
      // var brand = $(this).data('object');
      $('.name').html(brand.name ? brand.name : '');
      $('.contact_number').html(brand.contact_number ? brand.contact_number : '');
      $('.whatsapp_number').html(brand.whatsapp_number);
      if(brand.shop_keeper_picture){
          var shop_path = $(this).data('shopkeeper');
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_keeper_picture').attr('src', shop_path);
      }
      $('.type').html(brand.type ? brand.type : '');
      $('.shop_name').html(brand.shop_name ? brand.shop_name : '');
      $('.shop_number').html(brand.shop_number ? brand.shop_number : '');
      $('.floor').html(brand.floor ? brand.floor : '');
      $('.area').html((brand.market && brand.market.area) ? brand.market.area.name : '');
      $('.market').html(brand.market ? brand.market.name : '');
      if(brand.shop_picture){
          var shop_path = $(this).data('shop');
          $('.shop_picture').attr('src', shop_path);
      }
      else{
          var shop_path = '{{asset("img/logo.png")}}';
          $('.shop_picture').attr('src', shop_path);
      }
      // image gallery work
      $('.gallery_wrapper').html('');
      if(brand.brand_images.length > 0){
          for(var i = 0; i < brand.brand_images.length; i++){
          $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/brand_images')}}/`+brand.brand_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/brand_images')}}/`+brand.brand_images[i].location+`"></a><button class="btn btn_del_brand_image" value="`+brand.brand_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
          }
      }
      $('.status').html(brand.status ? brand.status : '');
      $('.visiting_days').html(brand.visiting_days ? brand.visiting_days : '');
      $('.cash_on_delivery').html(brand.cash_on_delivery ? brand.cash_on_delivery : '');
      $('.opening_balance').html(brand.opening_balance ? ("Rs. " + brand.opening_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.business_to_date').html(brand.business_to_date ? ("Rs. " + brand.business_to_date.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      $('.outstanding_balance').html(brand.outstanding_balance ? ("Rs. " + brand.outstanding_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '');
      // $('.special_discount').html(brand.special_discount ? ("Rs. " + brand.special_discount) : '');
      $('#viewBrandModal').modal('show');
    });

    // delete
    $('.deleteButton').on('click', function(){
      var id = $(this).data('id');
      $('#deleteForm').attr('action', "{{route('brand.destroy', 1)}}");
      $('#deleteForm .hidden').val(id);
      $('#deleteBrandModalLabel').text('Delete Brand: ' + $('.name' + id).html() + "?");
      $('#deleteBrandModal').modal('show');
    });

    // on image click (preview)
    $('#editForm .image').on('change', function(){
      // console.log($(this)[0]);
      // console.log($(this).parent().find('img'));
      var input = ($(this))[0];
      var preview_target = $(this).parent().find('img');

      if (input.files && input.files[0]) {
          var reader = new FileReader();
  
          reader.onload = function (e) {
              preview_target
                      .attr('src', e.target.result);
          };
  
          reader.readAsDataURL(input.files[0]);
      }
    });
});
</script>
@endsection('content_body')