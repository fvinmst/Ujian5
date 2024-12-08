<?php 
// Konfigurasi database 
$host = 'localhost'; // Ganti dengan host database Anda 
$dbname = 'travel_contact'; // Nama database 
$username = 'root'; // Username database Anda 
$password = ''; // Password database Anda (kosong untuk XAMPP) 

// Koneksi ke database menggunakan PDO 
try { 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) { 
    die("Connection failed: " . $e->getMessage()); 
} 

// Periksa apakah form telah disubmit 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Ambil data dari formulir 
    $name = htmlspecialchars(trim($_POST['name'])); 
    $email = htmlspecialchars(trim($_POST['email'])); 
    $message = htmlspecialchars(trim($_POST['message'])); 

    // Validasi input 
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        try { 
            // Query untuk menyimpan data ke database 
            $sql = "INSERT INTO contact_us (name, email, message) VALUES (:name, :email, :message)"; 
            $stmt = $pdo->prepare($sql); 

            // Bind parameter 
            $stmt->bindParam(':name', $name); 
            $stmt->bindParam(':email', $email); 
            $stmt->bindParam(':message', $message); 

            // Eksekusi query 
            $stmt->execute(); 

           // Pesan sukses 
        echo "<h2>Thank you, $name!</h2>"; 
        echo "<p>Your message has been successfully sent. We'll get back to you shortly.</p>"; 

        // Redirect to index.html immediately
        header("Location: index.html");
        exit();
        } 
        catch (Exception $e) {
            echo "<h2>Error</h2>"; 
            echo "<p>There was an error sending your message. Please try again later.</p>"; 
        }
    } else { 
        echo "<h2>Error</h2>"; 
        echo "<p>Please fill out the form correctly.</p>"; 
    } 
} 
?>