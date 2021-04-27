@csrf
<div class="modal-body row">
    <!-- image -->
    <div class="form-group col-md-6">
        <label for="">Image:</label>
        <input type="file" name="image" placeholder="Image" class="form-control form-control-sm image">
        <div class="col-md-3 preview_wrapper" hidden>
            <img src="<?php echo(asset('img/noimg.jpg')); ?>" class="preview_image" alt="" width="100">
        </div>
    </div>
    <!-- name -->
    <div class="form-group col-md-6">
        <label for="">Name:</label>
        <input type="text" name="name" placeholder="Name" class="form-control form-control-sm name" required>
    </div>
    <!-- category_id -->
    <div class="form-group col-md-3">
        <label for="">Category</label>
        <select name="category_id" class="form-control form-control-sm category_id" style="width: 100%; height: 35px;">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- brand_id -->
    <div class="form-group col-md-3">
        <label for="">Brand</label>
        <select name="brand_id" class="form-control form-control-sm brand_id" style="width: 100%; height: 35px;">
            <option value="">Select Brand</option>
            @foreach($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- unit_id -->
    <div class="form-group col-md-3">
        <label for="">Unit</label>
        <select name="unit_id" class="form-control form-control-sm unit_id" style="width: 100%; height: 35px;">
            <option value="">Select Unit</option>
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- price -->
    <div class="form-group col-md-3">
        <label for="">Price</label>
        <input type="number" min=0 name="price" placeholder="Enter Price" class="form-control form-control-sm price" required value=0 step=".1">
    </div>
    <!-- description -->
    <div class="form-group col-md-12">
        <label for="">Description:</label>
        <textarea type="text" name="description" placeholder="Description" class="form-control form-control-sm description"></textarea>
    </div>
    <!-- product_images -->
    <div class="form-group col-md-12">
        <label>Additional Images:</label> <br>
        <input type="file" name="product_images[]" class="form-control" multiple>
    </div>
</div>