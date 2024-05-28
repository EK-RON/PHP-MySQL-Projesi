<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kayıt Ol</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #FA9E8C, #FFE190);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial;
    }

    .card {
        
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      margin-top: 10px;
      font-family: Arial Black;
    }

    .btn-primary {
      background: linear-gradient(to right, #F42B03, #FFBE0B);
      border: 2px;
      border-radius: 24px;
      color: white;
      font-family: Arial;
      font-weight: 1000;
    }

    .return-link {
      text-align: center;
      margin-top: 20px;
    }

    .hata_mesaji {
      color: #E01C34;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-body">
            <h3 class="card-title text-center">KAYIT OL</h3>
            <form action="register.php" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Kullanici_Adi">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="Kullanici_Adi" name="Kullanici_Adi" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Ad">Ad</label>
                    <input type="text" class="form-control" id="Ad" name="Ad" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Soyad">Soyad</label>
                    <input type="text" class="form-control" id="Soyad" name="Soyad" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Eposta">Eposta</label>
                    <input type="email" class="form-control" id="Eposta" name="Eposta" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="Sifre">Şifre</label>
                <input type="password" class="form-control" id="Sifre" name="Sifre" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="kayit">KAYDET</button>
            </form>
            <div class="return-link">
              <a href="index.php">Anasayfaya Dön</a>
            </div>
            <?php
include("mysqlibaglan.php");

if (isset($_POST['kayit'])) {
    $Kullanici_Adi = $_POST['Kullanici_Adi'];
    $Ad = $_POST['Ad'];
    $Soyad = $_POST['Soyad'];
    $Eposta = $_POST['Eposta'];
    $Sifre = password_hash($_POST['Sifre'], PASSWORD_BCRYPT);

    // Kullanıcı adının ve e-posta adresinin benzersiz olduğunu kontrol et
    $kontroll_sql = "SELECT * FROM Kullanicilar WHERE Kullanici_Adi = '$Kullanici_Adi' OR Eposta = '$Eposta'";
    $sonuc_kontrol = mysqli_query($baglanti, $kontroll_sql);

    if (mysqli_num_rows($sonuc_kontrol) > 0) {
        echo "<div class='hata_mesaji'>Kullanıcı adı veya e-posta adresi zaten kullanılıyor.</div>";
    } else {
        $sql = "INSERT INTO Kullanicilar (Kullanici_Adi, Ad, Soyad, Eposta, Sifre)
                VALUES ('$Kullanici_Adi', '$Ad', '$Soyad','$Eposta',  '$Sifre')";
                if (mysqli_query($baglanti, $sql)) {
                    echo "<div class='hata_mesaji'>Kayıt başarıyla oluşturuldu.</div>";
                    
                } else {
                    echo "<div class='hata_mesaji'>Hata: " . mysqli_error($baglanti) . "</div>";
                }
            }
        }
        mysqli_close($baglanti);
        ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
