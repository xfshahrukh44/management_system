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
    <h1 class="m-0 text-dark"><i class="nav-icon fab fa-unit-hunt"></i> Units</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addUnitModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_units')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Slug</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($units) > 0)
                @foreach($units as $unit)
                  <tr role="row" class="odd">
                    <td class="{{'name'.$unit->id}}">{{$unit->name ? $unit->name : NULL}}</td>
                    <td class="{{'slug'.$unit->id}}">{{$unit->slug ? $unit->slug : NULL}}</td>
                    <td>
                        <!-- Detail -->
                        <!-- <a href="#" class="detailButton" data-id="{{$unit->id}}">
                            <i class="fas fa-eye green ml-1"></i>
                        </a> -->
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$unit->id}}">
                            <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$unit->id}}">
                            <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="5"><h6 align="center">No unit(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($units) > 0)
        {{$units->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUnitModalLabel">Add New Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('unit.store')}}" enctype="multipart/form-data">
        @include('admin.unit.unit_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('unit.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.unit.unit_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unit Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- tables -->
            <div class="card-body row row overflow-auto col-md-12" style="height:36rem;">
              <!-- main info -->
              <div class="col-md-12" style="text-align: center;">
                <!-- image -->
                <img class="image" src="{{asset('img/logo.png')}}" width="200">
                <!-- title -->
                <h3 class="title"></h3>
                <!-- user -->
                <h6 class="user"></h6>
                <hr style="color:gray;">
              </div>
              <!-- section 1 -->
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="content"></td>
                        </tr>
                    </tbody>
                </table>
                <hr style="color:gray;">
              </div>
              <!-- comment section -->
              <div class="col-md-12 p-4 comment_section">
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
                    <tbody id="table_row_wrapper" class="comment_wrapper">
                        <tr role="row" class="odd">
                            <td class="comment_user">User</td>
                            <td class="comment_content">asdasdasdas</td>
                            <td class="comment_created_at">12.12.12</td>
                            <td class="comment_content"><button type="button" class="btn btn-primary btn-sm">Approve</button></td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <div class="col-md-12">
                <label for="">Add comment</label>
                <div class="row form-group p-4">
                  <input type="text" class="form-control col-md-10 add_comment_content">
                  <button type="button" class="form-control btn btn-primary btn-sm col-md-2 btn_add_comment" data-user={{(auth()->user()) ? (auth()->user()->id) : NULL}}><i class="fas fa-chevron-right"></i></button>
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
<div class="modal fade" id="deleteUnitModal" tabindex="-1" role="dialog" aria-labelledby="deleteUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUnitModalLabel">Delete Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('unit.destroy', 1)}}">
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

  // global vars
  var unit = "";
  
  // persistent active sidebar
  var element = $('li a[href*="'+ window.location.pathname +'"]');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch unit
  function fetch_unit(id){
      // fetch unit
      $.ajax({
          url: "<?php echo(route('unit.show', 1)); ?>",
          type: 'GET',
          async: false,
          data: {id: id},
          dataType: 'JSON',
          success: function (data) {
              unit = data.unit;
          }
      });
  }

  // create
  $('#add_unit').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_unit(id);
    $('#editForm #hidden').val(id);
    $('#editForm .name').val((unit.name) ? (unit.name) : '');
    $('#editForm .slug').val((unit.slug) ? (unit.slug) : '');
    $('#editUnitModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');
    fetch_unit(id);

    $('#viewUnitModal .title').html('Title: ' + unit.title);
    $('#viewUnitModal .user').html((unit.user) ? ('By: ' + unit.user.name) : '');
    $('#viewUnitModal .content').html(unit.content);

    // image
    var src = ((unit.image) ? ($(this).data('src')) : ('<?php echo(asset("img/noimg.jpg")); ?>'));
    $('#viewUnitModal .image').attr('src', src);

    // comments
    if(unit.comments.length > 0){
      $('.comment_wrapper').html('');
      for(var i = 0; i < unit.comments.length; i++){
        var comment = unit.comments[i];

        var user_div = `<td class="comment_user">`+(comment.user ? comment.user.name : '')+`</td>`;
        var content_div = `<td class="comment_content">`+comment.content+`</td>`;
        var date_div = `<td class="comment_created_at" width="140">`+new Date(comment.created_at).toDateString()+`</td>`;
        var approve_button = (comment.is_approved == 0) ? (`@can('isAdmin')<a href="#" class="btn_approve_comment p-1" style="color:green;" data-id="`+comment.id+`"><i class="fas fa-check-double"></i></a>@endcan`) : (``);
        var delete_button = `@can('isAdmin')<a href="#" class="btn_delete_comment p-1" style="color:red;" data-id="`+comment.id+`"><i class="fas fa-trash"></i></a>@endcan`;
        var approve_div = `<td class="">`+ approve_button + delete_button +`</td>`;

        var field_html = `<tr role="row" class="odd">`+user_div + content_div + date_div + approve_div+`</tr>`;
        $('.comment_wrapper').append(field_html);
      }
    }
    else{
      $('.comment_wrapper').html('');
      $('.comment_wrapper').append(`<tr><td colspan="4"><h6 align="center">No comments</h6></td></tr>`);
    }

    $('#viewUnitModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('unit.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deleteUnitModalLabel').text('Delete Unit: ' + $('.name' + id).html() + "?");
    $('#deleteUnitModal').modal('show');
  });
});
</script>
@endsection('content_body')