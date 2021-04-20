@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fab fa-post-hunt"></i> Posts</h1>
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
            <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addPostModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_posts')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Author</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($posts) > 0)
                @foreach($posts as $post)
                  <tr role="row" class="odd">
                    <td class="{{'image'.$post->id}}"><img src="{{($post->image) ? (asset('img/posts') . '/' . $post->image) : (asset('img/noimg.jpg'))}}" width="15%" alt=""></td>
                    <td class="{{'title'.$post->id}}">{{$post->title ? $post->title : NULL}}</td>
                    <td class="{{'user_id'.$post->id}}">{{$post->user ? $post->user->name : NULL}}</td>
                    <td>
                        <!-- Detail -->
                        <a href="#" class="detailButton" data-id="{{$post->id}}" data-src="{{asset('img/posts') . '/' . $post->image}}">
                            <i class="fas fa-eye green ml-1"></i>
                        </a>
                        <!-- Edit -->
                        <a href="#" class="editButton" data-id="{{$post->id}}">
                            <i class="fas fa-edit blue ml-1"></i>
                        </a>
                        <!-- Delete -->
                        <a href="#" class="deleteButton" data-id="{{$post->id}}">
                            <i class="fas fa-trash red ml-1"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="4"><h6 align="center">No post(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($posts) > 0)
        {{$posts->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
        @include('admin.post.post_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('post.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.post.post_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Detail</h5>

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
                            <td class="">Content</td>
                            <td class="content"></td>
                        </tr>
                    </tbody>
                </table>
                <hr style="color:gray;">
              </div>

              <!-- comment section -->
              <div class="comment_wrapper col-md-12 p-4">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <thead>
                            <th>User</th>
                            <th>Content</th>
                            <th>Time</th>
                            <th>Action</th>
                        </thead>
                        <tr role="row" class="odd">
                            <td class="comment_user">User</td>
                            <td class="comment_content">asdasdasdas</td>
                            <td class="comment_created_at">12.12.12</td>
                            <td class="comment_content"><button type="button" class="btn btn-primary">Approve</button></td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>


            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePostModalLabel">Delete Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('post.destroy', 1)}}">
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
  var post = "";
  // persistent active sidebar
  var element = $('li a[href*="'+ window.location.pathname +'"]');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch post
  function fetch_post(id){
      // fetch post
      $.ajax({
          url: "<?php echo(route('post.show', 1)); ?>",
          type: 'GET',
          async: false,
          data: {id: id},
          dataType: 'JSON',
          success: function (data) {
              post = data.post;
          }
      });
  }
  
  // toggle_is_published
  function toggle_is_published(id){
    $.ajax({
        url: '#',
        type: 'GET',
        data: {
          id: id
        },
        dataType: 'JSON',
        async: false,
        success: function (data) {
          
        }
    });
  }

  // create
  $('#add_post').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_post(id);
    $('#editForm #hidden').val(id);
    $('#editForm .title').val((post.title) ? (post.title) : '');
    $('#editForm .content').val((post.content) ? (post.content) : '');
    $('#editPostModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');
    fetch_post(id);

    // image gallery work
    $('.gallery_wrapper').html('');
    // if(post.post_images.length > 0){
    //   for(var i = 0; i < post.post_images.length; i++){
    //     $('.gallery_wrapper').append(`<div class="col-md-4 mb-3"><a target="_blank" href="{{asset('img/post_images')}}/`+post.post_images[i].location+`" class="col-md-12"><img class="col-md-12 shop_keeper_picture" src="{{asset('img/post_images')}}/`+post.post_images[i].location+`"></a><button class="btn btn_del_post_image" value="`+post.post_images[i].id+`" type="button"><i class="fas fa-trash red ml-1"></i></button></div>`);
    //   }
    // }
    $('#viewPostModal .title').html('Title: ' + post.title);
    $('#viewPostModal .user').html((post.user) ? ('By: ' + post.user.name) : '');
    $('#viewPostModal .content').html(post.content);

    // image
    var src = ((post.image) ? ($(this).data('src')) : ('<?php echo(asset("img/noimg.jpg")); ?>'));
    $('#viewPostModal .image').attr('src', src);

    $('#viewPostModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('post.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deletePostModalLabel').text('Delete Post: ' + $('.name' + id).html() + "?");
    $('#deletePostModal').modal('show');
  });

  // on .input_is_published click
  $('.input_is_published').on('click', function(){
    var id = $(this).data('id');
    toggle_is_published(id);
  });

});
</script>
@endsection('content_body')