<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeler</title>
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
            font-size: 24px;
            font-weight: bold;
            color: #6617CB;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #6617CB;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        form {
            width: 90%;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        input[type="date"] {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        input[type="submit"] {
            width: 100%;
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
    <h2>PROJELER</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Proje Adı</th>
            <th>Proje Tanımı</th>
            <th>Durum</th>
            <th>Oluşturulma Tarihi</th>
            <th>İşlemler</th>
        </tr>

        <?php
        include("mysqlibaglan.php");

        if(isset($_GET['sil']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            
            // Bağlı kayıtları kontrol etme
            $kontrol_gorevler = mysqli_query($baglanti, "SELECT * FROM Gorevler WHERE ProjeID = $ID");
            $kontrol_testler = mysqli_query($baglanti, "SELECT * FROM Testler WHERE ProjeID = $ID");
            $kontrol_belgeler = mysqli_query($baglanti, "SELECT * FROM Belgeler WHERE ProjeID = $ID");
            $kontrol_isbirlikleri = mysqli_query($baglanti, "SELECT * FROM Isbirlikleri WHERE ProjeID = $ID");

            if (mysqli_num_rows($kontrol_gorevler) > 0 || mysqli_num_rows($kontrol_testler) > 0
            || mysqli_num_rows($kontrol_belgeler) > 0 || mysqli_num_rows($kontrol_isbirlikleri) > 0) {
                echo "<tr><td colspan='6'>Bu projeyi silemezsiniz. Önce bu projeye bağlı belgeleri ve işbirliklerini silmelisiniz.</td></tr>";
            } else {
                // Projeyi silme
                $sil_proje = mysqli_query($baglanti, "DELETE FROM Projeler WHERE ID = $ID");
                if($sil_proje) {
                    header("Location: proje_listele.php");
                    exit;
                } else {
                    echo "<tr><td colspan='6'>Proje silinirken bir hata oluştu.</td></tr>";
                }
            }
        }

        $sql = "SELECT * FROM Projeler";
        $sonuc = mysqli_query($baglanti, $sql);

        if (mysqli_num_rows($sonuc) > 0) {
            while ($satir = mysqli_fetch_assoc($sonuc)) {
                echo "<tr>";
                echo "<td>" . $satir["ID"] . "</td>";
                echo "<td>" . $satir["Proje_Adi"] . "</td>";
                echo "<td>" . $satir["Proje_Tanimi"] . "</td>";
                echo "<td>" . $satir["Durum"] . "</td>";
                echo "<td>" . $satir["Olusturulma_Tarihi"] . "</td>";
                echo "<td>
                        <a href='proje_listele.php?sil=1&ID=" . $satir["ID"] . "' name='sil' class='btn'>Sil</a>
                        <a href='proje_listele.php?guncelle=1&ID=" . $satir["ID"] . "' name='guncelle' class='btn'>Güncelle</a>
                        </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<tr><td colspan='6'>Hiç proje bulunamadı.</td></tr>";
        }

        if (isset($_GET['guncelle']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sql = "SELECT * FROM Projeler WHERE ID = $ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                $satir = mysqli_fetch_assoc($sonuc);
                ?>
                <h2>Proje Güncelle</h2>
                <form action="proje_listele.php" method="POST">
                   
                <input type="hidden" name="ID" value="<?php echo $satir['ID']; ?>">
                    <label for="Proje_Adi">Proje Adı:</label>
                    <input type="text" name="Proje_Adi" value="<?php echo $satir['Proje_Adi']; ?>"><br>
                    <label for="Proje_Tanimi">Proje Tanımı:</label>
                    <textarea name="Proje_Tanimi" rows="4" cols="50"><?php echo $satir['Proje_Tanimi']; ?></textarea><br>
                    <label for="Durum">Durum:</label>
                    <select name="Durum">
                        <option value="Planlanıyor" <?php if($satir['Durum'] == 'Planlanıyor') echo 'selected'; ?>>Planlanıyor</option>
                        <option value="Devam Ediyor" <?php if($satir['Durum'] == 'Devam Ediyor') echo 'selected'; ?>>Devam Ediyor</option>
                        <option value="Tamamlandı" <?php if($satir['Durum'] == 'Tamamlandı') echo 'selected'; ?>>Tamamlandı</option>
                        <option value="İptal Edildi" <?php if($satir['Durum'] == 'İptal Edildi') echo 'selected'; ?>>İptal Edildi</option>
                    </select><br><br>
                    <label for="Olusturulma_Tarihi">Oluşturulma Tarihi:</label>
                    <input type="date" name="Olusturulma_Tarihi" value="<?php echo $satir['Olusturulma_Tarihi']; ?>"><br><br>
                    <input type="submit" name="guncelle" value="Güncelle">
                </form>
                <?php
            } else {
                echo "<p>Görev bulunamadı.</p>";
            }
        }

        if (isset($_POST['guncelle'])) {
            $ID = $_POST['ID'];
            $Proje_Adi = $_POST['Proje_Adi'];
            $Proje_Tanimi = $_POST['Proje_Tanimi'];
            $Durum = $_POST['Durum'];
            $Olusturulma_Tarihi = $_POST['Olusturulma_Tarihi'];

            $sql = "UPDATE Projeler SET Proje_Adi='$Proje_Adi', Proje_Tanimi='$Proje_Tanimi', Durum='$Durum', Olusturulma_Tarihi='$Olusturulma_Tarihi' WHERE ID=$ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if ($sonuc) {
                header("Location: proje_listele.php");
                exit;
            } else {
                $hata = mysqli_error($baglanti);
                echo "<p>Görev güncellenirken bir hata oluştu: $hata</p>";
            }
        }
        mysqli_close($baglanti);
        ?>
    <a href="sayfa2.php">Seçeneklere Dön</a>
</body>
</html>
