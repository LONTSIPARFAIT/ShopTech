# MODULE 2 – CATALOGUE DE PRODUITS (PLOMBERIE & ÉLECTRICITÉ)

Inclure : CONTEXTE GLOBAL (instruction/00-core-context.md)

---

## 🎯 OBJECTIF

Gérer le catalogue de produits spécifiquement pour :
- **Plomberie**: robinetterie, tuyauterie, chauffe-eau, pièces détachées
- **Électricité**: câbles, tableaux, interrupteurs, éclairage, pièces détachées

Fonctionnalités:
- 2 catégories principale (Plomberie & Électricité)
- Produits avec variantes (couleur, taille, options)
- Images et descriptions produits
- Promotions par quantité
- Système de prix avec possibilité de surcoût variante

---

## 🔧 BACKEND

### Migrations
- `2026_04_24_170000` - Crée table `categories` (Plomberie, Électricité seulement)
- `2026_04_24_170001` - Crée table `products` (base_price, original_price, shipping_cost, promo_*)
- `2026_04_24_170002` - Crée table `variants` (price_override, stock, color_code)
- `2026_04_24_170003` - Crée table `product_images` (path, is_featured)

### Models
- `Category` - Plomberie & Électricité
- `Product` - Produits avec relations
- `Variant` - Variantes de produit
- `ProductImage` - Images par produit

### Controllers
- `ProductController` - Public (index, show)
- `Admin\ProductController` - CRUD admin
- `Admin\CategoryController` - CRUD catégories admin

### Seeders
- `CategorySeeder` - 2 catégories (Plomberie, Électricité)
- `ProductSeeder` - 10 produits d'exemple
- `PromotionSeeder` - Promotions automatiques

---

## 🌐 ROUTES

### Public
```
GET  /products              → ProductController@index (catalogue complet)
GET  /products/{slug}       → ProductController@show  (détail produit)
```

### Admin
```
GET    /admin/products      → ProductController@index
GET    /admin/products/create
POST   /admin/products      → ProductController@store
GET    /admin/products/{id}/edit
PUT    /admin/products/{id}
DELETE /admin/products/{id}

GET    /admin/categories
GET    /admin/categories/create
POST   /admin/categories
GET    /admin/categories/{id}/edit
PUT    /admin/categories/{id}
DELETE /admin/categories/{id}
```

---

## 🎨 FRONTEND

### Pages Vue
- `Products/Index.vue` - Catalogue avec filtrage
- `Products/Show.vue` - Détail produit + variantes
- `Admin/Products/Index.vue` - Gestion produits admin
- `Admin/Categories/Index.vue` - Gestion catégories admin

### Composants
- `ProductCard.vue` - Affichage produit grille
- `ProductVariantSelector.vue` - Sélecteur variantes
- `ProductGallery.vue` - Galerie images

---

## 📊 STRUCTURE DE DONNÉES

### Category
```
id, name, slug, description, image, created_at, updated_at
```
Catégories: Plomberie, Électricité

### Product
```
id, category_id, name, slug, description,
base_price, original_price, shipping_cost,
promo_min_quantity, promo_discount_percent,
is_active, created_at, updated_at
```

### Variant
```
id, product_id, name, value, color_code,
price_override, stock, created_at, updated_at
```

### ProductImage
```
id, product_id, path, is_featured, created_at, updated_at
```

---

## 🧪 PRODUITS SEEDED

### Plomberie (5 produits)
1. Mitigeur Cuisine Flexible - 45,000 XAF
2. Robinet Salle de Bain - 28,000 XAF
3. Tuyau PVC Ø20mm (50m) - 12,500 XAF
4. Coude 90° Ø20mm (Lot 10) - 8,000 XAF
5. Chauffe-eau Électrique 200L - 220,000 XAF

### Électricité (5 produits)
1. Tableau Électrique Pré-équipé - 85,000 XAF
2. Lot de 10 Interrupteurs - 12,000 XAF
3. Projecteur LED 50W - 18,500 XAF
4. Câble Électrique 2.5mm² (100m) - 35,000 XAF
5. Disjoncteur 16A - 6,500 XAF

---

## 🎯 CONTRAINTES

✅ Variantes obligatoires (couleur, taille, option)
✅ Une image principale par produit
✅ Prix peut avoir surcoût par variante
✅ Seulement 2 catégories autorisées (Plomberie, Électricité)
✅ Produits sans catégorie interdits
✅ Stock par variante
✅ Promotions automatiques par quantité

---

## ⚠️ À NE PAS FAIRE

❌ Créer des catégories en dehors de Plomberie & Électricité
❌ Ajouter des produits de construction, outillage ou autres
❌ Produits sans variante
❌ Supprimer les 2 catégories principales
