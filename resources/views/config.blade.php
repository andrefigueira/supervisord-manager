@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Config

                    <a href="{{ url('config/create') }}" class="pull-right btn btn-success btn-xs">Add new program</a>
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>Program</td>
                            <td></td>
                        </tr>
                        @foreach($programs as $program)
                            <tr>
                                <td>{{ $program['filename'] }}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm pull-right">Remove</a>
                                    <a href="#" class="btn btn-success btn-sm pull-right">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
