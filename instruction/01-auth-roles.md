# MODULE 1 – AUTH & RÔLES

Inclure : CONTEXTE GLOBAL

---

## 🎯 OBJECTIF

Mettre en place rôles admin / client

---

## 🔧 BACKEND

* migration ajout `role`
* enum UserRole
* User model (casts + helpers)
* middleware RoleMiddleware
* policies (Product, Order)

---

## 🌐 ROUTES

* routes protégées admin/client

---

## 🎨 FRONTEND MINIMAL

Créer :

* `Pages/Auth/TestRole.vue`

Fonction :

* afficher rôle utilisateur
* bouton test accès admin

---

## 🧪 TEST MANUEL

1. login user
   → voir rôle affiché

2. accéder route admin
   → refus si client

3. accéder admin avec admin
   → OK

---

## ⚠️ CONTRAINTES

* ne pas casser auth existante
