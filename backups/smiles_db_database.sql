

CREATE TABLE `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO about VALUES("1","Conozca más sobre Rehabilitación A.M.P","1705500138.png","<p _mstvisible="11"><span style="color: rgb(55, 65, 81); font-family: Söhne, ui-sans-serif, system-ui, -apple-system, &quot;Segoe UI&quot;, Roboto, Ubuntu, Cantarell, &quot;Noto Sans&quot;, sans-serif, &quot;Helvetica Neue&quot;, Arial, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; white-space-collapse: preserve;" _msttexthash="60681257" _msthash="412">En <span style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, sans-serif; white-space-collapse: collapse; background-color: rgb(25, 119, 204);">Rehabilitación&nbsp;</span>A.M.P, nos enorgullece ser líderes en el campo de la fisioterapia, brindando cuidados excepcionales que transforman vidas. Nuestra clínica está comprometida con ofrecer servicios de fisioterapia de primera clase, diseñados para abordar tus necesidades específicas y ayudarte a alcanzar tus metas de bienestar físico.</span><br _mstvisible="12"></p>");



CREATE TABLE `dental_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `dentist` varchar(255) NOT NULL,
  `visit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dh_patient_id_foreign` (`patient_id`),
  CONSTRAINT `dh_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO dental_history VALUES("46","253","aa","aaa");



CREATE TABLE `featured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dentist_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO featured VALUES("24","184","sssssssssaaa","1707371320.jpg");



CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO gallery VALUES("23","1658238779.jpg","Active");
INSERT INTO gallery VALUES("24","1658238787.jpg","Active");
INSERT INTO gallery VALUES("25","1658238848.jpg","Active");
INSERT INTO gallery VALUES("26","1658238870.jpg","Active");



CREATE TABLE `header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO header VALUES("1","¡Descubre los beneficios revitalizantes ","En nuestro centro de fisioterapia de vanguardia, te ofrecemos una experiencia única donde podrás experimentar los cuidados más avanzados y personalizados para tu bienestar físico. Nuestro equipo de fisioterapeutas altamente capacitados está comprometido con proporcionar un servicio excepcional que va más allá de tus expectativas.","1705499976.png");



CREATE TABLE `health_declaration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `answer` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hd_patient_id_foreign` (`patient_id`),
  KEY `hd_q_id_foreign` (`question_id`),
  CONSTRAINT `hd_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hd_q_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2966 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `mail_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO mail_settings VALUES("1","smtp.gmail.com","pippoesthetique@gmail.com","vcxekdhkksqpbpkp","2023-01-04 23:21:17");



CREATE TABLE `medical_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `q1` varchar(255) NOT NULL,
  `q2` varchar(255) NOT NULL,
  `q3` varchar(255) NOT NULL,
  `q4` varchar(255) NOT NULL,
  `q5` varchar(255) NOT NULL,
  `allergy` varchar(255) NOT NULL,
  `med` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mr_patient_id_foreign` (`patient_id`),
  CONSTRAINT `mr_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO medical_record VALUES("19","253","a","a","a","a","a","a","Infección por VIH o SIDA,Ataque de desmayo,Pérdida de peso rápida,Asma,Cáncer/Tumores,Ninguna,Ataque al corazón,Enfermedad cardíaca,Hepatitis,Tuberculosis,Enfermedad renal,Accidente cerebrovascular,Anemia","2024-02-17 09:38:56");



CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `doc_id` bigint(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `seen_status` int(1) NOT NULL COMMENT '0=not seen, 1=seen',
  `type` int(1) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notif_patient_id_foreign` (`patient_id`),
  KEY `notif_doc_id_foreign` (`doc_id`),
  CONSTRAINT `notif_doc_id_foreign` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notif_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=616 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO notification VALUES("607","253","184","Confirmed your Appointment","1","1","2024-02-17 09:40:23");
INSERT INTO notification VALUES("609","253","184","Confirmed your Appointment","1","1","2024-02-17 21:43:43");



CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_email` varchar(150) NOT NULL,
  `success` varchar(150) NOT NULL,
  `cancel` varchar(150) NOT NULL,
  `ipn` varchar(150) NOT NULL,
  `fee` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO payment_settings VALUES("1","sb-aeq8l22251756@business.example.com","https://localhost/PatientsManagementSystem/patient/return.php","https://localhost/PatientsManagementSystem/patient/cancel.php","https://localhost/PatientsManagementSystem/patient/notify.php","0.00");



CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `app_id` bigint(20) NOT NULL,
  `payer_id` varchar(50) NOT NULL,
  `ref_id` varchar(255) NOT NULL,
  `payment_status` varchar(500) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `payer_email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `method` varchar(20) NOT NULL DEFAULT 'Paypal',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO payments VALUES("500","500","0","0","02ASDW2AS5D","0","25.00","0","000","","","","Efectivo","2024-02-18 12:03:11");
INSERT INTO payments VALUES("501","500","0","0","02ASDW2AS5D","0","222.00","0","qweqwe","","","","Efectivo","2024-02-18 12:04:42");
INSERT INTO payments VALUES("502","501","0","0","01aASA","0","20.00","0","000555","","","","Efectivo","2024-02-18 12:53:42");
INSERT INTO payments VALUES("503","500","0","0","555555","0","55.00","0","5555","","","","Efectivo","2024-02-18 16:58:46");
INSERT INTO payments VALUES("504","501","0","0","66666","0","48.00","0","99999999","","","","Tarjeta de Crédito","2024-02-18 16:59:15");
INSERT INTO payments VALUES("505","503","0","0","015522","0","25.00","0","00225222","","","","Efectivo","2024-02-23 11:45:08");



CREATE TABLE `payments1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `app_id` bigint(20) DEFAULT NULL,
  `payer_id` varchar(50) DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `txn_id` varchar(50) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `method` varchar(20) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO payments1 VALUES("1","492","1","1","1222aasda","1","12.00","0","12321sdadaw","","","","Bank Transfer","2024-02-16 00:43:32");
INSERT INTO payments1 VALUES("2","492","1","1","asda","1","3.00","0","asdad3dasd3","","","","Credit Card","2024-02-16 01:59:07");
INSERT INTO payments1 VALUES("3","493","1","1","123456","1","333.00","0","123456","","","","Cash","2024-02-16 02:00:16");
INSERT INTO payments1 VALUES("4","496","0","0","asdwed","0","0.00","0","aa","","","","Tarjeta de Crédito","2024-02-16 16:29:13");



CREATE TABLE `prescription` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `doc_id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `medicine` varchar(255) NOT NULL,
  `dose` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `advice` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `prescription_doc_id_foreign` (`doc_id`),
  KEY `prescription_patient_id_foreign` (`patient_id`),
  CONSTRAINT `prescription_doc_id_foreign` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prescription_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `procedures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `procedures` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `procedures_service_id_foreign` (`service_id`),
  CONSTRAINT `procedures_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO procedures VALUES("40","33","aaaa","111");
INSERT INTO procedures VALUES("41","31","qqqqqqqq","11");
INSERT INTO procedures VALUES("42","31","qqqqqqqq","11");



CREATE TABLE `questionnaires` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `questions` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `review` longtext NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO reviews VALUES("24","NAOMY CANGAS","cdx","aaaa","Active","1709047903.jpg");
INSERT INTO reviews VALUES("25","Brayan Marcelo Marcelo Cangas Vasquez","aaa","aaaa","Active","1709048030.png");
INSERT INTO reviews VALUES("26","aaa","aaa","aaaa","Active","1709048059.jpg");



CREATE TABLE `schedule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `doc_id` bigint(20) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `day` varchar(800) NOT NULL,
  `starttime` varchar(255) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sched_doc_id_foreign` (`doc_id`),
  CONSTRAINT `sched_doc_id_foreign` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO schedule VALUES("133","184","Andres David","2024-02-04","5:18 AM","5:18 PM","30");
INSERT INTO schedule VALUES("134","184","Andres David","2024-02-28","5:56 AM","5:56 PM","80");



CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO services VALUES("31","aaccccccc","aaaaccccc","<p><span style="font-family: &quot;Open Sans&quot;;">﻿aaaaacccccccccc c cc c</span><br></p>","1707368296.jpg");
INSERT INTO services VALUES("33","ccccccccccc","cccccccc","<p><span style="font-family: &quot;Open Sans&quot;;">﻿cccccccccc</span><br></p>","1707368311.png");



CREATE TABLE `sms_settings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sms_settings VALUES("1","AC207b92a25eacf14eb55fead371a87e56","2dcaa6abb9b636e7d05f399b138f72b7","+12136872043");



CREATE TABLE `system_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `days` varchar(255) NOT NULL,
  `openhr` varchar(50) NOT NULL,
  `closehr` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `telno` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `map` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO system_details VALUES("1","Rehabilitación -A.M.P","1,2,3,4,5,6","8:00 AM","6:00 PM","Babahoyo","+593969950554","david@gmail.com","+593969950554","https://www.facebook.com/ConsultorioFisioterapiaAMP?mibextid=ZbWKwL","https://www.openstreetmap.org/export/embed.html?bbox=-79.54033702611923%2C-1.8040506609497824%2C-79.53795522451402%2C-1.8022088957712226&layer=mapnik&marker=-1.8031309848646855%2C-79.53914612531662","1705500694.png","1705500694.png");



CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `verify_status` tinyint(2) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbladmin VALUES("52","admin","Sequi eum quia ducim","+593999999999","admin@gmail.com","1678435022.png","$2y$10$ovSBMnrKAE/MENpdZpVMe.Xf/qeZeldHbdL5NP.10gNwe/rtmMJgi","admin","1","","1","2022-11-02 05:49:00");
INSERT INTO tbladmin VALUES("53","Brayan Marcelo Marcelo Cangas Vasquez","pasaje Av.Otto Arocemena Gomez","+593994419412","brayanmisaki@gmail.com","1709046490.jpg","$2y$10$XgKCTmjvdUDMcS675/CZOeq.pPWmgJ1HyA3Ku3bjy4uOmCWNiC0zG","admin","1","","1","2024-01-19 04:11:55");



CREATE TABLE `tblappointment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `doc_id` bigint(20) NOT NULL,
  `schedule` varchar(191) NOT NULL,
  `starttime` varchar(191) NOT NULL,
  `endtime` varchar(191) NOT NULL,
  `sched_id` bigint(20) NOT NULL,
  `schedtype` varchar(191) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `seen_status` int(1) NOT NULL,
  `status` varchar(100) NOT NULL,
  `payment` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Unfinished,1=Finish',
  `payment_option` varchar(255) NOT NULL,
  `bgcolor` varchar(7) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id_foreign` (`patient_id`),
  KEY `app_sched_id_foreign` (`sched_id`),
  KEY `app_doc_id_foreign` (`doc_id`),
  CONSTRAINT `app_doc_id_foreign` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `app_sched_id_foreign` FOREIGN KEY (`sched_id`) REFERENCES `schedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=505 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblappointment VALUES("504","253","NAOMY CANGAS","184","2024-02-28","05:56 AM","07:16 AM","134","Walk-in Schedule","qqqqqqqq,qqqqqqqq","0","Treated","0","","#FF8C00","2024-02-27 12:56:16");



CREATE TABLE `tbldoctor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(191) NOT NULL DEFAULT '2',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '0=inactive,1=active',
  `verify_token` varchar(255) NOT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes	',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbldoctor VALUES("184","Andres David","14/05/1998","Prueba de direccion","Masculino","0994419413","doctor@gmail.com","Lc","Fisioterapeuta","1708296715.png","$2y$10$IzypaA2rpDTuCi64thIAH.39jDyr7ceFQt/RWCHXDz1OEHkjcJtLC","2","1","","1","2024-01-19 04:36:19");



CREATE TABLE `tblpatient` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(191) NOT NULL,
  `address` varchar(100) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(191) NOT NULL DEFAULT 'patient',
  `verify_token` varchar(191) NOT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tblpatient VALUES("253","NAOMY","CANGAS","pasaje Av.Otto Arocemena Gomez","06/06/2001","Femenino","3994419415","naomy@gmail.com","1709045617.jpg","$2y$10$V.pDoxVx3fhXa5jiKXcjMuCDZ8deUgqCJ03784l.Kt.IZWrWHEaDC","patient","","1","2024-02-15 22:16:30");



CREATE TABLE `tblstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(191) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `verify_token` varchar(255) NOT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `treatment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appointment_id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `doc_id` bigint(20) NOT NULL,
  `visit` varchar(255) NOT NULL,
  `teeth` varchar(255) NOT NULL,
  `complaint` varchar(255) NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `fees` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `uploaded_on` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `treatment_id_foreign` (`appointment_id`),
  KEY `treatment_doc_id` (`doc_id`),
  KEY `treatment_patient_id` (`patient_id`),
  CONSTRAINT `treatment_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `tbldoctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `treatment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `tblappointment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `treatment_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO treatment VALUES("110","504","253","184","134","a5sda5","cccccccccc","qqqqqqqq,qqqqqqqq","25.40","","2024-02-27 13:04:43","00000000000000000000000","2024-02-28 02:03:00");



CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users` AS select `tbladmin`.`id` AS `id`,`tbladmin`.`name` AS `name`,`tbladmin`.`email` AS `email`,`tbladmin`.`role` AS `role`,`tbladmin`.`status` AS `status`,`tbladmin`.`password` AS `password`,`tbladmin`.`verify_token` AS `verify_token` from `tbladmin` union all select `tblstaff`.`id` AS `id`,`tblstaff`.`name` AS `name`,`tblstaff`.`email` AS `email`,`tblstaff`.`role` AS `role`,`tblstaff`.`status` AS `status`,`tblstaff`.`password` AS `password`,`tblstaff`.`verify_token` AS `verify_token` from `tblstaff` union all select `tblpatient`.`id` AS `id`,concat(`tblpatient`.`fname`,' ',`tblpatient`.`lname`) AS `name`,`tblpatient`.`email` AS `email`,`tblpatient`.`role` AS `role`,`tblpatient`.`verify_status` AS `status`,`tblpatient`.`password` AS `password`,`tblpatient`.`verify_token` AS `verify_token` from `tblpatient` union all select `tbldoctor`.`id` AS `id`,`tbldoctor`.`name` AS `name`,`tbldoctor`.`email` AS `email`,`tbldoctor`.`role` AS `role`,`tbldoctor`.`status` AS `status`,`tbldoctor`.`password` AS `password`,`tbldoctor`.`verify_token` AS `verify_token` from `tbldoctor`;

INSERT INTO users VALUES("52","admin","admin@gmail.com","admin","1","$2y$10$ovSBMnrKAE/MENpdZpVMe.Xf/qeZeldHbdL5NP.10gNwe/rtmMJgi","");
INSERT INTO users VALUES("53","Brayan Marcelo Marcelo Cangas Vasquez","brayanmisaki@gmail.com","admin","1","$2y$10$XgKCTmjvdUDMcS675/CZOeq.pPWmgJ1HyA3Ku3bjy4uOmCWNiC0zG","");
INSERT INTO users VALUES("253","NAOMY CANGAS","naomy@gmail.com","patient","1","$2y$10$V.pDoxVx3fhXa5jiKXcjMuCDZ8deUgqCJ03784l.Kt.IZWrWHEaDC","");
INSERT INTO users VALUES("184","Andres David","doctor@gmail.com","2","1","$2y$10$IzypaA2rpDTuCi64thIAH.39jDyr7ceFQt/RWCHXDz1OEHkjcJtLC","");

