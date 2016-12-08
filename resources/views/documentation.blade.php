@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Supervisord XMLRPC Documentation</div>

                <div class="panel-body">
                    <p>Lists all available XMLRPC methods available from Supervisord</p>

                    @foreach($documentation as $method => $documentationBlock)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $method }}</h3>
                            </div>
                            <div class="panel-body">
                                {!! $documentationBlock !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
