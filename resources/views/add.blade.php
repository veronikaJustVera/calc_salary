@extends('layout')
@section('content')
    <h1 class="text-center">Add new {{$instance}}</h1>
    <form method="post" action="/{{$instance}}/save">
        @csrf
        <div class="row mt-3 mb-3 p-2 rounded border border-primary bg-white">
            @foreach ($columns as $key => $column)
                <div class="col-sm mb-2">
                    <label for="{{$key}}">{{$column}}</label>
                    <input class="rounded border pl-2 pr-2" style="border-color: #bdc6e7;" autocomplete="off" type="text" @if(strpos($key, 'date') !== false) class="datepicker" @endif name="{{$key}}">
                </div>
            @endforeach
            <div class="col-sm mb-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger mt-2" onclick="this.remove();">
            <ul class="m-0">
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
