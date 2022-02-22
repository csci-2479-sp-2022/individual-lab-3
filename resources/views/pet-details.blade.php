<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3</title>
</head>
<body>
    <h1>Welcome to Lab 3</h1>
    <nav>
        <p><a href="/pets">Back to list</a></p>
    </nav>
    <h2>{{$pet->name}}</h2>
    <p>{{$pet->name}} is a {{$pet->age}} year old {{$pet->type}}.</p>
</body>
</html>
