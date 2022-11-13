<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
</head>
<body>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h1 {
            text-align: center;
        }
        .table, th, td {
            width: 100%;
            border: 1px solid black;
            padding: 3px 15px;
            margin: 0;
        }
        .table {
            border-collapse: collapse;
            border-spacing: 0;
            margin: 20px auto 0;
        }
        thead th {
            background: rgb(183, 179, 197);
        }
    </style>
    <h1>Salary Report</h1>
    <table>
        <thead>
          <tr>
            <th>Employee</th>
            <th>Role</th>
            <th>Month</th>
            <th>Salary</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>
                        @if(!empty($row->name))
                            {{$row->name}}
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>
                        @if(!empty($row->role))
                            {{$row->role}}
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>{{$row->date}}</td>
                    <td>
                        @if(!empty($row->salary))
                            {{$row->salary}}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
</body>
</html>
