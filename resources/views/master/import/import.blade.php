<!DOCTYPE html>
<html>

<head>
    <title>Laravel 6 Import Export Excel to database Example - nicesnippets.com</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>

<body>

    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Laravel 6 Import Export Excel to database Example - nicesnippets.com
            </div>
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                {{ $message }}
            </div>
            @endif

            @if($failures ?? '')
            <div class="alert alert-danger" role="alert">
                <strong>Errors:</strong>

                <ul>
                    @foreach ($failures as $failure)
                    @foreach ($failure->errors() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card-body">
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_file" class="form-control">
                    <br>
                    <button class="btn btn-success">Import User Data</button>
                    <a class="btn btn-warning" href="">Export User Data</a>
                </form>
            </div>
        </div>

    </div>

</body>

</html>