CREATE TABLE `Kullanicilar`(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Kullanici_Adi VARCHAR(255) UNIQUE NOT NULL,
    Ad VARCHAR(100) NOT NULL,
    Soyad VARCHAR(100) NOT NULL,
    Eposta VARCHAR(155) NOT NULL,
    Sifre VARCHAR(255) NOT NULL
);

CREATE TABLE `Projeler`(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Proje_Adi VARCHAR(100),
    Proje_Tanimi TEXT,
    Durum VARCHAR(50),
    Olusturulma_Tarihi DATE
);

CREATE TABLE `Gorevler`(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProjeID INT,
    Gorev_Baslıgı VARCHAR(100) NOT NULL,
    Aciklama TEXT,
    Atanan_Kullanici INT,
    Durum VARCHAR(50),
    Gorev_Tarihi DATE,
    FOREIGN KEY (ProjeID) REFERENCES Projeler(ID),
    FOREIGN KEY (Atanan_Kullanici) REFERENCES Kullanicilar(ID)
);

CREATE TABLE `Testler`(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProjeID INT,
    Test_Adi VARCHAR(100) NOT NULL,
    Degerlendirme TEXT,
    Sonuc VARCHAR(100),
    Test_Tarihi DATE,
    FOREIGN KEY (ProjeID) REFERENCES Projeler(ID)
);

CREATE TABLE `Belgeler` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProjeID INT,
    Dosya_Adi VARCHAR(255) NOT NULL,
    Dosya_Yolu VARCHAR(255) NOT NULL,
    Yukleyen_Kullanici INT,
    Yuklenme_Tarihi DATE,  
    FOREIGN KEY (ProjeID) REFERENCES Projeler(ID),
    FOREIGN KEY (Yukleyen_Kullanici) REFERENCES Kullanicilar(ID)
);

CREATE TABLE `Isbirlikleri` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ProjeID INT,
    KatilimciID INT,
    Rol VARCHAR(100),
    Katilim_Tarihi DATE,
    FOREIGN KEY (ProjeID) REFERENCES Projeler(ID),
    FOREIGN KEY (KatilimciID) REFERENCES Kullanicilar(ID)
);