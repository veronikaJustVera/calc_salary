@extends('layout')
@section('content')
    <h1>Add new Film</h1>
    <form method="post" action="/{{$instance}}/save">
        @csrf
        <div class="row form-group mt-4">
            @foreach ($columns as $key => $column)
                <div class="col-sm mb-2">
                    <label for="{{$key}}">{{$column}}</label>
                    <input autocomplete="off" type="text" @if(strpos($key, 'date') !== false) class="datepicker" @endif name="{{$key}}">
                </div>
            @endforeach
            <div class="col-sm mb-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger mt-2" onclick="this.remove();">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script>
        $(function() {
            $('.datepicker').datepicker();
        });
    </script>
@endsection
