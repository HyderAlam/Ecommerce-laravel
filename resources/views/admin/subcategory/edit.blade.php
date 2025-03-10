@extends('admin.layouts.app')

@section('content')


<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('subcategory.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" name="subCategory" id="subCategory">
        <div class="card">  
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="categoryid" id="categoryid" class="form-control">
                                @if ($category->isNotEmpty())
                                    @foreach ($category as $category)
                                        <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <p></p>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" value="{{ $subcategory->name }}" name="name" id="name" class="form-control" placeholder="Name">	
                            <p></p>
                        </div>
                    </div>
                  
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" value="{{ $subcategory->slug }}" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                            <p></p>  
                        </div>
                    </div>
                  	
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="Status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ ($subcategory->status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0"  {{ ($subcategory->status == 0) ? 'selected' : '' }}>Deative</option>
                            </select>
                            <p></p>
                        </div>
                       
                    </div>	
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="showHome">Show On Home</label>
                            <select name="showHome" id="showHome" class="form-control">
                                <option value="yes" {{ ($subcategory->showHome == 'yes') ? 'selected' : '' }} >Yes</option>
                                <option value="no"  {{ ($subcategory->showHome == 'no') ? 'selected' : '' }}>No</option>
                            </select>
                            <p></p>
                        </div>
                    </div>									
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('subcategory.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs')
    <script>
          $('#name').change(function(){
            var element = $(this);
            var title = element.val();                
            $.ajax({
                url: '{{ route("getSlug") }}',
                type: 'get',
                data: { title: title },
                dataType: 'json',
                success: function(response){
                    if (response.status) {
                        $('#slug').val(response.slug);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('AJAX error:', textStatus, errorThrown);
                }
            });
        });


        $('#subCategory').submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        
        $.ajax({
            url: '{{ route("subcategory.update", $subcategory->id) }}',
            type: 'PUT',
            data: element.serialize(),
            dataType: 'json',
            success: function(response){
                if (response.status) {
                    window.location.href = "{{ route('subcategory.index') }}";
                } else {
                    var errors = response.errors;
                    // Handle validation errors
                    if (errors.name) {
                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name[0]);
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors.slug) {
                        $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.slug[0]);
                    } else {
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors.status) {
                        $('#status').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.status[0]);
                    } else {
                        $('#status').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                }
            },
            error: function(jqXHR, exception){
           //     console.log('Something went wrong');
            },
            complete: function() {
                // Re-enable the submit button after the request is complete
                $("button[type=submit]").prop('disabled', false);
            }
        });
    });
</script>
    </script>
@endsection
