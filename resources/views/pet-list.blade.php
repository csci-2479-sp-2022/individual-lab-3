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
        <p><a href="/">Home</a></p>
    </nav>
    <h2>My pets</h2>
    <ul>
        @foreach($pets as $pet)
        <li>
            <a href="/pets/{{$pet->id}}">View details about {{$pet->name}}</a>
        </li>
        @endforeach
    </ul>
</body>
</html>
