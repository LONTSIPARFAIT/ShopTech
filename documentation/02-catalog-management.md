# Gestion du Catalogue

## 1. Structure des Données
Le catalogue est structuré autour de quatre entités principales :
- **Category** : Organisation thématique des produits.
- **Product** : Informations de base (nom, description, prix de base).
- **Variant** : Options spécifiques (couleur, taille, RAM) avec surcoût possible.
- **ProductImage** : Gestion des visuels produits.

## 2. Administration
L'administrateur peut :
- Créer/Modifier/Supprimer des catégories.
- Gérer les produits avec téléchargement d'images.
- Définir des variantes complexes pour chaque produit.

## 3. Navigation Publique
- **Index** : Grille de produits responsive avec filtrage par catégorie.
- **Show** : Page de détail avec sélection de variantes et calcul dynamique du prix.
