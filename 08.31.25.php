<?php
// 08.31.25.php
$galleryDir = "images/083125/";

// Create folder if it doesn't exist
if (!is_dir($galleryDir)) {
    mkdir($galleryDir, 0777, true);
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $targetFile = $galleryDir . basename($_FILES["photo"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    $allowedTypes = ["jpg","jpeg","png","gif"];

    if (!in_array($imageFileType, $allowedTypes)) {
        $uploadError = "Only JPG, PNG, and GIF files are allowed.";
    } else {
        $uniqueName = $galleryDir . time() . "_" . basename($_FILES["photo"]["name"]);
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uniqueName)) {
            header("Location: 08.31.25.php");
            exit;
        } else {
            $uploadError = "Error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>08/31/2025 - Germantown MetroPark Photos</title>
    <link rel="stylesheet" href="style.css">

    <!-- Lightbox2 CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <style>
        h1, h2, p {
            color: black;
            text-align: center;
        }

        .photo-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

            .photo-gallery img {
                width: 250px;
                height: 180px;
                object-fit: cover;
                border-radius: 8px;
                box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
                transition: transform 0.2s ease;
                cursor: pointer;
            }

                .photo-gallery img:hover {
                    transform: scale(1.05);
                }

        .upload-form {
            max-width: 400px;
            margin: 30px auto;
            text-align: center;
        }

            .upload-form input[type="file"] {
                margin-bottom: 10px;
            }

            .upload-form button {
                padding: 6px 12px;
                font-weight: bold;
                cursor: pointer;
                border-radius: 6px;
                background-color: #4CAF50;
                color: white;
                border: none;
                transition: background-color 0.3s ease;
            }

                .upload-form button:hover {
                    background-color: #45a049;
                }

        footer {
            text-align: center;
            padding: 15px 0;
            margin-top: 30px;
            background: rgba(76, 175, 80, 0.5);
            color: black;
        }

            footer small {
                display: block;
                font-size: 0.8em;
                margin-top: 5px;
            }
    </style>
</head>
<body>
    <header>
        <h1>08/31/2025 - Germantown MetroPark</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="photos.html">Photo Gallery</a>
            <a href="posts.html">Family Messages</a>
        </nav>
    </header>

    <main>
        <h2>Photo Memories from 2025</h2>

        <?php if(isset($uploadError)) echo '<p style="color:red;">'.$uploadError.'</p>'; ?>

        <div class="photo-gallery">
            <?php
            $files = glob($galleryDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            sort($files);
            foreach($files as $file){
            echo '<a href="'.$file.'" data-lightbox="gallery"><img src="'.$file.'" alt=""></a>';
            }
            ?>
        </div>

        <div class="upload-form">
            <h3>Upload Your Photo</h3>
            <form action="08.31.25.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="photo" accept="image/*" required><br>
                <button type="submit">Upload</button>
            </form>
            <p><em>Photos will appear in the gallery automatically.</em></p>
        </div>
    </main>

    <footer>
        <p>© 2025 Our Family Reunion</p>
        <small>Last updated: September 2, 2025</small>
    </footer>
</body>
</html>
