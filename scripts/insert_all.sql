-- Insertion d'un membre responsable
INSERT INTO members
(login, password, name, first_name, phone, email, bank_account, address, photo, duty, validate, role_name)
 VALUES ('admin', '$2y$10$TzvxU0PwrUtSEXhw2ifoPeV28pChyBe.uc/ah44kNZKSomagW1QRi', 'Sami', 'Hafidi', '0487980967', 'admin@gmail.com', 'BE9900887766775566', 'avenue de la couronne 12', 'admin.jpg', 'r', '1', 'Admin');


-- Insertion d'un membre non validé
INSERT INTO members
(login, password, name, first_name, phone, email, bank_account, address, photo, duty, validate)
 VALUES ('Leeroy', '$2y$10$W6r35hzbydkzwPuKmGI6muIBLvbumnkelFE6J6/HKDFPOAGpcyC26', 'Sané', 'Leroy', '0477984907', 'leeroy.jenkins@gmail.com', 'BE4466004466653266', 'avenue des loques 67', 'default.jpg', 'm', '0');

 -- Insertion du coach
INSERT INTO members
(login, password, name, first_name, phone, email, bank_account, address, photo, duty, validate, role_name)
 VALUES ('pepito', '$2y$10$W9zwJebvXjbA2x0F7Y6YAOIo7qUAfOu.vwQL.QiQsh2STj4IGGdL.', 'Pep', 'Guardiola', '0465890476', 'pepiguardiola@gmail.com', 'BE66889944677765', 'rue des wilks', 'coach.jpg', 'c', '1','Coach');


 -- ----------INSERTION events---------------------------------

 INSERT INTO events (name, address, price, start_date, end_date, url_photo, descriptive, latitude, longitude)
  VALUES ('Marathon de Paris', '3 Rue Rameau, 75002 Paris, France', '12', '2018-07-02', '2018-07-02', NULL,
    'Marathon de 5 km dans les rues de Paris sur un parcours fermé à la circulation et non chronométré.','48.862725','2.287592');


 INSERT INTO events (name, address, price, start_date, end_date, url_photo, descriptive, latitude, longitude)
   VALUES ('Marathon Metz-Mirabelle', '2 Avenue de l\'Amphithéâtre, 57000 Metz, France', '10', '2018-06-05', '2018-06-05', NULL,
     'Plusieurs types de parcours pour tout type de de coureur amateur ou professionel','49.110859','6.181758');

 INSERT INTO events (name, address, price, start_date, end_date, url_photo, descriptive, latitude, longitude)
   VALUES ('Course relais Enghien', 'Avenue Elisabeth 18, 7850 Enghien, Belgique', '0', '2018-05-05', '2018-05-05', NULL,
     'Course gratuite pour amateur à Enghien.','50.692760490335864','4.041080474853516');

 INSERT INTO events (name, address, price, start_date, end_date, url_photo, descriptive, latitude, longitude)
   VALUES ('Biathlon', 'Emile Gryzonlaan 1, 1070 Anderlecht, Belgique', '5', '2018-07-10', '2018-07-10', NULL,
     'Epreuve combinant une disciple de 500m nage libre et 10km de course pour amateur','50.8154756','4.29659079999999') ;


 -- -----------INSERTION annual_member_fees

 INSERT INTO annual_member_fees (year, price)
   VALUES ('2018', '200');

   INSERT INTO annual_member_fees (year, price)
     VALUES ('2019', '250');

 -- ----------------INSERTION member_fees

 INSERT INTO member_fees (login, year)
   VALUES ('admin', '2018') ;

 INSERT INTO member_fees (login, year)
   VALUES ('pepito', '2018') ;

 INSERT INTO member_fees (login, year)
   VALUES ('admin', '2019') ;


   -- Insertion d'un membre ayant payé
    INSERT INTO registered_members
    (login, event_id, payed)
    VALUES ('admin', '3', '1');

   -- Insertion d'un membre n'ayant pas payé
    INSERT INTO registered_members
    (login, event_id, payed)
    VALUES ('pepito', '2', '0');


   -- Insertion de membres interessés

   INSERT INTO interested_members
   (login, event_id)
    VALUES ('admin', '2');

   INSERT INTO interested_members
   (login, event_id)
    VALUES ('Leeroy', '2');



    INSERT INTO training (descriptive)
    VALUES('Plan d\'entrainement pour le marathon de Paris' );

    INSERT INTO training (descriptive)
    VALUES('Plan d\'entrainement pour le marathon Metz-Mirabelle');


    INSERT INTO training_day (training_id,date,activity)
    VALUES ('1', '2018-04-29','Course de 2km');

    INSERT INTO training_day (training_id,date,activity)
    VALUES ('1', '2018-04-30','Course chrono de 1H30');

    INSERT INTO training_day (training_id,date,activity)
    VALUES ('1', '2018-05-01','Course relais sur 1km');


    INSERT INTO training_day (training_id,date,activity)
    VALUES ('2', '2018-05-15','Course relais sur 500m');

    INSERT INTO training_day (training_id,date,activity)
    VALUES ('2', '2018-05-17','Endurance 2H');

    INSERT INTO training_day (training_id,date,activity)
    VALUES ('2', '2018-05-19','Essai 20km');
