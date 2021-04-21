@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Feed</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content_body')
    <!-- Post Content Column -->
    <div class="col-lg-12">

    <!-- Title -->
    <h1 class="mt-4">Post Title</h1>

    <!-- Author -->
    <p class="lead">
        by
        <a href="#">Start Bootstrap</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p>Posted on January 1, 2019 at 12:00 PM</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

    <hr>

    <!-- Post Content -->
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>

    <hr>

    <!-- Comments Form -->
    <div class="card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
        <form>
            <div class="form-group">
            <textarea class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </div>

    <!-- Single Comment -->
    <div class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
        <h5 class="mt-0">Commenter Name</h5>
        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
        </div>
    </div>

    </div>
@endsection