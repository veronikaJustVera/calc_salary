@extends('layout')
@section('content')
    @if (!empty($customMessage))
        <div class="alert alert-success" onclick="this.remove();">
            <ul>
                <li>{{ $customMessage }}</li>
            </ul>
        </div>
    @endif
    <h1 class="text-center">Set an employee a role</h1>
    <form method="post" action="/employee/saverole">
        @csrf
        <div class="row form-group mt-4 p-3 d-flex align-items-center rounded border border-primary">
          <div class="col-sm mb-2">
            <label for="employee">Choose an employee</label>
            <select class="selectpicker" aria-label="Choose an employee" data-live-search="true" name="employee_id">
                @foreach ($employees as $employee)
                    <option value="{{$employee['id']}}">{{$employee['name']}} {{$employee['surname']}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-sm mb-2">
            <label for="date">Choose a film</label>
            <select class="selectpicker" aria-label="Choose a film" data-live-search="true" name="film_id">
                @foreach ($allFilms as $film)
                    <option value="{{$film['id']}}">{{$film['title']}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-sm mb-2">
                <label for="date">Choose a role</label>
                <select class="selectpicker" aria-label="Choose a role" data-live-search="true" name="role_id">
                    @foreach ($allRoles as $role)
                        <option value="{{$role['id']}}">{{$role['title']}}</option>
                    @endforeach
                </select>
          </div>
          <div class="col-sm mb-2">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
    </form>
@endsection
