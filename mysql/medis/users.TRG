TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`%` TRIGGER `generate_random_password` BEFORE INSERT ON `users` FOR EACH ROW BEGIN\n    SET NEW.password = SUBSTRING(MD5(RAND()), 1, 8); -- Menghasilkan password acak sepanjang 8 karakter\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER `generate_random_password_on_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN\n    SET NEW.password = SUBSTRING(MD5(RAND()), 1, 8); -- Menghasilkan password acak sepanjang 8 karakter\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER `update_umur_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN\n    DECLARE umur INT;\n\n    IF NEW.tgl_lahir IS NOT NULL THEN\n        SET umur = TIMESTAMPDIFF(YEAR, NEW.tgl_lahir, CURDATE());\n    ELSE\n        SET umur = NULL; -- Jika tgl_lahir NULL, set umur menjadi NULL\n    END IF;\n\n    SET NEW.umur = umur; -- Mengatur nilai umur yang baru\nEND'
sql_modes=524288 524288 524288
definers='root@%' 'root@%' 'root@%'
client_cs_names='utf8mb4' 'utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_uca1400_ai_ci' 'utf8mb4_uca1400_ai_ci' 'utf8mb4_uca1400_ai_ci'
db_cl_names='utf8mb4_uca1400_ai_ci' 'utf8mb4_uca1400_ai_ci' 'utf8mb4_uca1400_ai_ci'
created=1730879689228320 1730879689241613 1730879689265090
