@extends('layout')
@section('content')
    <h1 class="text-center">History</h1>
    @if (!empty($history))
        <table class="table mt-3" id="history-table">
            <thead class="table-header table-primary sticky-top">
                <th class="header__item">
                    <a id="order" class="filter__link filter__link--number" href="#">#</a>
                    <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg>
                </th>
                <th class="header__item">
                    <a id="employee" class="filter__link" href="#">Employee</a>
                    <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg>
                </th>
                <th class="header__item">
                    <a id="role" class="filter__link" href="#">Role</a>
                    <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg>
                </th>
                <th class="header__item">
                    <a id="month" class="filter__link filter__link--date" href="#">Month</a>
                    <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg>
                </th>
                <th class="header__item">
                    <a id="salary" class="filter__link filter__link--number" href="#">Salary</a>
                    <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg>
                </th>
            </thead>
            <tbody class="table-content">
                @foreach ($history as $key => $item)
                    <tr class="table-row">
                        <th class="table-data">{{$key + 1}}</th>
                        <th class="table-data">{{$item['employee']}}</th>
                        <th class="table-data">{{$item['role']}}</th>
                        <th class="table-data">{{$item['date']}}</th>
                        <th class="table-data">{{$item['salary']}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
      Sorry, no data here :(
    @endif
    <script src="{{mix('js/history.js')}}"></script>
@endsection
