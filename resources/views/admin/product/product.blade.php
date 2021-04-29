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
    <h1 class="m-0 text-dark"><i class="nav-icon fab fa-product-hunt"></i> Products</h1>
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

<!-- rating styles -->
<style>
   .rating {
      float:left;
      border:none;
  }
  .rating:not(:checked) > input {
      position:absolute;
      top:-9999px;
      clip:rect(0, 0, 0, 0);
  }
  .rating:not(:checked) > label {
      float:right;
      width:1em;
      padding:0 .1em;
      overflow:hidden;
      white-space:nowrap;
      cursor:pointer;
      font-size:200%;
      line-height:1.2;
      color:#ddd;
  }
  .rating:not(:checked) > label:before {
      content:'★ ';
  }
  .rating > input:checked ~ label {
      color: #f70;
  }
  .rating:not(:checked) > label:hover, .rating:not(:checked) > label:hover ~ label {
      color: gold;
  }
  .rating > input:checked + label:hover, .rating > input:checked + label:hover ~ label, .rating > input:checked ~ label:hover, .rating > input:checked ~ label:hover ~ label, .rating > label:hover ~ input:checked ~ label {
      color: #ea0;
  }
  .rating > label:active {
      position:relative;
  }
</style>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addProductModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_products')}}" class="form-wrapper">
          <div class="row">
              <!-- search bar -->
              <div class="topnav col-md-4">
                <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
              </div>
              <!-- search button-->
              <button type="submit" class="btn btn-primary col-md-0 justify-content-start" id="search_button">
                <i class="fas fa-search"></i>
              </button>
          </div>
        </form>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="col-md-12" style="overflow-x:auto;">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Image</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Category</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Brand</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Unit</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Price</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($products) > 0)
                @foreach($products as $product)
                  <tr role="row" class="odd">
                    <!-- image (fancybox) -->
                    <td class="{{'image'.$product->id}}" width="140">
                        <a class="fancybox" href="{{($product->image) ? (asset('img/products') . '/' . $product->image) : (asset('img/noimg.jpg'))}}">
                            <img src="{{($product->image) ? (asset('img/products') . '/' . $product->image) : (asset('img/noimg.jpg'))}}" width="60%" alt="">
                        </a>
                    </td>
                    <td class="{{'name'.$product->id}}">{{$product->name}}</td>
                    <td class="{{'category'.$product->id}}">{{($product->category) ? ($product->category->name) : NULL}}</td>
                    <td class="{{'brand'.$product->id}}">{{($product->brand) ? ($product->brand->name) : NULL}}</td>
                    <td class="{{'unit'.$product->id}}">{{($product->unit) ? ($product->unit->name) : NULL}}</td>
                    <td class="{{'price'.$product->id}}">{{$product->price}}</td>
                    <td>
                        <!-- Detail -->
                        <a href="#" class="detailButton" data-id="{{$product->id}}">
                            <i class="fas fa-eye green ml-1"></i>
                        </a>
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$product->id}}">
                            <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$product->id}}">
                            <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="10"><h6 align="center">No product(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($products) > 0)
        {{$products->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
        @include('admin.product.product_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('product.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.product.product_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- tables -->
            <div class="card-body row row overflow-auto col-md-12" style="height:36rem;">
              <!-- main info -->
              <div class="col-md-12" style="text-align: center;">
                  <!-- product_image -->
                  <img class="image" src="{{asset('img/logo.png')}}" width="200">
                  <!-- name -->
                  <h3 class="name"></h3>
                  <!-- ratings -->
                  <div class="stars_wrapper">
                    <i class="fas fa-star" style="color:gold;"></i>
                    <i class="fas fa-star" style="color:gold;"></i>
                    <i class="fas fa-star" style="color:gold;"></i>
                    <i class="far fa-star" style="color:gold;"></i>
                    <i class="far fa-star" style="color:gold;"></i>
                  </div>
                  <span class="ratings_numeric">3/5</span>
              </div>
              <!-- section 1 -->
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                  <tbody id="table_row_wrapper">
                    <tr role="row" class="odd">
                      <td class="">Category</td>
                      <td class="category"></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="">Brand</td>
                      <td class="brand"></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="">Unit</td>
                      <td class="unit"></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="">Price</td>
                      <td class="price"></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="">Description</td>
                      <td class="description"></td>
                    </tr>
                  </tbody>
                </table>
                <hr style="color:gray;">
              </div>
              <!-- Gallery -->
              <h3 class="text-center col-md-12">Images</h3>
              <div class="gallery_wrapper col-md-12 row p-4">
              </div>
              <!-- product_comment section -->
              <div class="col-md-12 p-4 product_comment_section">
                <hr style="color:gray;">
                <h3 class="text-center">Comments</h3>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr role="row" class="odd">
                            <th>User</th>
                            <th>Content</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table_row_wrapper" class="product_comment_wrapper">
                        <tr role="row" class="odd">
                            <td class="product_comment_user">User</td>
                            <td class="product_comment_content">asdasdasdas</td>
                            <td class="product_comment_created_at">12.12.12</td>
                            <td class="product_comment_content"><button type="button" class="btn btn-primary btn-sm">Approve</button></td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- Add comment -->
              <div class="col-md-12">
                <label for="">Add comment</label>
                <div class="row form-group p-4">
                  <input type="text" class="form-control col-md-10 add_product_comment_content">
                  <button type="button" class="form-control btn btn-primary btn-sm col-md-2 btn_add_product_comment" data-user={{(auth()->user()) ? (auth()->user()->id) : NULL}}><i class="fas fa-chevron-right"></i></button>
                </div>
              </div>
              <!-- Rate this product -->
              <div class="col-md-12" style="text-align: center;">
                <hr style="color:gray;">
                <div class="container d-flex justify-content-center mt-100">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body text-center">
                          <h4 class="mt-1">Rate this product</h4>
                          <input class="rating_user_id" type="hidden" value="{{auth()->user()->id}}">
                          <fieldset class="rating p-3">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5">5 stars</label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1">1 star</label>
                          </fieldset>
                        </div>
                      </div>
                    </div>
                  </div>
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
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('product.destroy', 1)}}">
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

<!-- Create category view -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add new category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCateforyForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- name -->
                    <div class="form-group">
                        <label for="">Name</label>
                        <input id="categoryName" type="text" name="name" placeholder="Enter name"
                        class="form-control name" required max="50">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="storeCategoryButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create brand view -->
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add new brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- name -->
                    <div class="form-group col-md-12 col-sm-3">
                        <label>Name:</label>
                        <input type="text" name="name" placeholder="Name" class="form-control name" required>
                    </div>
                    <!-- link -->
                    <div class="form-group col-md-12 col-sm-3">
                        <label>Link:</label>
                        <input type="text" name="link" placeholder="Link" class="form-control link" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="storeBrandButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create unit view -->
<div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add new unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editUnitForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- name -->
                    <div class="form-group col-md-12">
                        <label for="">Name</label>
                        <input type="text" name="name" placeholder="Enter name" class="form-control name" required>
                    </div>
                    <!-- slug -->
                    <div class="form-group col-md-12">
                        <label for="">Slug</label>
                        <input type="text" name="slug" placeholder="Enter slug" class="form-control slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="storeUnitButton">Create</button>
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

    // global vars
    var product = "";

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

    // fetch product
    function fetch_product(id){
        // fetch product
        $.ajax({
            url: "<?php echo(route('product.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {id: id},
            dataType: 'JSON',
            success: function (data) {
                product = data.product;
            }
        });
    }

    // submit rating
    function submit_rating(user_id, product_id, stars){
      $.ajax({
          url: "<?php echo(route('rating.store')); ?>",
          type: 'POST',
          async: false,
          data: {
            "_token": "{{ csrf_token() }}",
            user_id: user_id,
            product_id: product_id,
            stars: stars,
          },
          dataType: 'JSON',
          success: function (data) {
            console.log(data);
          }
      });
    }
    
    // get_user_rating
    function get_user_rating(user_id, product_id){
      $.ajax({
          url: "<?php echo(route('get_user_rating')); ?>",
          type: 'GET',
          async: false,
          data: {
            user_id: user_id,
            product_id: product_id
          },
          dataType: 'JSON',
          success: function (data) {
            if(data != 0){
              var el =$('.rating').find('#star' + data);
              el.prop('checked', true);
            }
          }
      });
    }

    // approve_product_comment
    function approve_product_comment(id, element){
      $.ajax({
          url: `<?php echo(route('approve_product_comment')); ?>`,
          type: 'GET',
          data: {
            id: id
          },
          dataType: 'JSON',
          async: false,
          success: function (data) {
            element.remove();
            toastr["success"]("Comment Approved", "Success");
          }
      });
    }

    // delete_product_comment
    function delete_product_comment(id, element){
      var url = `<?php echo(route('product_comment.destroy', 0)); ?>`;
      url = url.replace('0', id);
      $.ajax({
          url: url,
          type: 'DELETE',
          data: {
            "_token": "{{ csrf_token() }}",
            id: id
          },
          dataType: 'JSON',
          async: false,
          success: function (data) {
            element.parent().parent().remove();
            toastr["success"]("Comment Deleted", "Success");
          }
      });
    }

    // add_product_comment
    function add_product_comment(product_id, user_id, product_comment_content){
      console.log()
      $.ajax({
          url: `<?php echo(route('product_comment.store')); ?>`,
          type: 'POST',
          data: {
            "_token": "{{ csrf_token() }}",
            product_id: product_id,
            user_id: user_id,
            content: product_comment_content,
          },
          dataType: 'JSON',
          async: false,
          success: function (data) {
            alert('Comment added.');
          }
      });
    }

    // delete_product_image
    function delete_product_image(product_image_id, image_container){
        var temp_route = "<?php echo(route('product_image.destroy', ':id'));?>";
        temp_route = temp_route.replace(':id', product_image_id);
        $.ajax({
            url: temp_route,
            type: 'DELETE',
            data: {
            "_token": "{{ csrf_token() }}",
            product_image_id: product_image_id
            },
            dataType: 'JSON',
            async: false,
            success: function (data) {
            image_container.remove();
            }
        });
    }
  
    // create
    $('#add_product').on('click', function(){
    });
    // edit
    $('.editButton').on('click', function(){
        var id = $(this).data('id');
        fetch_product(id);
        $('#hidden').val(id);

        // image
        // un hide preview div
        $('#editForm .preview_wrapper').prop('hidden', false);
        // update preview image
        if(product.image){
            var src = `<?php echo(asset('img/products') . '/temp'); ?>`;
            src = src.replace('temp', product.image);
        }
        else{
            var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#editForm .preview_image').prop('src', src);
        $('#editForm .name').val(product.name);
        $('#editForm .category_id option[value="'+ (product.category ? product.category_id : '') +'"]').prop('selected', true);
        $('#editForm .brand_id option[value="'+ (product.brand ? product.brand_id : '') +'"]').prop('selected', true);
        $('#editForm .unit_id option[value="'+ (product.unit ? product.unit_id : '') +'"]').prop('selected', true);
        $('#editForm .price').val(product.price);
        $('#editForm .description').val(product.description);
        
        $('#editProductModal').modal('show');
    });
    // detail
    $('.detailButton').on('click', function(){
        var id = $(this).data('id');
        fetch_product(id);

        // image
        if(product.image){
            var src = `<?php echo(asset('img/products/temp')); ?>`;
            src = src.replace('temp', product.image);
        }
        else{
            var src = `<?php echo(asset('img/noimg.jpg')); ?>`;
        }
        $('#viewProductModal .image').prop('src', src);
        // name
        $('#viewProductModal .name').html(product.name);
        // category
        $('#viewProductModal .category').html((product.category) ? (product.category.name) : '');
        // brand
        $('#viewProductModal .brand').html((product.brand) ? (product.brand.name) : '');
        // unit
        $('#viewProductModal .unit').html((product.unit) ? (product.unit.name) : '');
        // price
        $('#viewProductModal .price').html(product.price);
        // description
        $('#viewProductModal .description').html(product.description);

        // image gallery work
        $('.gallery_wrapper').html('');
        if(product.product_images.length > 0){
            for(var i = 0; i < product.product_images.length; i++){
                $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/products')}}/`+product.product_images[i].location+`" class="col-md-12"><img class="col-md-12 product_image" src="{{asset('img/products')}}/`+product.product_images[i].location+`"></a><button class="btn btn_del_product_image" value="`+product.product_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
            }
        }

        // product_comments
        if(product.product_comments.length > 0){
          $('.product_comment_wrapper').html('');
          for(var i = 0; i < product.product_comments.length; i++){
            var product_comment = product.product_comments[i];

            var user_div = `<td class="product_comment_user">`+(product_comment.user ? product_comment.user.name : '')+`</td>`;
            var content_div = `<td class="product_comment_content">`+product_comment.content+`</td>`;
            var date_div = `<td class="product_comment_created_at" width="140">`+new Date(product_comment.created_at).toDateString()+`</td>`;
            var approve_button = (product_comment.is_approved == 0) ? (`@can('isAdmin')<a href="#" class="btn_approve_product_comment p-1" style="color:green;" data-id="`+product_comment.id+`"><i class="fas fa-check-double"></i></a>@endcan`) : (``);
            var delete_button = `@can('isAdmin')<a href="#" class="btn_delete_product_comment p-1" style="color:red;" data-id="`+product_comment.id+`"><i class="fas fa-trash"></i></a>@endcan`;
            var approve_div = `<td class="">`+ approve_button + delete_button +`</td>`;

            var field_html = `<tr role="row" class="odd">`+user_div + content_div + date_div + approve_div+`</tr>`;
            $('.product_comment_wrapper').append(field_html);
          }
        }
        else{
          $('.product_comment_wrapper').html('');
          $('.product_comment_wrapper').append(`<tr><td colspan="4"><h6 align="center">No comments</h6></td></tr>`);
        }

        // ratings
        $('.stars_wrapper').html('');
        if(product.ratings.length > 0){
          // get star value
          var stars = 0;
          for(var i = 0; i < product.ratings.length; i++){
            stars += parseInt(product.ratings[i].stars);
          }
          stars /= product.ratings.length;
          
          // append stars
          for(var i = 0; i < 5; i++){
            if(i <= parseInt(stars) - 1){
              $('.stars_wrapper').append('<i class="fas fa-star" style="color:gold;"></i>');
            }
            else{
              $('.stars_wrapper').append('<i class="far fa-star" style="color:gold;"></i>');
            }
          }

          // set numeric rating
          $('.ratings_numeric').html(stars + '/5');
        }

        // get_user_rating
        var user_id = $('.rating_user_id').val();
        var product_id = product.id;
        get_user_rating(user_id, product_id);

        $('#viewProductModal').modal('show');
    });
    // delete
    $('.deleteButton').on('click', function(){
        var id = $(this).data('id');
        $('#deleteForm').attr('action', "{{route('product.destroy', 1)}}");
        $('#deleteForm .hidden').val(id);
        $('#deleteProductModalLabel').text('Delete Product: ' + $('.name' + id).html() + "?");
        $('#deleteProductModal').modal('show');
    });

    // on btn_approve_product_comment click
    $('#viewProductModal').on('click', '.btn_approve_product_comment', function(){
      var id = $(this).data('id');
      approve_product_comment(id, $(this));
    });
    // on btn_delete_product_comment click
    $('#viewProductModal').on('click', '.btn_delete_product_comment', function(){
      var id = $(this).data('id');
      delete_product_comment(id, $(this));
    });
    // on btn_add_product_comment click
    $('#viewProductModal').on('click', '.btn_add_product_comment', function(){
      var product_id = product.id;
      var user_id = $(this).data('user');
      var product_comment_content = $('.add_product_comment_content').val();
      
      if(product_comment_content.length > 0){
        add_product_comment(product_id, user_id, product_comment_content);
      }
    });

    // create category modal
    $('.add_category').on('click', function(){
        $('#addCategoryModal').modal('show');
    });
    // create category
    $('#storeCategoryButton').on('click', function(){
        var name = $('#addCategoryModal .name').val();
        $('#addCategoryModal').modal('hide');
        $.ajax({
            url: "<?php echo(route('category.store')); ?>",
            type: 'POST',
            data: {"_token": "{{ csrf_token() }}", name: name, dynamic: true},
            dataType: 'JSON',
            success: function (data) {
              $('.category_id').append("<option value='"+ data.id +"'>"+ data.name +"</option>");
              $('#addCategoryModal .name').val("");
            }
        });
    });
    // create brand modal
    $('.add_brand').on('click', function(){
        $('#addBrandModal').modal('show');
    });
    // create brand
    $('#storeBrandButton').on('click', function(){
        var name = $('#addBrandModal .name').val();
        var link = $('#addBrandModal .link').val();
        $('#addBrandModal').modal('hide');
        $.ajax({
            url: "<?php echo(route('brand.store')); ?>",
            type: 'POST',
            data: {"_token": "{{ csrf_token() }}", name: name, link: link, dynamic: true},
            dataType: 'JSON',
            success: function (data) {
              $('.brand_id').append("<option value='"+ data.id +"'>"+ data.name +"</option>");
              $('#addBrandModal .name').val("");
              $('#addBrandModal .link').val("");
            }
        });
    });
    // create unit modal
    $('.add_unit').on('click', function(){
        $('#addUnitModal').modal('show');
    });
    // create unit
    $('#storeUnitButton').on('click', function(){
        var name = $('#addUnitModal .name').val();
        var slug = $('#addUnitModal .slug').val();
        $('#addUnitModal').modal('hide');
        $.ajax({
            url: "<?php echo(route('unit.store')); ?>",
            type: 'POST',
            data: {"_token": "{{ csrf_token() }}", name: name, slug: slug, dynamic: true},
            dataType: 'JSON',
            success: function (data) {
              $('.unit_id').append("<option value='"+ data.id +"'>"+ data.name +"</option>");
              $('#addUnitModal .name').val("");
              $('#addUnitModal .slug').val("");
            }
        });
    });

    // on btn_del_product_image click
    $('#viewProductModal').on('click', '.btn_del_product_image', function(){
        var product_image_id = $(this).val();
        var image_container = $(this).parent();
        delete_product_image(product_image_id, image_container);
    });
    // on .input_is_published click
    $('.input_is_published').on('click', function(){
        var id = $(this).data('id');
        toggle_is_published(id);
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

    // on .rating click
    $('.rating').on('click', function(){
      var stars = 0;

      $(this).find('input').each(function(el){
        if($(this).prop('checked')){
          stars = $(this).val();
        }
      });
      
      var user_id = $('.rating_user_id').val();
      var product_id = product.id;

      submit_rating(user_id, product_id, stars);
    });
});
</script>
@endsection('content_body')