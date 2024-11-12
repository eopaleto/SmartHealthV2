CREATE TRIGGER update_kondisi_jantung
BEFORE INSERT ON db_jantung
FOR EACH ROW
BEGIN
    DECLARE umur_pasien INT;
    DECLARE umur_kategori INT;
    DECLARE detak_jantung_kategori INT;
    DECLARE saturasi_oksigen_kategori INT;

    -- Ambil nilai Umur dari tabel daftarpasien berdasarkan ID pasien
    SELECT umur INTO umur_pasien FROM users WHERE id = NEW.id_pasien;

    -- Menentukan kategori umur
    IF umur_pasien < 2 THEN
        SET umur_kategori = 'BAYI';
    ELSEIF umur_pasien BETWEEN 0 AND 15 THEN
        SET umur_kategori = 'ANAK';
    ELSEIF umur_pasien BETWEEN 13 AND 101 THEN
        SET umur_kategori = 'DEWASA';
    END IF;

    -- Menentukan kategori detak jantung
    IF NEW.DetakJantung BETWEEN 0 AND 61 THEN
        SET detak_jantung_kategori = 'BRADIKARDIA';
    ELSEIF NEW.DetakJantung BETWEEN 49 AND 111 THEN
        SET detak_jantung_kategori = 'NORMAL1';
    ELSEIF NEW.DetakJantung BETWEEN 99 AND 151 THEN
        SET detak_jantung_kategori = 'TAKIKARDIA';
    END IF;

    -- Menentukan kategori saturasi oksigen
    IF NEW.SaturasiOksigen BETWEEN 0 AND 96 THEN
        SET saturasi_oksigen_kategori = 'TIDAK NORMAL';
    ELSEIF NEW.SaturasiOksigen BETWEEN 94 AND 101 THEN
        SET saturasi_oksigen_kategori = 'NORMAL';
    END IF;

    -- Menentukan kondisi jantung berdasarkan kategori
    CASE
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'BAYI' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'ANAK' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'BRADIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'NORMAL1' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'TIDAK NORMAL' THEN
            SET NEW.KondisiJantung = 'TIDAK SEHAT';
        WHEN umur_kategori = 'DEWASA' AND detak_jantung_kategori = 'TAKIKARDIA' AND saturasi_oksigen_kategori = 'NORMAL' THEN
            SET NEW.KondisiJantung = 'KURANG SEHAT';
        ELSE
            SET NEW.KondisiJantung = 'TIDAK DIKETAHUI';
    END CASE;
END;