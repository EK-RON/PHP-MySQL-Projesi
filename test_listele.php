<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Listele</title>
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

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #6617CB;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #6617CB;
            font-weight: bold;
            margin-top: 20px;
        }

        a:hover {
            color: #CB218E;
        }

        .btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
            background-color: #6617CB;
            color: #fff;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #CB218E;
        }
    </style>
</head>
<body>
    <h2>TESTLER</h2>
    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Proje ID</th>
            <th>Test Adı</th>
            <th>Değerlendirme</th>
            <th>Sonuc</th>
            <th>Test Tarihi</th>
            <th>İşlemler</th>
        </tr>
        <?php
        include("mysqlibaglan.php");

        if(isset($_GET['sil']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sil = mysqli_query($baglanti, "DELETE FROM Testler WHERE ID = $ID");
            if($sil) {
                header("Location: test_listele.php");
                exit;
            } else {
                echo "Görev silinirken bir hata oluştu.";
            }
        }
        
        $sql = "SELECT * FROM Testler";
        $sonuc = mysqli_query($baglanti, $sql);

        if (mysqli_num_rows($sonuc) > 0) {
            while ($satir = mysqli_fetch_assoc($sonuc)) {
                echo "<tr>";
                echo "<td>" . $satir["ID"] . "</td>";
                echo "<td>" . $satir["ProjeID"] . "</td>";
                echo "<td>" . $satir["Test_Adi"] . "</td>";
                echo "<td>" . $satir["Degerlendirme"] . "</td>";
                echo "<td>" . $satir["Sonuc"] . "</td>";
                echo "<td>" . $satir["Test_Tarihi"] . "</td>";
                echo "<td>
                    <a href='test_listele.php?sil=1&ID=" . $satir["ID"] . "' class='btn'>Sil</a>
                    <a href='test_listele.php?guncelle=1&ID=" . $satir["ID"] . "' class='btn'>Güncelle</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Hiç görev bulunamadı.</td></tr>";
        }

        if (isset($_GET['guncelle']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sql = "SELECT * FROM Testler WHERE ID = $ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                $satir = mysqli_fetch_assoc($sonuc);

                // Projeleri seç
                $proje_sql = "SELECT * FROM Projeler";
                $proje_sonuc = mysqli_query($baglanti, $proje_sql);
                ?>
                <h2>Test Güncelle</h2>
                <form action="test_listele.php" method="POST">
                    <input type="hidden" name="ID" value="<?php echo $satir['ID']; ?>">
                    <label for="ProjeID">Proje ID:</label>
                    <select name="ProjeID">
                        <?php
                        if (mysqli_num_rows($proje_sonuc) > 0) {
                            while ($proje = mysqli_fetch_assoc($proje_sonuc)) {
                                $selected = $proje['ID'] == $satir['ProjeID'] ? 'selected' : '';
                                echo "<option value='" . $proje['ID'] . "' $selected>" . $proje['Proje_Adi'] . "</option>";
                            }
                        }
                        ?>
                    </select><br>
                    <label for="Test_Adi">Test Adı :</label>
                    <input type="text" name="Test_Adi" value="<?php echo $satir['Test_Adi']; ?>"><br>
                    <label for ="Degerlendirme ">Değerlendirme:</label>
                    <input type="textarea" name="Degerlendirme" value="<?php echo $satir['Degerlendirme']; ?>"><br>

                    <label for="Sonuc">Sonuç</label>
                    <select name="Sonuc">
                        <option value="Başarılı" <?php if($satir['Sonuc'] == "Başarılı") echo "selected"; ?>>Başarılı</option>
                        <option value="Başarısız" <?php if($satir['Sonuc'] == "Başarısız") echo "selected"; ?>>Başarısız</option>
                        <option value="Beklemede" <?php if($satir['Sonuc'] == "Beklemede") echo "selected"; ?>>Beklemede</option>
                    </select><br><br>

                    <label for="Test_Tarihi">Test Tarihi</label>
                    <input type="date" name="Test_Tarihi" value="<?php echo $satir['Test_Tarihi']; ?>" required>

                    <input type="submit" name="guncelle" value="Güncelle">
                </form>
                <?php
            } else {
                echo "Görev bulunamadı.";
            }
        }

        if (isset($_POST['guncelle'])) {
            $ID = $_POST['ID'];
            $ProjeID = $_POST['ProjeID'];
            $Test_Adi = $_POST['Test_Adi'];
            $Degerlendirme = $_POST['Degerlendirme'];
            $Sonuc = $_POST['Sonuc'];
            $Test_Tarihi = $_POST['Test_Tarihi'];

            $sql = "UPDATE Testler SET ProjeID='$ProjeID', Test_Adi='$Test_Adi', Degerlendirme='$Degerlendirme', Sonuc='$Sonuc', Test_Tarihi='$Test_Tarihi' WHERE ID=$ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if ($sonuc) {
                header("Location: test_listele.php");
                exit;
            } else {
                $hata = mysqli_error($baglanti);
                echo "Görev güncellenirken bir hata oluştu: $hata";
            }
        }

        mysqli_close($baglanti);
        ?>
    </table>
    <a href="sayfa2.php">Seçeneklere Dön</a>
</body>
</html>
