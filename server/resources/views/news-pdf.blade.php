<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    body {
      font-family: sans-serif;
    }
    
    .title {
      font-size: 1.875rem;
      font-weight: 700;
      text-align: center;
    }

    .description {
      font-size: 20px;
    }
  </style>
</head>
<body>
  <h1 class="title">{{ $news->title }}</h1>
  <p class="description">{{ $news->description }}</p>
</body>
</html>