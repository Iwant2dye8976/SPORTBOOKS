<!DOCTYPE html>
<html>

<head>
    <title>Laravel 11 Integrate Chat GPT API Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card mt-5">
            <h3 class="card-header p-3">Laravel 11 Integrate Chat GPT API Example</h3>
            <div class="card-body">
                <form method="GET" action="{{ route('gemini.chat') }}">
                    <div class="form-group">
                        <label><strong>Give me your title, I will provide you domains list.</strong></label>
                        <input type="text" name="message" class="form-control" />
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
                @if (!empty($reply))
                    <div class="mt-5">
                        <strong>Result:</strong><br />
                        {{ json_encode($reply, JSON_PRETTY_PRINT) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
