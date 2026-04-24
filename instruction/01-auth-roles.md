# MODULE 1 – AUTHENTIFICATION & RÔLES

Inclure CONTEXTE GLOBAL

## 🎯 Objectif

Mettre en place rôles admin / client

## 🔧 À GÉNÉRER

1. Migration :

* ajout champ `role` dans users

2. Enum :

* UserRole (admin, client)

3. Model User :

* cast enum
* helpers : isAdmin(), isClient()

4. Middleware :

* RoleMiddleware

5. Protection routes :

* admin
* client

6. Policies :

* ProductPolicy
* OrderPolicy

## ⚠️ Contraintes

* Ne pas casser auth existante
* Compatible Inertia

## ✅ Résultat attendu

* admin → accès admin
* client → bloqué

