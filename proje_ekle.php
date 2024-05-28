<?php
include("mysqlibaglan.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['ekle'])) {
        $Proje_Adi = $_POST['Proje_Adi'];
        $Proje_Tanimi = $_POST['Proje_Tanimi'];
        $Durum = $_POST['Durum'];
        $Olusturulma_Tarihi = $_POST['Olusturulma_Tarihi'];

        $sql = "INSERT INTO Projeler (Proje_Adi, Proje_Tanimi, Durum, Olusturulma_Tarihi) VALUES ('$Proje_Adi', '$Proje_Tanimi', '$Durum', '$Olusturulma_Tarihi')";

        if (mysqli_query($baglanti, $sql)) {
            echo "Yeni proje başarıyla oluşturuldu.";
        } else {
            echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
        }  
    }   
}

mysqli_close($baglanti);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proje Ekle/Düzenle</title>
    <style>
        body {
            background: linear-gradient(to right, #9AB5E1, #F39FDC);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #6617CB;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 300px;
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
            width: 200px;
            padding: 12px;
            background-color: #6617CB;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #CB218E;
        }

        a {
            text-decoration: none;
            color: #6617CB;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }

        a:hover {
            color: #CB218E;
        }
    </style>
</head>
<body>
    <h2>PROJE EKLE</h2>
    <form action="proje_ekle.php" method="POST">
        <label for="Proje_Adi">Proje Adı</label>
        <input type="text" name="Proje_Adi"  required>

        <label for="Proje_Tanimi">Proje Tanımı</label>
        <textarea name="Proje_Tanimi" rows="4" cols="50" required></textarea>

        <label for="Durum">Durum</label>
        <select name="Durum">
            <option value="Planlanıyor">Planlanıyor</option>
            <option value="Devam Ediyor">Devam Ediyor</option>
            <option value="Tamamlandı">Tamamlandı</option>
            <option value="İptal Edildi">İptal Edildi</option>
        </select>
        <label for="Olusturulma_Tarihi">Oluşturulma Tarihi</label>
        <input type="date" name="Olusturulma_Tarihi" id="Olusturulma_Tarihi" required>
        <input type="submit" name="ekle" value="EKLE">
    </form>
    <a href="sayfa2.php">Seçeneklere Dön</a>
</body>
</html>
