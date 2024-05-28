<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seçenekler</title>
  <style>
    body {
      background: linear-gradient(to right, #864BA2, #BF3A30);
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-family: Arial;
    }

    p {
      background-color: #6617CB ;
      border-radius: 5px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      color: white;
    }

    .links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    a {
      text-decoration: none;
      color: #6617CB;
      font-weight: bold;
      font-size: 18px;
      margin: 10px;
      padding: 15px 30px;
      border-radius: 15px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    a:hover {
      color: #CB218E;
      background-color: #fff;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <p>Seçenekler</p>
  <div class="links">
    <a href="proje_ekle.php">Proje Ekleme Ekranı</a>
    <a href="proje_listele.php">Proje Listeleme Ekranı</a>
    <a href="gorev_ekle.php">Görev Ekleme Ekranı</a>
    <a href="gorev_listele.php">Görev Listeleme Ekranı</a>
    <a href="test_ekle.php">Test Ekleme Ekranı</a>
    <a href="test_listele.php">Test Listeleme Ekranı</a>
    <a href="belge_ekle.php">Belge Ekleme Ekranı</a>
    <a href="belge_listele.php">Belge Listeleme Ekranı</a>
    <a href="isbirlikleri_ekle.php">İş Birlikleri Ekleme Ekranı</a>
    <a href="isbirlikleri_listele.php">İş Birlikleri Listeleme Ekranı</a>
    <a href="anasayfa.php">Oturumu Kapat</a>
  </div>
</body>
</html>
