INSERT INTO user (email, roles, password, firstname, lastname, city, postal)
 VALUES
('charly@gmail.com', '[]','$2y$10$qcyYy2NS48Oku2B8Pet6uuuw2XL0JceKo17wyBTb8LkF3ijkLOuYG', 'Charly', 'Corint','Rouen','76100'),
('martine@gmail.com', '[]','$2y$10$E7H.qP7qEIodPi2KiyKFrOKoz1SoBJYlGv29T/3emLVhoXBPDe00K', 'Martine', 'Dupont','Bois-Guillaume', '76230')
;
 

INSERT INTO account (type, number, amount, date, user_id)
VALUES
('Compte courant', 'FR7548451512 C50', 548.50 , '2018-10-05', 1),
('Livret A', 'FR451841 C51', 1985.46 ,  '2018-10-05', 1),
('PEL', 'FR151274 C52', 7300 ,  '2019-05-30', 1),
('Compte courant', 'FR7554515157 P48', 1435.67 , '2000-04-25', 2),
('Livret A', 'FR258413 P49', 11475 , '2000-04-25', 2)
;

INSERT INTO operation (type, label, date, amount, account_id)
VALUES
('Debit', 'Amazon commande', '2021-05-19', -42.62 , 1),
('Debit', 'Boulangerie Rouen Centre', '2021-05-19', -3.54 , 1),
('Credit', 'epargne programmé','2021-05-05', 150, 2),
('Credit', 'epargne programmé','2021-05-05', 75, 3),
('Debit', 'Carrefour Rouen', '2021-05-14', -152.28, 4),
('Debit', 'métropole eau', '2021-05-6', -35, 4),
('Credit', 'epargne programmé', '2021-05-6', 350, 5)
;

 