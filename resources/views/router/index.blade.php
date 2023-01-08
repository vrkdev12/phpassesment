@extends('layouts.app')

@section('css')
<style>
.hidden {
    display:none;
}
.container, .renderview {
    margin-top:50px;
}
.rederrorClass {
    background-color: #e8a1a7; 
    border-color: #e8a1a7;
}
.grayerrorClass {
    background-color: #ada9a9; 
    border-color: #ada9a9;
}
</style>
@endsection

@section('section')  
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <form action="{{ url('router') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($errors->any())
                    <div class="row">
                        <div class="col-md-12 col-md-offset-1">
                          <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h4><i class="icon fa fa-ban"></i> Error!</h4>
                              @foreach($errors->all() as $error)
                              {{ $error }} <br>
                              @endforeach      
                          </div>
                        </div>
                    </div>
                    @endif
      
                    @if (Session::has('success'))
                        <div class="row">
                          <div class="col-md-12 col-md-offset-1">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5>{!! Session::get('success') !!}</h5>   
                            </div>
                          </div>
                        </div>
                    @endif
      
                    <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="router_file" class="custom-file-input" id="router_file">
                          <label class="custom-file-label" for="router_file">Select Excel File to Upload</label>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-info" type="submit" id="inputGroupFileAddon04">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="render_view renderview">
                    @include('router.table')
                </div>
            </div>
        </div>
    </div>
</div>
       
</div>
</div>
</div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    //Delete
    $(".delete").click(function() {
        var route = $(this);
        swal("Are you sure you want to delete this router?", {
            buttons: ["Cancel", true],
        }).then((value) => {
            if(value) {
                route.parents('tr').remove();
            }
        });
    });
});

</script>
@endsection
