# BanqueChabaut
Application symfony réalisé en équipe (avec Charlene76140)  une simulation d'application bancaire avec les fonctionnalités commune à ce type de site (gestion des comptes par utilisateurs, administration)

Projet à rendre : Une application bancaire Symfony
Si l’évolution de votre application vers un modèle objet avec intégration du pattern MVC a permis
de corriger les bugs remontés précédemment et d’améliorer la maintenabilité de l’application, trop
soucis de maintenance sont encore présents.
En effet de nombreux développeurs se sont succédés sur le projet, apportant chacun leur style de
code et aujourd’hui le code source a perdu en cohérence rendant son évolution difficile. De même
des problèmes de performances lors des grosses montées en charge se font sentir.
C’est pour toutes ces raisons que votre chef de projet a décidé de migrer l’application vers sur le
framework Symfony.

Rappel des spécifications fonctionnelles :
- L’application n’est accessible qu’aux seuls utilisateurs connectés
- Quand un utilisateur non connecté va sur l’application il est redirigé vers une page de connexion
avec un formulaire
- Un utilisateur se connecte à l’aide d’une adresse mail et d’un mot de passe
- Un utilisateur connecté peut se déconnecter
- Une fois connecté, l’utilisateur voit uniquement ses comptes en banque personnels.
- Quand l’utilisateur clique sur un compte en banque, il arrive sur une page dédié au compte où il
voit les informations du compte mais aussi les dernières opérations effectuées sur le compte
- Via une page dédiée un utilisateur peut créer un nouveau compte personnel à l’aide d’un
formulaire. Une fois créé le compte apparaît sur la page d’accueil. Attention le compte doit
respecter les conditions minimum de création de compte (bon type et bon montant)
- L’utilisateur peut effectuer des dépôts ou des retraits sur le compte de son choix. Le montant du
compte est alors mis à jour et une nouvelle opération est enregistrée sur le compte.
En plus de ces spécifications, vous essaierez de :
- peupler la base de données à l’aide de fixtures
- valider les données rentrées dans les formulaires à l’aide du validator
