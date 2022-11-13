@extends('layout')
@section('content')
    <h1 class="text-center">{{$title ? $title : 'All data'}}</h1>
    @if (!empty($data))
    <table class="table">
        <thead class="table-primary sticky-top">
          <tr>
            <th scope="col">#</th>
            @foreach ($data[0] as $key => $item)
                @if (in_array($key, $columns))
                    <th scope="col">{{$key}}</th>
                @endif
            @endforeach
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <th scope="col">{{$key + 1}}</th>
                    @foreach ($item as $index => $value)
                        @if (in_array($index, $columns))
                            <th scope="col">{{$value}}</th>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
      </table>
    @else
      Sorry, no data here :(
    @endif
@endsection
