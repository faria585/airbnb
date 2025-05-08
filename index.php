<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb Clone - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: #f4f4f9;
        }
        header {
            background: linear-gradient(135deg, #ff5a5f, #ff7a7f);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        header h1 {
            font-size: 2.5em;
            letter-spacing: 1px;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 50px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            max-width: 800px;
        }
        .search-bar input, .search-bar button {
            padding: 12px;
            margin: 0 10px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
        }
        .search-bar input {
            flex: 1;
            border: 1px solid #ddd;
        }
        .search-bar button {
            background: #ff5a5f;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-bar button:hover {
            background: #e04a4f;
        }
        .featured {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .featured h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }
        .property-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .property-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .property-card:hover {
            transform: translateY(-5px);
        }
        .property-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .property-card h3 {
            font-size: 1.5em;
            padding: 15px;
            color: #333;
        }
        .property-card p {
            padding: 0 15px 15px;
            color: #666;
        }
        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
                max-width: 90%;
            }
            .search-bar input, .search-bar button {
                margin: 10px 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Airbnb Clone</h1>
    </header>
    <div class="search-bar">
        <input type="text" id="location" placeholder="Where are you going?">
        <input type="date" id="check_in" placeholder="Check-in">
        <input type="date" id="check_out" placeholder="Check-out">
        <button onclick="searchProperties()">Search</button>
    </div>
    <div class="featured">
        <h2>Featured Stays</h2>
        <div class="property-grid">
            <?php
            include 'db.php';
            $sql = "SELECT * FROM properties LIMIT 3";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='property-card'>
                    <img src='{$row['image']}' alt='{$row['title']}'>
                    <h3>{$row['title']}</h3>
                    <p>\${$row['price']}/night</p>
                </div>";
            }
            ?>
        </div>
    </div>
    <script>
        function searchProperties() {
            const location = document.getElementById('location').value;
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            window.location.href = `listings.php?location=${encodeURIComponent(location)}&check_in=${checkIn}&check_out=${checkOut}`;
        }
    </script>
</body>
</html>
