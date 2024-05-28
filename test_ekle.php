<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Ekleme</title>
    <style>
        body {
            background: linear-gradient(to right, #9AB5E1, #F39FDC);
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: Arial;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-family: Arial Black;
            color: #6617CB;
        }

        form {
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #6617CB;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #CB218E;
        }

        select {
            appearance: none;
        }
    </style>
</head>
<body>
    <h2>TEST EKLE</h2>
    <form action="test_ekle.php" method="POST">

        <label for="ProjeID">Proje Seç</label>
        <select name="ProjeID" id="ProjeID">
            <?php
            include("mysqlibaglan.php");
            
            $sql = "SELECT ID, Proje_Adi FROM Projeler";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                while ($row = mysqli_fetch_assoc($sonuc)) {
                    echo "<option value='" . $row["ID"] . "'>" . $row["Proje_Adi"] . "</option>";
                }
            }
            
            ?>
        </select><br><br>

        <label for="Test_Adi">Test Adı</label>
        <input type="text" name="Test_Adi" required><br><br>

        <label for="Degerlendirme">Değerlendirme</label>
        <textarea name="Degerlendirme" " rows="4" cols="50" required></textarea><br><br>

        <label for="Sonuc">Sonuç</label>
        <select name="Sonuc">
            <option value="Başarılı">Başarılı</option>
            <option value="Başarısız">Başarısız</option>
            <option value="Beklemede">Beklemede</option>
        </select><br><br>
        <label for="Test_Tarihi">Test Tarihi</label>
        <input type="date" name="Test_Tarihi" id="Test_Tarihi" required><br><br>
        <input type="submit" name="ekle" value="Ekle">
    </form>
    <a href="sayfa2.php">Seçeneklere Dön</a>
</body>
</html>

<?php
include("mysqlibaglan.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['ekle'])) {
        $ProjeID = $_POST['ProjeID'];
        $Test_Adi = $_POST['Test_Adi'];
        $Degerlendirme = $_POST['Degerlendirme'];
        $Sonuc = $_POST['Sonuc'];
        $Test_Tarihi = $_POST['Test_Tarihi'];    
        
        $sql = "INSERT INTO Testler (ProjeID ,Test_Adi, Degerlendirme, Sonuc, Test_Tarihi) 
        VALUES ('$ProjeID' ,'$Test_Adi', '$Degerlendirme', '$Sonuc', '$Test_Tarihi')";

        if (mysqli_query($baglanti, $sql)) {
            echo "Yeni görev başarıyla eklendi.";
        } else {
            echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
        }
    }   
}

mysqli_close($baglanti);
?>
