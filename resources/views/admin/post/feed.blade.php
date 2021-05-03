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
<div class="container">
    <table class="table table-sm table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>User</th>
                <th>Tweet</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tweets as $tweet)
                <tr>
                    <td>{{'@' . $tweet['user']['screen_name']}}</td>
                    <td><p>{{$tweet['text']}}</p></td>
                    <td>{{$tweet['created_at']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
