<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-content-center bg-light">
        <h1>Nuovo post creato!</h1>
        <p class="pt-5"><strong>{{$newPostInfo->user->name}}</strong> ha creato un nuovo post!</p>
        <p>La sua email è: <strong>{{$newPostInfo->user->email}}</strong></p>
        <p>Il titolo del post è <strong>{{$newPostInfo->title}}</strong></p>
        <p class="pt-5">Per leggere il post recati sul sito !</p>
    </div>
</body>
</html>
