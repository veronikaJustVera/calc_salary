@extends('layout')
@section('content')
    <h1>History</h1>
    @if (!empty($history))
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Employee</th>
            <th scope="col">Role</th>
            <th scope="col">Month</th>
            <th scope="col">Salary</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($history as $key => $item)
                <tr>
                    <th scope="col">{{$key}}</th>
                    <th scope="col">{{$item['employee']}}</th>
                    <th scope="col">{{$item['role']}}</th>
                    <th scope="col">{{$item['date']}}</th>
                    <th scope="col">{{$item['salary']}}</th>
                </tr>
            @endforeach
        </tbody>
      </table>
    @else
      Sorry, no data here :(
    @endif
@endsection
