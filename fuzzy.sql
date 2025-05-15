DELIMITER $$

CREATE TRIGGER fuzzy_trigger
BEFORE UPDATE ON db_jantung
FOR EACH ROW
BEGIN
  DECLARE umur_pasien INT;
  DECLARE μ_umur_bayi, μ_umur_anak, μ_umur_dewasa DOUBLE;
  DECLARE μ_dj_pelan, μ_dj_normal, μ_dj_cepat DOUBLE;
  DECLARE μ_so_rendah, μ_so_normal DOUBLE;
  DECLARE α, z, sum_α_z, sum_α DOUBLE;
  DECLARE i INT;

  SELECT umur INTO umur_pasien FROM users WHERE id = NEW.id_pasien;

  -- Fuzzyfikasi Umur
  IF umur_pasien <= 1 THEN
    SET μ_umur_bayi = 1;
  ELSEIF umur_pasien > 1 AND umur_pasien < 2 THEN
    SET μ_umur_bayi = (2 - umur_pasien) / 1;
  ELSE
    SET μ_umur_bayi = 0;
  END IF;

  IF umur_pasien > 1 AND umur_pasien <= 2 THEN
    SET μ_umur_anak = (umur_pasien - 1) / 1;
  ELSEIF umur_pasien > 2 AND umur_pasien <= 15 THEN
    SET μ_umur_anak = (15 - umur_pasien) / 13;
  ELSE
    SET μ_umur_anak = 0;
  END IF;

  IF umur_pasien >= 15 THEN
    SET μ_umur_dewasa = 1;
  ELSEIF umur_pasien >= 2 AND umur_pasien < 15 THEN
    SET μ_umur_dewasa = (umur_pasien - 2) / 13;
  ELSE
    SET μ_umur_dewasa = 0;
  END IF;
  
  -- Tentukan kategori umur berdasarkan nilai keanggotaan tertinggi
    IF μ_umur_bayi >= μ_umur_anak AND μ_umur_bayi >= μ_umur_dewasa THEN
      SET NEW.Kategori = 'BAYI';
    ELSEIF μ_umur_anak >= μ_umur_bayi AND μ_umur_anak >= μ_umur_dewasa THEN
      SET NEW.Kategori = 'ANAK';
    ELSE
      SET NEW.Kategori = 'DEWASA';
    END IF;

  -- Fuzzyfikasi Detak Jantung
  IF NEW.DetakJantung <= 55 THEN
    SET μ_dj_pelan = 1;
  ELSEIF NEW.DetakJantung > 55 AND NEW.DetakJantung < 60 THEN
    SET μ_dj_pelan = (60 - NEW.DetakJantung) / 5;
  ELSE
    SET μ_dj_pelan = 0;
  END IF;

  IF NEW.DetakJantung >= 55 AND NEW.DetakJantung <= 60 THEN
    SET μ_dj_normal = (NEW.DetakJantung - 55) / 5;
  ELSEIF NEW.DetakJantung > 60 AND NEW.DetakJantung <= 100 THEN
    SET μ_dj_normal = (100 - NEW.DetakJantung) / 40;
  ELSE
    SET μ_dj_normal = 0;
  END IF;

  IF NEW.DetakJantung >= 100 THEN
    SET μ_dj_cepat = 1;
  ELSEIF NEW.DetakJantung >= 60 AND NEW.DetakJantung < 100 THEN
    SET μ_dj_cepat = (NEW.DetakJantung - 60) / 40;
  ELSE
    SET μ_dj_cepat = 0;
  END IF;

  -- Fuzzyfikasi Saturasi Oksigen
  IF NEW.SaturasiOksigen <= 90 THEN
    SET μ_so_rendah = 1;
  ELSEIF NEW.SaturasiOksigen > 90 AND NEW.SaturasiOksigen < 95 THEN
    SET μ_so_rendah = (95 - NEW.SaturasiOksigen) / 5;
  ELSE
    SET μ_so_rendah = 0;
  END IF;

  IF NEW.SaturasiOksigen >= 95 THEN
    SET μ_so_normal = 1;
  ELSEIF NEW.SaturasiOksigen >= 90 AND NEW.SaturasiOksigen < 95 THEN
    SET μ_so_normal = (NEW.SaturasiOksigen - 90) / 5;
  ELSE
    SET μ_so_normal = 0;
  END IF;

  -- Inisialisasi defuzzifikasi
  SET sum_α = 0;
  SET sum_α_z = 0;

  -- Rule 1: Bayi, Pelan, Rendah → Tidak Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_pelan, μ_so_rendah);
    SET z = 60 - (60 * α);
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 2: Bayi, Pelan, Normal → Kurang Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_pelan, μ_so_normal);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 3: Bayi, Normal, Rendah → Kurang Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_normal, μ_so_rendah);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 4: Bayi, Normal, Normal → Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_normal, μ_so_normal);
    SET z = 40 * α + 60;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 5: Bayi, Cepat, Rendah → Tidak Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_cepat, μ_so_rendah);
    SET z = 60 - (60 * α);
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 6: Bayi, Cepat, Normal → Kurang Normal
    SET α = LEAST(μ_umur_bayi, μ_dj_cepat, μ_so_normal);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 7: Anak, Pelan, Rendah → Tidak Normal
    SET α = LEAST(μ_umur_anak, μ_dj_pelan, μ_so_rendah);
    SET z = 60 - (60 * α);
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 8: Anak, Pelan, Normal → Kurang Normal
    SET α = LEAST(μ_umur_anak, μ_dj_pelan, μ_so_normal);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 9: Anak, Normal, Rendah → Kurang Normal
    SET α = LEAST(μ_umur_anak, μ_dj_normal, μ_so_rendah);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 10: Anak, Normal, Normal → Normal
    SET α = LEAST(μ_umur_anak, μ_dj_normal, μ_so_normal);
    SET z = 40 * α + 60;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 11: Anak, Cepat, Rendah → Kurang Normal
    SET α = LEAST(μ_umur_anak, μ_dj_cepat, μ_so_rendah);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 12: Anak, Cepat, Normal → Normal
    SET α = LEAST(μ_umur_anak, μ_dj_cepat, μ_so_normal);
    SET z = 40 * α + 60;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 13: Dewasa, Pelan, Rendah → Tidak Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_pelan, μ_so_rendah);
    SET z = 60 - (60 * α);
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 14: Dewasa, Pelan, Normal → Kurang Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_pelan, μ_so_normal);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 15: Dewasa, Normal, Rendah → Kurang Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_normal, μ_so_rendah);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 16: Dewasa, Normal, Normal → Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_normal, μ_so_normal);
    SET z = 40 * α + 60;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 17: Dewasa, Cepat, Rendah → Kurang Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_cepat, μ_so_rendah);
    SET z = 15 * α + 55;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Rule 18: Dewasa, Cepat, Normal → Normal
    SET α = LEAST(μ_umur_dewasa, μ_dj_cepat, μ_so_normal);
    SET z = 40 * α + 60;
    SET sum_α_z = sum_α_z + α * z;
    SET sum_α = sum_α + α;

  -- Defuzzifikasi
  IF sum_α > 0 THEN
    SET NEW.z_crips = sum_α_z / sum_α;
  ELSE
    SET NEW.z_crips = 0;
  END IF;

  -- Penentuan kondisi kesehatan berdasarkan z_crips
  IF NEW.z_crips <= 60 THEN
    SET NEW.KondisiJantung = 'Tidak Normal';
  ELSEIF NEW.z_crips > 60 AND NEW.z_crips <= 70 THEN
    SET NEW.KondisiJantung = 'Kurang Normal';
  ELSE
    SET NEW.KondisiJantung = 'Normal';
  END IF;

END$$

DELIMITER ;
