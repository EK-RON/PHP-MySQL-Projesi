<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşbirlikleri Listele</title>
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
            margin-bottom: 30px;
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

        tr:hover {
            background-color: #ddd;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #6617CB;
            color: #fff;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn:hover {
            background-color: #CB218E;
        }
    </style>
</head>
<body>
    <h2>İŞBİRLİKLERİ</h2>
    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Proje ID</th>
            <th>Katılımcı ID</th>
            <th>Rol</th>
            <th>Katılım Tarihi</th>
            <th>İşlemler</th>
        </tr>
        <?php
        include("mysqlibaglan.php");
        echo "<a href='sayfa2.php'> Seçeneklere Dön <br/><br/></a>";

        if(isset($_GET['sil']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sil = mysqli_query($baglanti, "DELETE FROM Isbirlikleri WHERE ID = $ID");
            if($sil) {
                header("Location: isbirlikleri_listele.php");
                exit;
            } else {
                echo "İşbirliği silinirken bir hata oluştu.";
            }
        }
        
        $sql = "SELECT * FROM Isbirlikleri";
        $sonuc = mysqli_query($baglanti, $sql);

        if (mysqli_num_rows($sonuc) > 0) {
            while ($satir = mysqli_fetch_assoc($sonuc)) {
                echo "<tr>";
                echo "<td>" . $satir["ID"] . "</td>";
                echo "<td>" . $satir["ProjeID"] . "</td>";
                echo "<td>" . $satir["KatilimciID"] . "</td>";
                echo "<td>" . $satir["Rol"] . "</td>";
                echo "<td>" . $satir["Katilim_Tarihi"] . "</td>";
                echo "<td>
                    <a href='isbirlikleri_listele.php?sil=1&ID=" . $satir["ID"] . "' class='btn'>Sil</a>
                    <a href='isbirlikleri_listele.php?guncelle=1&ID=" . $satir["ID"] . "' class='btn'>Güncelle</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Hiç işbirliği bulunamadı.</td></tr>";
        }

        if (isset($_GET['guncelle']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sql = "SELECT * FROM Isbirlikleri WHERE ID = $ID";
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
                <h2>İşbirliği Güncelle</h2>
                <form action="isbirlikleri_listele.php" method="POST">
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
                    
                    <label for="KatilimciID">Katılımcı ID:</label>
                    <select name="KatilimciID">
                        <?php
                        if (mysqli_num_rows($kullanici_sonuc) > 0) {
                            while ($kullanici = mysqli_fetch_assoc($kullanici_sonuc)) {
                                $selected = $kullanici['ID'] == $satir['KatilimciID'] ? 'selected' : '';
                                echo "<option value='" . $kullanici['ID'] . "' $selected>" . $kullanici['Kullanici_Adi'] . "</option>";
                            }
                        }
                        ?>
                    </select><br>
                    <label for="Rol">Rol:</label>
                    <input type="text" name="Rol" value="<?php echo $satir['Rol']; ?>"><br>
                    <label for="Katilim_Tarihi">Katılım Tarihi:</label>
                    <input type="date" name="Katilim_Tarihi" value="<?php echo $satir['Katilim_Tarihi']; ?>" required>

                    <input type="submit" name="guncelle" value="Güncelle">
                </form>
                <?php
            } else {
                echo "İşbirliği bulunamadı.";
            }
        }

        if (isset($_POST['guncelle'])) {
            $ID = $_POST['ID'];
            $ProjeID = $_POST['ProjeID'];
            $KatilimciID = $_POST['KatilimciID'];
            $Rol = $_POST['Rol'];
            $Katilim_Tarihi = $_POST['Katilim_Tarihi'];

            $sql = "UPDATE Isbirlikleri SET ProjeID='$ProjeID', KatilimciID='$KatilimciID', Rol='$Rol', Katilim_Tarihi='$Katilim_Tarihi' WHERE ID=$ID";
            $sonuc = mysqli_query($baglanti, $sql);

            if ($sonuc) {
                header("Location: isbirlikleri_listele.php");
                exit;
            } else {
                $hata = mysqli_error($baglanti);
                echo "İşbirliği güncellenirken bir hata oluştu: $hata";
            }
        }

        mysqli_close($baglanti);
        ?>
    </table>
</body>
</html>

