<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>
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
        }
        .filters {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
        }
        .filters select, .filters input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .listings {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .property-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .property-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .property-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .property-item h3 {
            font-size: 1.5em;
            padding: 15px;
            color: #333;
        }
        .property-item p {
            padding: 0 15px 15px;
            color: #666;
        }
        .property-item button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #ff5a5f;
            color: white;
            border: none;
            border-radius: 0 0 15px 15px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .property-item button:hover {
            background: #e04a4f;
        }
        @media (max-width: 768px) {
            .filters {
                flex-direction: column;
            }
            .filters select, .filters input {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Property Listings</h1>
    </header>
    <div class="filters">
        <select id="sort">
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="rating">Best Rated</option>
        </select>
        <input type="number" id="min_price" placeholder="Min Price">
        <input type="number" id="max_price" placeholder="Max Price">
        <select id="property_type">
            <option value="">All Types</option>
            <option value="Apartment">Apartment</option>
            <option value="House">House</option>
            <option value="Villa">Villa</option>
        </select>
    </div>
    <div class="listings">
        <div class="property-list">
            <?php
            include 'db.php';
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            $check_in = isset($_GET['check_in']) ? $_GET['check_in'] : '';
            $check_out = isset($_GET['check_out']) ? $_GET['check_out'] : '';
            $sql = "SELECT * FROM properties WHERE location LIKE '%$location%'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='property-item'>
                    <img src='{$row['image']}' alt='{$row['title']}'>
                    <h3>{$row['title']}</h3>
                    <p>\${$row['price']}/night</p>
                    <p>Rating: {$row['rating']}/5</p>
                    <button onclick=\"bookProperty({$row['id']}, '$check_in', '$check_out')\">Book Now</button>
                </div>";
            }
            ?>
        </div>
    </div>
    <script>
        function bookProperty(id, checkIn, checkOut) {
            window.location.href = `booking.php?property_id=${id}&check_in=${checkIn}&check_out=${checkOut}`;
        }
    </script>
</body>
</html>
