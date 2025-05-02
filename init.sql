-- Membuat user baru
CREATE USER IF NOT EXISTS 'eokpaleto'@'%' IDENTIFIED BY 'Unsri2022';

-- Memberikan semua hak akses ke semua database
GRANT ALL PRIVILEGES ON *.* TO 'eokpaleto'@'%' WITH GRANT OPTION;

-- Menyegarkan privilege
FLUSH PRIVILEGES;
