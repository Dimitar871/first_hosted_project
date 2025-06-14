<!DOCTYPE html>
<html>
<head>
    <title>Tasks App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f0f2f5;
        }
        h1 {
            color: #333;
        }
        a {
            margin-right: 1rem;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 1rem;
        }
        input, textarea, button {
            display: block;
            margin-bottom: 1rem;
            padding: 0.5rem;
            width: 100%;
            max-width: 400px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            background-color: #fff;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
