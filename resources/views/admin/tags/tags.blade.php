@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">Tags</div>

                <div class="card-body">

                    <form action="{{ route('tags') }}" method="POST" class="row">
                        @csrf

                        <div class="form-group col-md-6">
                            <label for="unit_text">Tag Name</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Tag Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save New Tag</button>
                        </div>



                    </form>

                    <div class="row">

                        @foreach ($tags as $tag)
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">
                                <span class="button-span">


                                    <span>
                                        <a class="edit-unit" data-tagname="{{ $tag->tag }}" data-tagid="{{ $tag->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span>


                                    <span>
                                        <a class="delete-unit" data-tagname="{{ $tag->tag }}" data-tagid="{{ $tag->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </span>


                                </span>
                                <p>{{ $tag->tag }}</p>

                            </div>


                        </div>

                        @endforeach
                    </div>

                    {{ (!is_null($showLinks) && $showLinks) ? $tags->links() : '' }}

                    <form action="{{ route('search-tags') }}" method="GET">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="tag_search">Search</label>
                                <input type="text" class="form-control" id="tag_search" name="tag_search" placeholder="Search Tag" required>
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

@if (Session::has('message'))
<div class="toast" style="position: absolute; z-index:99999; top: 5%; right: 5%;">
    <div class="toast-header">
        <strong class="mr-auto">Tag</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">

        {{ Session::get('message') }}
    </div>
</div>

@endif





<div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tags') }}" method="POST">
                <div class="modal-body">
                    <p id="delete-message"></p>
                    @csrf
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="tag_id" value="" id="tag_id">
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
    <form action="{{ route('tags') }}" method="POST">


        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf

                    <div class="form-group col-md-6">
                        <label for="edit_unit_text">Tag Name</label>
                        <input type="text" class="form-control" id="edit_tag_name" name="tag_name" placeholder="Tag Name" required>
                    </div>


                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="tag_id" id="edit_tag_id">


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>

    </form>

</div>



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
        var $tagID = $('#tag_id');
        //store delete message from modal in variable
        var $deleteMessage = $('#delete-message');

        $deleteUnit.on('click', function(element) {
            // stop page from getting up after click & show modal
            element.preventDefault();
            // extracting the id,name,code from data attributes from the button
            var tag_id = $(this).data('tagid');
            //console.log(unitID);
            $tagID.val(tag_id);
            $deleteMessage.text('Are you sure you want to delete tag ?');
            $deleteWindow.modal('show');
        });



        //EDIT WINDOW
        // store button in variable
        var $editTag = $('.edit-unit');
        // store modal in variable
        var $editWindow = $('.edit-window');

        var $edit_tag_name = $('#edit_tag_name');
        var $edit_tag_id = $('#edit_tag_id');

        $editTag.on('click', function(element) {
            element.preventDefault();
            var tagName = $(this).data('tagname');
            var tag_id = $(this).data('tagid');


            $edit_tag_id.val(tag_id);
            $edit_tag_name.val(tagName);




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
