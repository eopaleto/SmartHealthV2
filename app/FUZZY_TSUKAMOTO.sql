DELIMITER $$

CREATE TRIGGER update_kondisi_jantung
BEFORE INSERT ON db_jantung
FOR EACH ROW
BEGIN
    DECLARE umur_pasien INT;  -- Semicolon added here
    DECLARE kategori VARCHAR(20);
    DECLARE pelan, normal, cepat, rendah, tinggi DECIMAL(5,2);
    DECLARE z_pelan_rendah, z_pelan_tinggi DECIMAL(5,2);
    DECLARE z_normal_rendah, z_normal_tinggi DECIMAL(5,2);
    DECLARE z_cepat_rendah, z_cepat_tinggi DECIMAL(5,2);
    DECLARE z_total, sum_weights, z_crips DECIMAL(5,2);

    -- Ambil nilai Umur dari tabel users berdasarkan ID pasien
    SELECT umur INTO umur_pasien FROM users WHERE id = NEW.id_pasien;

    -- Menentukan kategori umur
    IF umur_pasien < 2 THEN
        SET kategori = 'BAYI';
        SET NEW.Kategori = 'BAYI';
    ELSEIF umur_pasien BETWEEN 2 AND 15 THEN
        SET kategori = 'ANAK';
        SET NEW.Kategori = 'ANAK';
    ELSEIF umur_pasien BETWEEN 15 AND 100 THEN
        SET kategori = 'DEWASA';
        SET NEW.Kategori = 'DEWASA';
    END IF;

    -- Fuzzifikasi Detak Jantung
    -- Bayi (0 - 2 tahun)
    IF kategori = 'BAYI' THEN
        SET pelan = CASE 
            WHEN NEW.DetakJantung <= 80 THEN 1
            WHEN NEW.DetakJantung > 80 AND NEW.DetakJantung < 85 THEN (85 - NEW.DetakJantung) / 5
            ELSE 0
        END;
        
        SET normal = CASE
            WHEN NEW.DetakJantung > 80 AND NEW.DetakJantung <= 85 THEN (NEW.DetakJantung - 80) / 5
            WHEN NEW.DetakJantung > 85 AND NEW.DetakJantung <= 120 THEN 1
            WHEN NEW.DetakJantung > 120 AND NEW.DetakJantung < 140 THEN (140 - NEW.DetakJantung) / 20
            ELSE 0
        END;
        
        SET cepat = CASE
            WHEN NEW.DetakJantung >= 120 AND NEW.DetakJantung <= 140 THEN (NEW.DetakJantung - 120) / 20
            WHEN NEW.DetakJantung > 140 THEN 1
            ELSE 0
        END;
    -- Anak (2 - 15 tahun)
    ELSEIF kategori = 'ANAK' THEN
        SET pelan = CASE 
            WHEN NEW.DetakJantung <= 70 THEN 1
            WHEN NEW.DetakJantung > 70 AND NEW.DetakJantung < 75 THEN (75 - NEW.DetakJantung) / 5
            ELSE 0
        END;
        
        SET normal = CASE
            WHEN NEW.DetakJantung > 70 AND NEW.DetakJantung <= 75 THEN (NEW.DetakJantung - 70) / 5
            WHEN NEW.DetakJantung > 75 AND NEW.DetakJantung <= 95 THEN 1
            WHEN NEW.DetakJantung > 95 AND NEW.DetakJantung < 110 THEN (110 - NEW.DetakJantung) / 15
            ELSE 0
        END;
        
        SET cepat = CASE
            WHEN NEW.DetakJantung >= 95 AND NEW.DetakJantung <= 110 THEN (NEW.DetakJantung - 95) / 15
            WHEN NEW.DetakJantung > 110 THEN 1
            ELSE 0
        END;
    -- Dewasa (15 - 100 tahun)
    ELSEIF kategori = 'DEWASA' THEN
        SET pelan = CASE 
            WHEN NEW.DetakJantung <= 60 THEN 1
            WHEN NEW.DetakJantung > 60 AND NEW.DetakJantung < 65 THEN (65 - NEW.DetakJantung) / 5
            ELSE 0
        END;
        
        SET normal = CASE
            WHEN NEW.DetakJantung > 60 AND NEW.DetakJantung <= 65 THEN (NEW.DetakJantung - 60) / 5
            WHEN NEW.DetakJantung > 65 AND NEW.DetakJantung <= 90 THEN 1
            WHEN NEW.DetakJantung > 90 AND NEW.DetakJantung < 100 THEN (100 - NEW.DetakJantung) / 10
            ELSE 0
        END;
        
        SET cepat = CASE
            WHEN NEW.DetakJantung >= 90 AND NEW.DetakJantung <= 100 THEN (NEW.DetakJantung - 90) / 10
            WHEN NEW.DetakJantung > 100 THEN 1
            ELSE 0
        END;
    END IF;

    -- Fuzzifikasi Saturasi Oksigen
    SET rendah = CASE
        WHEN NEW.SaturasiOksigen < 95 THEN 1
        ELSE 0
    END;

    SET tinggi = CASE
        WHEN NEW.SaturasiOksigen >= 95 AND NEW.SaturasiOksigen <= 100 THEN 1
        ELSE 0
    END;

    -- Implementasi Aturan Tsukamoto dan perhitungan z (nilai keluaran)
    SET z_pelan_rendah = LEAST(pelan, rendah) * 30; -- 'Tidak Normal'
    SET z_pelan_tinggi = LEAST(pelan, tinggi) * 30; -- 'Tidak Normal'
    SET z_normal_rendah = LEAST(normal, rendah) * 50; -- 'Kurang Normal'
    SET z_normal_tinggi = LEAST(normal, tinggi) * 70; -- 'Normal'
    SET z_cepat_rendah = LEAST(cepat, rendah) * 70; -- 'Normal'
    SET z_cepat_tinggi = LEAST(cepat, tinggi) * 70; -- 'Normal'

    -- Hitung total z dan sum_weights
    SET z_total = z_pelan_rendah + z_pelan_tinggi +
                  z_normal_rendah + z_normal_tinggi +
                  z_cepat_rendah + z_cepat_tinggi;

    SET sum_weights = (LEAST(pelan, rendah) + LEAST(pelan, tinggi) +
                       LEAST(normal, rendah) + LEAST(normal, tinggi) +
                       LEAST(cepat, rendah) + LEAST(cepat, tinggi));

    -- Defuzzifikasi menggunakan rata-rata berbobot
    IF sum_weights > 0 THEN
        SET z_crips = z_total / sum_weights;
    ELSE
        SET z_crips = 0; -- Default jika tidak ada keanggotaan
    END IF;
    
    -- Simpan hasil defuzzifikasi
    SET NEW.z_crips = z_crips;

    -- Kategorisasi hasil defuzzifikasi
    IF z_crips < 40 THEN
        SET NEW.KondisiJantung = 'TIDAK NORMAL';
    ELSEIF z_crips BETWEEN 40 AND 60 THEN
        SET NEW.KondisiJantung = 'KURANG NORMAL';
    ELSE
        SET NEW.KondisiJantung = 'NORMAL';
    END IF;
END$$

DELIMITER ;