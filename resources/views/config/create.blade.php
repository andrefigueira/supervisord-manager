@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Program</div>

                    <div class="panel-body">
                        @include('config.form', [
                            'method' => 'POST',
                            'action' => url('config/save'),
                            'button' => 'Add Program',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
