@extends('layout')
@section('content')
    <h1>Edit salary</h1>
    <form method="post" action="/salary/save">
        @csrf
        <div class="row form-group mt-4">
            <div class="col-sm mb-2">
                <label for="employee">Choose a film</label>
                <select class="selectpicker" aria-label="Choose a film" data-live-search="true" name="film_id">
                    @foreach ($films as $film)
                        <option value="{{$film->id}}">{{$film->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm mb-2">
                <div id="role_select_block" style="display: none;">
                    <label for="employee">Choose role</label>
                    <select class="selectpicker" aria-label="Choose role" data-live-search="true" name="role_id"></select>
                </div>
            </div>
            <div class="col-sm mb-2">
                <div id="salary_select_block" style="display: none;">
                    <label for="employee">Enter salary (per month)</label>
                    <input type="text" name="salary">
                </div>
            </div>
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
@endsection
