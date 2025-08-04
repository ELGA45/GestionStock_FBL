# GestionStock_FLD

<h2>Projet de Fin de Module : Gestion Stock FLD</h2>
<p>Dans le cadre du module de développement web avec PHP/MySQL, vous êtes 
invités à compléter et finaliser une application de gestion de stock déjà amorcée 
en classe. Ce projet servira de projet de fin de module.</p>
<p>❖  Objectif <br>
Mettre en place une application web de gestion de stock pour une 
boutique en ligne fictive "BOUTIQUE FLD", permettant 
d’administrer : <br>
1. Les produits <br>
2. Les catégories <br>
3. Les clients <br>
4. Les commandes <br>
5. Les utilisateurs (admin et employés)</p>
<p>❖  Fonctionnalités attendues <br>
➢  Authentification <br>
6. Formulaire de login sécurisé via mot de passe haché. <br>
7. Système de rôles : admin et employé. <br>
8. Page de demande d'inscription (stockée en attente d’approbation
par admin).</p>
<p>❖ Gestion des utilisateur <br>
9. Seuls les admins peuvent créer ou supprimer des comptes 
utilisateurs. <br>
10. Liste des utilisateurs actifs avec leur rôle. </p>
<p>❖ Gestion des produits<br>
11. Ajouter un produit (nom, prix, stock, image, catégorie). <br>
12. Modifier / supprimer un produit. <br>
13. Lister les produits. <br>
14. Upload d’image produit sécurisé et stocké dans /medias.</p>
<p>❖ Gestion des catégories <br>
15. Ajout <br>
16. modification <br>
17. suppression  </p>
<p>❖ Gestion des clients <br>
18. Ajouter/modifier/supprimer un client.<br> 
19. Upload de photo pour chaque client. <br>
20. Rechercher un client par nom ou téléphone. </p>
<p>❖ Gestion des commandes <br>
21. Associer une commande à un client et une liste de produits. <br>
22. Suivi de l’état de la commande. </p>
<p>❖ Base de données <br>
Les étudiants doivent créer la base de données gestionStockFLD avec les tables 
suivantes : <br>
23. utilisateur (id, nom, email, mot_de_passe, rôle, statut) <br>
24. produit (id, nom, prix, stock, image, idCategorie) <br>
25. categorie (id, nom) <br>
26. client (id, nom, email, téléphone, photo) <br>
27. commande (id, idClient, dateCommande) <br>
28. commande_produit (idCommande, idProduit, quantite) </p>
<p>❖ Contraintes techniques <br>
29. PHP avec PDO. <br>
30. MySQL. <br>
31. Aucune faille SQL (requêtes préparées). <br>
32. Utilisation correcte des superglobales.<br>
33. Respect des méthodes POST/GET selon le contexte. <br>
34. Upload sécurisé d'images. </p>
