@extends('layouts.app')

@section('content')

<div class="container">




    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">Units</div>

                <div class="card-body">


                    <form action="{{ route('units') }}" method="POST" class="row">
                        @csrf

                        <div class="form-group col-md-6">
                            <label for="unit_text">Unit Name</label>
                            <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="Unit Name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="unit_code">Unit Code</label>
                            <input type="text" class="form-control" id="unit_code" name="unit_code" placeholder="Unit Code" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save New Unit</button>
                        </div>



                    </form>


                    <div class="row">

                        @foreach ($units as $unit)
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">

                                <span class="button-span">


                                    <span>
                                        <a class="edit-unit" data-unitcode="{{ $unit->unit_code }}" data-unitname="{{ $unit->unit_name }}" data-unitid="{{ $unit->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span>


                                    <span>
                                        <a class="delete-unit" data-unitcode="{{ $unit->unit_code }}" data-unitname="{{ $unit->unit_name }}" data-unitid="{{ $unit->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </span>


                                </span>

                                <p>{{ $unit->unit_name }},{{ $unit->unit_code }}</p>

                            </div>


                        </div>

                        @endforeach
                    </div>

                    <!-- {{ ($units instanceof LengthAwarePaginator ) ? $units->links() : ''}}  -->
                    {{ (!is_null($showLinks) && $showLinks) ? $units->links() : '' }}

                    <form action="{{ route('search-units') }}" method="GET">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="unit_search">Search</label>
                                <input type="text" class="form-control" id="unit_search" name="unit_search" placeholder="Search Unit" required>
                            </div>

                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary" id="search_button">Search</button>
                            </div>

                        </div>
                    </form>


                </div>


            </div>
        </div>
    </div>
</div>
</div>





<div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('units') }}" method="POST">
                <div class="modal-body">
                    <p id="delete-message"></p>
                    @csrf
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="unit_id" value="" id="unit_id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>
</div>




<div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
    <form action="{{ route('units') }}" method="POST">


        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf

                    <div class="form-group col-md-6">
                        <label for="edit_unit_text">Unit Name</label>
                        <input type="text" class="form-control" id="edit_unit_name" name="unit_name" placeholder="Unit Name" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="edit_unit_code">Unit Code</label>
                        <input type="text" class="form-control" id="edit_unit_code" name="unit_code" placeholder="Unit Code" required>
                    </div>

                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="unit_id" id="edit_unit_id">


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>

    </form>

</div>











@if (Session::has('message'))
<div class="toast" style="position: absolute; z-index:99999; top: 5%; right: 5%;">
    <div class="toast-header">
        <strong class="mr-auto">Unit</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">

        {{ Session::get('message') }}
    </div>
</div>

@endif



@endsection



@section('scripts')

<script>
    jQuery(document).ready(function($) {
        // DELETING UNIT Window

        // store button in variable
        var $deleteUnit = $('.delete-unit');
        // store modal in variable
        var $deleteWindow = $('#delete-window');
        // store the method of requsting delete (input)
        var $unitId = $('#unit_id');
        //store delete message from modal in variable
        var $deleteMessage = $('#delete-message');

        $deleteUnit.on('click', function(element) {
            // stop page from getting up after click & show modal
            element.preventDefault();
            // extracting the id,name,code from data attributes from the button
            var unit_id = $(this).data('unitid');
            var unitName = $(this).data('unitname');
            var unitCode = $(this).data('unitcode');
            //console.log(unitID);
            $unitId.val(unit_id);
            $deleteMessage.text('Are you sure you want to delete ' + unitName + ' with code ' +
                unitCode + " ?");
            $deleteWindow.modal('show');
        });



        // EDIT WINDOW
        // store button in variable
        var $editUnit = $('.edit-unit');
        // store modal in variable
        var $editWindow = $('.edit-window');

        var $edit_unit_name = $('#edit_unit_name');
        var $edit_unit_code = $('#edit_unit_code');
        var $edit_unit_id = $('#edit_unit_id');

        $editUnit.on('click', function(element) {
            element.preventDefault();
            var unitName = $(this).data('unitname');
            var unitCode = $(this).data('unitcode');
            var unit_id = $(this).data('unitid');

            $edit_unit_code.val(unitCode);
            $edit_unit_id.val(unit_id);
            $edit_unit_name.val(unitName);




            $editWindow.modal('show');
        });



    });
</script>



@if (Session::has('message'))


<script>
    jQuery(document).ready(function($) {
        var $toast = $('.toast').toast({
            autohide: false
        });
        $toast.toast('show');
    });
</script>


@endif
@endsection
