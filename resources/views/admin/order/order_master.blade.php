<div class="modal-body row">
    <!-- user_id -->
    <div class="form-group col-md-6">
        <label for="">User</label>
        <select name="user_id" class="form-control form-control-sm user_id" style="width: 100%; height: 35px;">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- name -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name" class="form-control name" required>
    </div>
    <!-- link -->
    <div class="form-group col-md-6 col-sm-3">
        <label>Link:</label>
        <input type="text" name="link" placeholder="Link" class="form-control link" required>
    </div>
    <!-- image -->
    <div class="form-group col-md-12">
        <label>Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100%">
        </div>
    </div>
</div>