<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belge Listele</title>
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
            border: 1px solid #ccc;
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
        }

        a:hover {
            color: #CB218E;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #6617CB;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #CB218E;
        }
    </style>
</head>
<body>
    <h2>BELGELER</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Proje ID</th>
            <th>Dosya Adı</th>
            <th>Dosya Yolu</th>
            <th>Yükleyen Kullanıcı</th>
            <th>Yüklenme Tarihi</th>
            <th>İşlemler</th>
        </tr>
        <?php
        include("mysqlibaglan.php");
        echo "<a href='sayfa2.php'> Seçeneklere Dön <br/><br/></a>";

        if(isset($_GET['sil']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sil = mysqli_query($baglanti, "DELETE FROM Belgeler WHERE ID = $ID");
            if($sil) {
                header("Location: belge_listele.php");
                exit;
            } else {
                echo "Görev silinirken bir hata oluştu.";
            }
        }

        $sql = "SELECT * FROM Belgeler ";
        $sonuc = mysqli_query($baglanti, $sql);

        if (mysqli_num_rows($sonuc) > 0) {
            while ($satir = mysqli_fetch_assoc($sonuc)) {
                echo "<tr>";
                echo "<td>" . $satir["ID"] . "</td>";
                echo "<td>" . $satir["ProjeID"] . "</td>";
                echo "<td>" . $satir["Dosya_Adi"] . "</td>";
                echo "<td>" . $satir["Dosya_Yolu"] . "</td>";
                echo "<td>" . $satir["Yukleyen_Kullanici"] . "</td>";
                echo "<td>" . $satir["Yuklenme_Tarihi"] . "</td>";
                echo "<td>
                    <a href='belge_listele.php?sil=1&ID=" . $satir["ID"] . "' class='btn'>Sil</a>
                    <a href='belge_listele.php?guncelle=1&ID=" . $satir["ID"] . "' class='btn'>Güncelle</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Hiç belge bulunamadı.</td></tr>";
        }

        if (isset($_GET['guncelle']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sql = "SELECT * FROM Belgeler WHERE ID = $ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if (mysqli_num_rows($sonuc) > 0) {
                $satir = mysqli_fetch_assoc($sonuc);

                // Kullanıcıları seç
                $kullanici_sql = "SELECT * FROM Kullanicilar";
                $kullanici_sonuc = mysqli_query($baglanti, $kullanici_sql);

                // Projeleri seç
                $proje_sql = "SELECT * FROM Projeler";
                $proje_sonuc = mysqli_query($baglanti, $proje_sql);
                ?>
                <h2>Görev Güncelle</h2>
                <form action="belge_listele.php" method="POST">
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
                    <label for="Dosya_Adi">Dosya Adı:</label>
                    <input type="text" name="Dosya_Adi" value="<?php echo $satir['Dosya_Adi']; ?>"><br>
                    <label for="Dosya_Yolu">Dosya Yolu:</label>
                    <input type="text" name="Dosya_Yolu" value="<?php echo $satir['Dosya_Yolu']; ?>"><br>
                    <label for="Yukleyen_Kullanici">Yükleyen Kullanıcı:</label>
                    <select name="Yukleyen_Kullanici">
                        <?php
                        if (mysqli_num_rows($kullanici_sonuc) > 0) {
                            while ($kullanici = mysqli_fetch_assoc($kullanici_sonuc)) {
                                $selected = $kullanici['ID'] == $satir['Yukleyen_Kullanici'] ? 'selected' : '';
                                echo "<option value='" . $kullanici['ID'] . "' $selected>" . $kullanici['Kullanici_Adi'] . "</option>";
                            }
                            }
                            ?>
                    </select><br>
                    <label for="Yuklenme_Tarihi">Yüklenme Tarihi</label>
                    <input type="date" name="Yuklenme_Tarihi" id="Yuklenme_Tarihi" required><br>
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
        $Dosya_Adi = $_POST['Dosya_Adi'];
        $Dosya_Yolu = $_POST['Dosya_Yolu'];
        $Yukleyen_Kullanici = $_POST['Yukleyen_Kullanici'];
        $Yuklenme_Tarihi = $_POST['Yuklenme_Tarihi'];

        $sql = "UPDATE Belgeler SET ProjeID='$ProjeID', Dosya_Adi='$Dosya_Adi', Dosya_Yolu='$Dosya_Yolu', Yukleyen_Kullanici='$Yukleyen_Kullanici', Yuklenme_Tarihi='$Yuklenme_Tarihi' WHERE ID=$ID";
        $sonuc = mysqli_query($baglanti, $sql);

        if ($sonuc) {
            header("Location: belge_listele.php");
            exit;
        } else {
            $hata = mysqli_error($baglanti);
            echo "Görev güncellenirken bir hata oluştu: $hata";
        }
    }

    mysqli_close($baglanti);
    ?>
</table>
</body>
</html>
