@extends('layout')
@section('content')
    <h1 class="text-center">History</h1>
    @if (!empty($history))
    <table class="table" id="history-table">
        <thead class="table-primary sticky-top">
          <tr>
            <th scope="col" onclick=>
                #
                {{-- <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg> --}}
            </th>
            <th scope="col">
                Employee
                {{-- <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg> --}}
            </th>
            <th scope="col">
                Role
                {{-- <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg> --}}
            </th>
            <th scope="col">
                Month
                {{-- <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg> --}}
            </th>
            <th scope="col">
                Salary
                {{-- <svg class="d-inline" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#444" d="M11 7H5l3-4zM5 9h6l-3 4z"/></svg> --}}
            </th>
          </tr>
        </thead>
        <tbody>
            @foreach ($history as $key => $item)
                <tr>
                    <th scope="col">{{$key + 1}}</th>
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
    {{-- <script>
        const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

        const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
            )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

        document.querySelectorAll('thead th').forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table');
            Array.from(table.querySelectorAll('tbody tr:nth-child(n+2)'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => table.appendChild(tr) );
        })));
    </script> --}}
@endsection
