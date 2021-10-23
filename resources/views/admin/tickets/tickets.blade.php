@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Tickets</div>

                    <div class="card-body">
                        <div class="row">

                            @foreach ($tickets as $ticket)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">


                                        <h5>{{ $ticket->customer->formattedName() }}</h5>
                                        <p>Status: {{ $ticket->status }}</p>
                                        <p>Title: {{ $ticket->title }}</p>


                                    </div>


                                </div>

                            @endforeach
                        </div>

                        {{ $tickets->links() }}

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
