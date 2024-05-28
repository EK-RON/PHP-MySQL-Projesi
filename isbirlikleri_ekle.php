<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşbirliği Ekle</title>
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
        select {
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
    <h2>İŞBİRLİĞİ EKLE</h2>
    <form action="isbirlikleri_ekle.php" method="POST">
        <label for="ProjeID">Proje Seç</label>
        <select name="ProjeID" id="ProjeID">
            <?php
            include("mysqlibaglan.php");
            
            $sql = "SELECT ID, Proje_Adi FROM Projeler";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                while ($satir = mysqli_fetch_assoc($sonuc)) {
                    echo "<option value='" . $satir["ID"] . "'>" . $satir["Proje_Adi"] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <label for="KatilimciID">Kullanıcı Seç</label>
        <select name="KatilimciID" id="KatilimciID">
            <?php
            $sql = "SELECT ID, Kullanici_Adi FROM Kullanicilar";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                while ($satir = mysqli_fetch_assoc($sonuc)) {
                    echo "<option value='" . $satir["ID"] . "'>" . $satir["Kullanici_Adi"] . "</option>";
                }
            }
            mysqli_close($baglanti);
            ?>
        </select><br><br>

        <label for="Rol">Rol</label>
        <input type="text" name="Rol" required><br><br>

        <label for="Katilim_Tarihi">Katılım Tarihi</label>
        <input type="date" name="Katilim_Tarihi" id="Katilim_Tarihi" required><br><br>

        <input type="submit" name="ekle" value="Ekle">
    </form>
    <a href="sayfa2.php">Seçeneklere Dön<br/><br/></a>
</body>
</html>

<?php
include("mysqlibaglan.php");

if (isset($_POST['ekle'])) {
    $ProjeID = $_POST['ProjeID'];
    $KatilimciID = $_POST['KatilimciID'];
    $Rol = $_POST['Rol'];
    $Katilim_Tarihi = $_POST['Katilim_Tarihi'];

    // Veritabanına yeni işbirliği ekleme sorgusu
    $sql = "INSERT INTO Isbirlikleri (ProjeID, KatilimciID, Rol, Katilim_Tarihi) VALUES ('$ProjeID', '$KatilimciID', '$Rol', '$Katilim_Tarihi')";

    if (mysqli_query($baglanti, $sql)) {
        echo "Yeni işbirliği başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
    }

    mysqli_close($baglanti);
}
?>
