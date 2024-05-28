<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oturum Açma</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #9AB5E1, #F39FDC);
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
      margin-bottom: 30px;
      font-family: Arial Black;
    }

    .btn-primary {
      background: linear-gradient(to right, #CB218E, #6617CB);
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
            <h3 class="card-title text-center">OTURUM AÇ</h3>
            <form action="oturum_ac.php" method="POST">
              <div class="form-group">
                <label for="Kullanici_Adi">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="Kullanici_Adi" name="Kullanici_Adi" required>
              </div>
              <div class="form-group">
                <label for="Sifre">Şifre</label>
                <input type="password" class="form-control" id="Sifre" name="Sifre" required><br>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="giris">GİRİŞ</button>
            </form>
            <div class="return-link">
              <a href="index.php">Anasayfaya Dön</a>

            </div>
            <?php
            if (isset($_POST['giris'])) {
                $Kullanici_Adi = $_POST['Kullanici_Adi'];
                $Sifre = $_POST['Sifre'];

                include("mysqlibaglan.php");
                $sql = "SELECT * FROM Kullanicilar WHERE Kullanici_Adi = '$Kullanici_Adi'";
                $sonuc = mysqli_query($baglanti, $sql);

                if (mysqli_num_rows($sonuc) == 1) {
                    $satir = mysqli_fetch_assoc($sonuc);
                    if (password_verify($Sifre, $satir['Sifre'])) {
                        session_start();
                        $_SESSION['ID'] = $satir['ID'];
                        $_SESSION['Kullanici_Adi'] = $satir['Kullanici_Adi'];
                        $_SESSION['Ad'] = $satir['Ad'];
                        $_SESSION['Soyad'] = $satir['Soyad'];
                        $_SESSION['Eposta'] = $satir['Eposta'];

                        header("Location: sayfa2.php");
                        exit();
                    } else {
                        echo "<div class='hata_mesaji'>Kullanıcı adı veya şifre hatalı.</div>";
                    }
                } else {
                    echo "<div class='hata_mesaji'>Kullanıcı adı veya şifre hatalı.</div>";
                }

                mysqli_close($baglanti);
            }
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





