# Panier & Checkout

## 1. Gestion du Panier
Le panier est géré par le `CartService`. Il supporte :
- **Sessions Invités** : Les utilisateurs peuvent ajouter des produits sans être connectés.
- **Synchronisation** : (À venir) Fusion du panier session avec le panier utilisateur lors de la connexion.
- **Promotions** : Calcul automatique des réductions (ex: selon la quantité totale).

## 2. Processus de Commande (Checkout)
Le tunnel d'achat se déroule en plusieurs étapes :
- **Récapitulatif** : Visualisation finale des articles et du total.
- **Informations** : Saisie de l'adresse de livraison et du numéro de téléphone.
- **Paiement** : Choix de la méthode de paiement.
