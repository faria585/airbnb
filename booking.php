<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Stay</title>
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
        .booking-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .booking-form h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }
        .booking-form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }
        .booking-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .booking-form button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #ff5a5f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .booking-form button:hover {
            background: #e04a4f;
        }
        .confirmation {
            text-align: center;
            color: #28a745;
            font-size: 1.2em;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .booking-form {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Book Your Stay</h1>
    </header>
    <div class="booking-form">
        <h2>Booking Details</h2>
        <form id="bookingForm" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="check_in">Check-in Date</label>
            <input type="date" id="check_in" name="check_in" value="<?php echo isset($_GET['check_in']) ? $_GET['check_in'] : ''; ?>" required>
            <label for="check_out">Check-out Date</label>
            <input type="date" id="check_out" name="check_out" value="<?php echo isset($_GET['check_out']) ? $_GET['check_out'] : ''; ?>" required>
            <button type="submit">Confirm Booking</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include 'db.php';
            $name = $_POST['name'];
            $email = $_POST['email'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            $property_id = $_GET['property_id'];
            $sql = "SELECT price FROM properties WHERE id = $property_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $price_per_night = $row['price'];
            $check_in_date = new DateTime($check_in);
            $check_out_date = new DateTime($check_out);
            $days = $check_in_date->diff($check_out_date)->days;
            $total_price = $price_per_night * $days;
            $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
            $conn->query($sql);
            $user_id = $conn->insert_id;
            $sql = "INSERT INTO bookings (user_id, property_id, check_in, check_out, total_price, status) 
                    VALUES ($user_id, $property_id, '$check_in', '$check_out', $total_price, 'confirmed')";
            if ($conn->query($sql)) {
                echo "<div class='confirmation'>Booking confirmed! Total: \$$total_price</div>";
            } else {
                echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
