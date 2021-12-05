@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">Cities</div>

                <div class="card-body">


                    <form action="{{ route('cities') }}" method="POST" class="row">
                        @csrf

                        <div class="form-group col-md-5">
                            <label for="unit_text">City Name</label>
                            <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save New City</button>
                        </div>


                        <p>Choose a State </p>
                        <select Name="Name_of_list_box" Size="Number_of_options">
                            @foreach ($states as $state)
                            <option value="">
                                {{$state->name}}
                            </option>
                            @endforeach
                          </select>


                    </form>


                    <div class="row">

                        @foreach ($cities as $city)
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">



                                <span class="button-span">


                                    <span>
                                        <a class="edit-unit" data-cityname="{{ $city->name }}" data-cityid="{{ $city->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span>

                                    <span>
                                        <a class="delete-unit" data-categoryname="{{ $city->name }}" data-categoryid="{{ $city->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </span>

                                </span>

                                <h5>{{ $city->name }}</h5>
                                <p>State: {{ $city->states->name}}</p>
                                <p>Country: {{ $city->country->name }}</p>




                            </div>




                        </div>

                        @endforeach
                    </div>

                    {{ (!is_null($showLinks) && $showLinks) ? $cities->links() : '' }}

                    <form action="{{ route('search-cities') }}" method="GET">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="tag_search">Search</label>
                                <input type="text" class="form-control" id="city_search" name="city_search" placeholder="Search City" required>
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
                <h5 class="modal-title">Delete City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cities') }}" method="POST">
                <div class="modal-body">
                    <p id="delete-message"></p>
                    @csrf
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="city_id" value="" id="city_id">
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
    <form action="{{ route('cities') }}" method="POST">


        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit City</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf

                    <div class="form-group col-md-6">
                        <label for="edit_unit_text">City Name</label>
                        <input type="text" class="form-control" id="edit_city_name" name="city_name" placeholder="City Name" required>
                    </div>


                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="city_id" id="edit_city_id">


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
        <strong class="mr-auto">City</strong>
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
        var $cityID = $('#city_id');
        //store delete message from modal in variable
        var $deleteMessage = $('#delete-message');

        $deleteUnit.on('click', function(element) {
            // stop page from getting up after click & show modal
            element.preventDefault();
            // extracting the id,name,code from data attributes from the button
            var cat_id = $(this).data('cityid');
            //console.log(unitID);
            $cityID.val(cat_id);
            $deleteMessage.text('Are you sure you want to delete city ?');
            $deleteWindow.modal('show');
        });



        //EDIT WINDOW
        // store button in variable
        var $editCat = $('.edit-unit');
        // store modal in variable
        var $editWindow = $('.edit-window');

        var $edit_category_name = $('#edit_city_name');
        var $edit_category_id = $('#edit_city_id');

        $editCat.on('click', function(element) {
            element.preventDefault();
            var catName = $(this).data('cityname');
            var cat_id = $(this).data('cityid');


            $edit_category_id.val(cat_id);
            $edit_category_name.val(catName);




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
