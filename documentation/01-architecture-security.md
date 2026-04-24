# Architecture & Sécurité

## 1. Rôles et Permissions
Nous avons implémenté un système de rôles basé sur une énumération PHP (`UserRole`).
- **ADMIN** : Accès complet à la gestion des produits, catégories et commandes.
- **CLIENT** : Accès au catalogue, au panier et à l'historique de ses propres commandes.

### Middleware de Rôle
Un middleware personnalisé `RoleMiddleware` a été créé pour restreindre l'accès aux routes.
```php
Route::middleware(['role:admin'])->prefix('admin')->group(...);
```

## 2. Sécurité des Données
- **Policies** : Des politiques Laravel (`ProductPolicy`, `OrderPolicy`) assurent que seuls les utilisateurs autorisés peuvent effectuer certaines actions (ex: seul un admin peut créer un produit).
- **CSRF** : Protection standard activée, avec exception pour le webhook de Notch Pay.
- **Validation** : Toutes les entrées sont validées via des `FormRequests` ou des validations manuelles dans les contrôleurs.
