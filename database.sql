CREATE DATABASE klinika_db;
USE klinika_db;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'patient') DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100),
    bio TEXT,
    experience VARCHAR(50),
    specialized_in VARCHAR(150),
    image VARCHAR(100) DEFAULT 'default.jpg'
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    message TEXT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);


INSERT INTO doctors (name, title, bio, experience, specialized_in, image) VALUES
('Dr. Uranik Zatriqi', 'Chief Pulmonologist', 'Founder and leader with 20+ years experience.', '22 years', 'University of Vienna, Austria', 'doc.jpg'),
('Dr. Etna Begu', 'Asthma Specialist', 'Focused on asthma care in all age groups.', '12 years', 'University of Zurich, Switzerland', 'doc5.jpg'),
('Dr. Artur Martini', 'Respiratory Therapist', 'Helps patients improve lung function through therapy.', '15 years', 'Sapienza University, Italy', 'doktor.jpg'),
('Dr. Nol Kelmendi', 'Sleep Specialist', 'Expert in sleep apnea and insomnia treatment.', '9 years', 'Harvard Medical School, USA', 'doktor2.jpg'),
('Dr. Molos Uka', 'Pediatric Pulmonologist', 'Dedicated to treating children with respiratory illnesses.', '14 years', 'Charité – Universitätsmedizin Berlin, Germany', 'molos.png'),
('Dr. Una Tarashaj', 'COPD Specialist', 'Manages chronic obstructive pulmonary disease effectively.', '11 years', 'University of Oslo, Norway', 'doce.jpg'),
('Dr. Daur Drenica', 'Allergy Specialist', 'Treats allergies and immune-related lung issues.', '13 years', 'University of Toronto, Canada', 'doc8.jpg'),
('Dr. Treva Hoti', 'Lung Imaging Expert', 'Performs and interprets advanced lung imaging scans.', '10 years', 'University of Cambridge, UK', 'dok.png'),
('Dr. Ene Leka', 'Bronchoscopy Specialist', 'Conducts bronchoscopic procedures with precision.', '8 years', 'University of Vienna, Austria', 'ene.jpg'),
('Dr. Lerna Canolli', 'Senior Pulmonologist', 'Oversees treatment protocols and clinical quality.', '18 years', 'University of Heidelberg, Germany', 'doce2.jpg');




INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@clinic.com', '$2y$10$vz1daAcR2UdgWgo5SRMZn.HJ/JjstBX2DgOLE8Gg.VVwiqy3xbvvm', 'admin');

--admin123

ALTER TABLE users ADD is_active TINYINT(1) DEFAULT 1;