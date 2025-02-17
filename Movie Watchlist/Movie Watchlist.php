<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Watchlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2e;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #282a36;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            margin-bottom: 20px;
        }
        input {
            width: 70%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #ff5c8a;
            color: white;
            cursor: pointer;
            margin-left: 5px;
        }
        button:hover {
            background-color: #ff1e60;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #444;
            margin: 10px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .watched {
            text-decoration: line-through;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Movie Watchlist</h1>
        <input type="text" id="movieInput" placeholder="Enter movie name...">
        <button onclick="addMovie()">Add</button>
        <ul id="movieList"></ul>
    </div>
    <script>
        function addMovie() {
            let input = document.getElementById("movieInput");
            let movieName = input.value.trim();
            if (movieName === "") return;
            
            let li = document.createElement("li");
            li.innerHTML = `<span>${movieName}</span>
                            <button onclick="markWatched(this)">Watched</button>
                            <button onclick="removeMovie(this)">Remove</button>`;
            
            document.getElementById("movieList").appendChild(li);
            input.value = "";
        }
        function markWatched(button) {
            let movieItem = button.parentElement;
            movieItem.classList.toggle("watched");
        }
        function removeMovie(button) {
            let movieItem = button.parentElement;
            movieItem.remove();
        }
    </script>
</body>
</html>
