@extends('layout')
@section('content')
    @if (!empty($customMessage))
        <div class="alert alert-success" onclick="this.remove();">
            <ul>
                <li>{{ $customMessage }}</li>
            </ul>
        </div>
    @endif
    <h1 class="text-center">Generate Salary Report</h1>
    <form method="post" action="{{url('calc_salary')}}">
        @csrf
        <div class="row mb-3 mt-4 p-3 rounded border border-primary d-flex align-items-center bg-white">
          <div class="col-sm mb-2">
            <label for="employee">Choose an employee</label>
            <select class="selectpicker" aria-label="Choose an employee" multiple data-live-search="true" name="employee_ids[]">
                @foreach ($employees as $employee)
                    <option value="{{$employee['id']}}">{{$employee['name']}} {{$employee['surname']}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-sm mb-2">
            <label for="date">Choose a date</label>
            <select class="selectpicker" aria-label="Choose a date" multiple data-live-search="true" name="dates[]">
                @foreach ($allDates as $date)
                    <option value="{{$date}}">{{$date}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-sm mb-2">
            <button type="submit" class="btn btn-primary">Calc salary</button>
          </div>
        </div>
    </form>
    <div class="row mt-3 mb-3 p-2 rounded border border-primary bg-white">
        <div>
            <a href="{{route('history')}}" class="link-primary">History</a>
        </div>
    </div>
    <div class="row mt-3 mb-3 p-2 rounded border border-primary bg-white">
        <div class="col-sm">
            <div>
                <a href="{{route('film_add')}}" class="link-primary">Add a film</a>
            </div>
            <div>
                <a href="{{route('role_add')}}" class="link-primary">Add a role</a>
            </div>
            <div>
                <a href="{{route('employee_add')}}" class="link-primary">Add an employee</a>
            </div>
            <div>
                <a href="{{route('employee_add_role')}}" class="link-primary">Set an employee a role</a>
            </div>
        </div>
        <div class="col-sm">
            <div>
                <a href="{{route('films')}}" class="link-primary">Films list</a>
            </div>
            <div>
                <a href="{{route('employees')}}" class="link-primary">Employees list</a>
            </div>
            <div>
                <a href="{{route('salary_edit')}}" class="link-primary">Edit salary</a>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger mt-2" onclick="this.remove();">
                <ul class="m-0">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
