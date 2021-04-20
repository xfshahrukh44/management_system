@csrf
<div class="modal-body row">
    <!-- user_id -->
    <input type="hidden" name="user_id" value="{{auth()->user() ? auth()->user()->id : NULL}}">

    <!-- title -->
    <div class="form-group col-md-12">
        <label for="">Title</label>
        <input type="text" name="title" placeholder="Enter title" class="form-control title" required>
    </div>

    <!-- content -->
    <div class="form-group col-md-12">
        <label for="">Content</label>
        <textarea type="text" name="content" placeholder="Enter Content" class="form-control content"></textarea>
    </div>

    <!-- image -->
    <div class="form-group col-md-12">
        <label for="">Post Picture</label>
        <input type="file" name="image" placeholder="Upload Post Picture"
        class="form-control">
    </div>

</div>