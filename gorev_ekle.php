<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görev Ekleme Ekranı</title>
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
    <h2>GÖREV EKLE</h2>
    <form action="gorev_ekle.php" method="POST">
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
        <label for="Atanan_Kullanici">Kullanıcı Seç</label>
        <select name="Atanan_Kullanici" id="Atanan_Kullanici">
            <?php
            include("mysqlibaglan.php");

            $sql = "SELECT ID, Kullanici_Adi FROM Kullanicilar";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                while ($row = mysqli_fetch_assoc($sonuc)) {
                    echo "<option value='" . $row["ID"] . "'>" . $row["Kullanici_Adi"] . "</option>";
                }
            }
            mysqli_close($baglanti);
            ?>
        </select><br><br>   

        <label for="Gorev_Baslıgı">Görev Başlığı</label>
        <input type="text" name="Gorev_Baslıgı" required><br><br>

        <label for="Aciklama">Açıklama</label>
        <textarea name="Aciklama" rows="4" cols="40" required></textarea><br><br>

        <label for="Durum">Durum</label>
        <select name="Durum">
            <option value="Planlanıyor">Planlanıyor</option>
            <option value="Devam Ediyor">Devam Ediyor</option>
            <option value="Tamamlandı">Tamamlandı</option>
            <option value="İptal Edildi">İptal Edildi</option>
        </select><br><br>

        <label for="Gorev_Tarihi">Görev Tarihi</label>
        <input type="date" name = "Gorev_Tarihi" id ="Gorev_Tarihi"required><br><br>

        <input type="submit" name="ekle" value="EKLE">
    </form>
    <a href="sayfa2.php">Seçeneklere Dön</a>
    
</body>
</html>

<?php
include("mysqlibaglan.php");

if (isset($_POST['ekle'])) {
    $ProjeID = $_POST['ProjeID'];
    $Gorev_Baslıgı = $_POST['Gorev_Baslıgı'];
    $Aciklama = $_POST['Aciklama'];
    $Atanan_Kullanici = $_POST['Atanan_Kullanici'];
    $Durum = $_POST['Durum'];
    $Gorev_Tarihi = $_POST['Gorev_Tarihi'];

    // Veritabanına yeni görev ekleme sorgusu
    $sql = "INSERT INTO Gorevler (ProjeID ,Gorev_Baslıgı, Aciklama, Atanan_Kullanici, Durum, Gorev_Tarihi) VALUES ('$ProjeID' ,'$Gorev_Baslıgı', '$Aciklama', '$Atanan_Kullanici' ,'$Durum', '$Gorev_Tarihi')";

    if (mysqli_query($baglanti, $sql)) {
        echo "Yeni görev başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
    }

    mysqli_close($baglanti);
}
?>
