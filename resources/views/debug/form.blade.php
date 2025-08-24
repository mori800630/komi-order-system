<!DOCTYPE html>
<html>
<head>
    <title>Debug Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Debug Form</h1>
    
    <form method="POST" action="{{ secure_url(route('debug.test', [], false)) }}">
        @csrf
        <input type="text" name="test_field" value="test_value" required>
        <button type="submit">Submit</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<p>Error: ' + error.message + '</p>';
            });
        });
    </script>
</body>
</html>
