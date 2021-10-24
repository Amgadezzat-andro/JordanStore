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
                                <input type="text" class="form-control" id="unit_name" name="unit_name"
                                    placeholder="Unit Name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="unit_code">Unit Code</label>
                                <input type="text" class="form-control" id="unit_code" name="unit_code"
                                    placeholder="Unit Code" required>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Save New Unit</button>
                            </div>



                        </form>


                        <div class="row">

                            @foreach ($units as $unit)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <p>{{ $unit->unit_name }},{{ $unit->unit_code }}</p>

                                    </div>


                                </div>

                            @endforeach
                        </div>

                        {{ $units->links() }}

                    </div>


                </div>
            </div>
        </div>
    </div>
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


@if (Session::has('message'))

    @section('scripts')
        <script>
            jQuery(document).ready(function($) {
                var $toast = $('.toast').toast({
                    autohide: false
                });
                $toast.toast('show');
            });
        </script>

    @endsection
@endif
