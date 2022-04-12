@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Categories</div>

                    <div class="card-body">

                        {{-- when you are going to upload files to the form --}}
                        <form action="{{ route('categories') }}" method="POST" class="row"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group col-md-6">
                                <label for="unit_text">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                    placeholder="Category Name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="unit_text">Category Image</label>
                                <input type="file" class="form-control-file" id="category_image" name="category_image"
                                    required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="unit_text">Image Direction</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="image_direction"
                                        id="flexRadioDefault1" value="left" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Left
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="image_direction"
                                        id="flexRadioDefault2" value="right">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                            Right
                                        </label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Save New Category</button>
                            </div>



                        </form>


                        <div class="row">

                            @foreach ($categories as $category)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <span class="button-span">


                                            <span>
                                                <a class="edit-unit" data-categoryname="{{ $category->name }}"
                                                    data-categoryid="{{ $category->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </span>


                                            <span>
                                                <a class="delete-unit" data-categoryname="{{ $category->name }}"
                                                    data-categoryid="{{ $category->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </span>


                                        </span>

                                        <p>{{ $category->name }} </p>



                                    </div>


                                </div>
                            @endforeach
                        </div>

                        {{ !is_null($showLinks) && $showLinks ? $categories->links() : '' }}

                        <form action="{{ route('search-categories') }}" method="GET">
                            @csrf
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="tag_search">Search</label>
                                    <input type="text" class="form-control" id="category_search" name="category_search"
                                        placeholder="Search Category" required>
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
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('categories') }}" method="POST">
                    <div class="modal-body">
                        <p id="delete-message"></p>
                        @csrf
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="category_id" value="" id="category_id">
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
        <form action="{{ route('categories') }}" method="POST">


            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @csrf

                        <div class="form-group col-md-6">
                            <label for="edit_unit_text">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="category_name"
                                placeholder="Category Name" required>
                        </div>


                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="category_id" id="edit_category_id">


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
                <strong class="mr-auto">Category</strong>
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
            var $categoryID = $('#category_id');
            //store delete message from modal in variable
            var $deleteMessage = $('#delete-message');

            $deleteUnit.on('click', function(element) {
                // stop page from getting up after click & show modal
                element.preventDefault();
                // extracting the id,name,code from data attributes from the button
                var cat_id = $(this).data('categoryid');
                //console.log(unitID);
                $categoryID.val(cat_id);
                $deleteMessage.text('Are you sure you want to delete category ?');
                $deleteWindow.modal('show');
            });



            //EDIT WINDOW
            // store button in variable
            var $editCat = $('.edit-unit');
            // store modal in variable
            var $editWindow = $('.edit-window');

            var $edit_category_name = $('#edit_category_name');
            var $edit_category_id = $('#edit_category_id');

            $editCat.on('click', function(element) {
                element.preventDefault();
                var catName = $(this).data('categoryname');
                var cat_id = $(this).data('categoryid');


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
