<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görev Listele</title>
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
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #6617CB;
            color: white;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #CB218E;
        }
    </style>
</head>
<body>
    <h2>GÖREVLER</h2>
    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Proje ID</th>
            <th>Görev Başlığı</th>
            <th>Açıklama</th>
            <th>Atanan Kullanıcı</th>
            <th>Durum</th>
            <th>Görev Tarihi</th>
            <th>İşlemler</th>
        </tr>
        <?php
        include("mysqlibaglan.php");
        echo "<a href='sayfa2.php'> Seçeneklere Dön <br/><br/></a>";

        // Silme işlemi
        if (isset($_GET['sil']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sil = mysqli_query($baglanti, "DELETE FROM Gorevler WHERE ID = $ID");
            if ($sil) {
                header("Location: gorev_listele.php");
                exit;
            } else {
                echo "Görev silinirken bir hata oluştu.";
            }
        }

        // Görevleri seç
        $sql = "SELECT * FROM Gorevler";
        $sonuc = mysqli_query($baglanti, $sql);

        if (mysqli_num_rows($sonuc) > 0) {
            while ($satir = mysqli_fetch_assoc($sonuc)) {
                echo "<tr>";
                echo "<td>" . $satir["ID"] . "</td>";
                echo "<td>" . $satir["ProjeID"] . "</td>";
                echo "<td>" . $satir["Gorev_Baslıgı"] . "</td>";
                echo "<td>" . $satir["Aciklama"] . "</td>";
                echo "<td>" . $satir["Atanan_Kullanici"] . "</td>";
                echo "<td>" . $satir["Durum"] . "</td>";
                echo "<td>" . $satir["Gorev_Tarihi"] . "</td>";

                echo "<td>
                    <a href='gorev_listele.php?sil=1&ID=" . $satir["ID"] . "' name='sil' class='btn'>Sil</a>
                    <a href='gorev_listele.php?guncelle=1&ID=" . $satir["ID"] . "' name='guncelle' class='btn'>Güncelle</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Hiç görev bulunamadı.</td></tr>";
        }

        // Güncelleme işlemi
        if (isset($_GET['guncelle']) && isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $sql = "SELECT * FROM Gorevler WHERE ID = $ID";
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
                <form action="gorev_listele.php" method="POST">
                    <input type="hidden" name="ID" value="<?php echo $satir['ID']; ?>">
                    <label for="ProjeID">Proje ID:</label>
                    <select name="ProjeID">
                        <?php
                        if (mysqli_num_rows($proje_sonuc) > 0) {
                            while ($proje = mysqli_fetch_assoc($proje_sonuc)) {
                                $selected = $proje['ID'] == $satir['ProjeID'] ? 'selected' : '';
                                echo "<option value='" . $proje['ID'] . "' $selected>" . $proje['Proje_Adi'] . "</option>";
                            }
                       
                            ?>
                            </select><br>
                            <label for="Gorev_Basligi">Görev Başlığı:</label>
                            <input type="text" name="Gorev_Basligi" value="<?php echo $satir['Gorev_Baslıgı']; ?>"><br>
                            <label for="Aciklama">Açıklama:</label>
                            <input type="text" name="Aciklama" value="<?php echo $satir['Aciklama']; ?>"><br>
                            <label for="Atanan_Kullanici">Atanan Kullanıcı:</label>
                            <select name="Atanan_Kullanici">
                                <?php
                                if (mysqli_num_rows($kullanici_sonuc) > 0) {
                                    while ($kullanici = mysqli_fetch_assoc($kullanici_sonuc)) {
                                        $selected = $kullanici['ID'] == $satir['Atanan_Kullanici'] ? 'selected' : '';
                                        echo "<option value='" . $kullanici['ID'] . "' $selected>" . $kullanici['Kullanici_Adi'] . "</option>";
                                    }
                                }
                                ?>
                            </select><br>
        
                            <label for="Durum">Durum</label>
                            <select name="Durum">
                                <option value="Planlanıyor" <?php echo $satir['Durum'] == 'Planlanıyor' ? 'selected' : ''; ?>>Planlanıyor</option>
                                <option value="Devam Ediyor" <?php echo $satir['Durum'] == 'Devam Ediyor' ? 'selected' : ''; ?>>Devam Ediyor</option>
                                <option value="Tamamlandı" <?php echo $satir['Durum'] == 'Tamamlandı' ? 'selected' : ''; ?>>Tamamlandı</option>
                                <option value="İptal Edildi" <?php echo $satir['Durum'] == 'İptal Edildi' ? 'selected' : ''; ?>>İptal Edildi</option>
                            </select><br><br>
        
                            <label for="Gorev_Tarihi">Görev Tarihi</label>
                            <input type="date" name="Gorev_Tarihi" id="Gorev_Tarihi" value="<?php echo $satir['Gorev_Tarihi']; ?>" required>
        
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
                    $Gorev_Basligi = $_POST['Gorev_Basligi'];
                    $Aciklama = $_POST['Aciklama'];
                    $Atanan_Kullanici = $_POST['Atanan_Kullanici'];
                    $Durum = $_POST['Durum'];
                    $Gorev_Tarihi = $_POST['Gorev_Tarihi'];
        
                    $sql = "UPDATE Gorevler SET ProjeID='$ProjeID', Gorev_Baslıgı='$Gorev_Basligi', Aciklama='$Aciklama', Atanan_Kullanici='$Atanan_Kullanici', Durum='$Durum', Gorev_Tarihi = '$Gorev_Tarihi'  WHERE ID=$ID";
                    $sonuc = mysqli_query($baglanti, $sql);
        
                    if ($sonuc) {
                        header("Location: gorev_listele.php");
                        exit;
                    } else {
                        $hata = mysqli_error($baglanti);
                        echo "Görev güncellenirken bir hata oluştu: $hata";
                    }
                }
            }
                mysqli_close($baglanti);
                ?>
            </table>
        </body>
        </html>
        