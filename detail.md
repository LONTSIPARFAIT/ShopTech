    # 🚀 PROMPT COMPLET POUR ANTIGRAVITY – SHOPTECH (Laravel 13 + Inertia v3 + Vue 3 + Notch Pay)

    ## 📌 Contexte du projet
    Tu es un architecte backend/fullstack senior spécialisé Laravel 13,  Inertia v3, Vue 3 (Composition API + TypeScript), Tailwind CSS v4, et paiement africain (Notch Pay – XAF, Mobile Money).

    Tu dois générer **l’intégralité du socle technique** d’une plateforme e-commerce premium nommée **ShopTech** (Cameroun & Afrique), en respectant strictement les deux cahiers de spécifications fournis.

    ---

    ## ✅ OBJECTIF PRINCIPAL
    Créer une application e-commerce fonctionnelle, prête à être développée, avec :

    - Authentification (rôles : admin / client)
    - Catalogue produits (catégories, produits, variantes : taille/couleur/stock/price_modifier)
    - Panier avec sessions (invités + utilisateurs connectés)
    - **Promotions automatiques** (sans coupon) :
    - basées sur quantité (ex : 3 produits → -10%)
    - basées sur montant total du panier
    - Paiement **Notch Pay** (hosted checkout) → prioritaire
    - Paiement **à la livraison** → secondaire (option client)
    - Webhook Notch Pay pour validation asynchrone
    - Dashboard client (commandes, factures PDF)
    - Dashboard admin (gestion produits, commandes, promotions)

    ---

    ## 🧱 STACK TECHNIQUE OBLIGATOIRE
    - Laravel 13
    - Inertia v3
    - Vue 3 (Composition API + `<script setup>` + TypeScript)
    - Tailwind CSS v4
    - Wayfinder (routage typé)
    - Notch Pay (SDK officiel Laravel)
    - PHP 8.3
    - MySQL / PostgreSQL
    - Redis (queues)
    - Pest/PHPUnit + PHPStan

    ---

    ## 🧠 ARCHITECTURE & BONNES PRATIQUES (strict)

    ### ✅ Structure de dossiers à générer

    app/
    ├── Actions/
    │ ├── Cart/
    │ ├── Order/
    │ ├── Payment/
    │ └── Promotion/
    ├── Services/
    │ ├── CartService.php
    │ ├── OrderService.php
    │ ├── PaymentService.php
    │ └── PromotionService.php
    ├── Http/
    │ ├── Controllers/
    │ │ ├── Client/
    │ │ └── Admin/
    │ ├── Requests/
    │ │ ├── CheckoutRequest.php
    │ │ └── Admin/ProductRequest.php
    │ └── Resources/
    ├── Models/
    ├── DTOs/
    ├── Events/
    ├── Listeners/
    ├── Notifications/
    ├── Policies/
    ├── Scopes/
    └── Observers/


    ### ✅ Règles strictes
    - Contrôleurs **skinny** (orchestration uniquement)
    - Toute logique métier → **Action** ou **Service**
    - Validation → **Form Request**
    - Données vers Inertia → **Eloquent Resource** + **DTO**
    - Événements asynchrones → **Queue**
    - Webhook Notch Pay → **idempotent + validation signature**

    ---

    ## 🗃️ MIGRATIONS COMPLÈTES (schéma final)

    Génère toutes les migrations avec :

    - `users` (name, email, password, role)
    - `addresses` (user_id, street, city, region, zip_code, phone, is_default)
    - `categories` (name, slug, parent_id)
    - `products` (category_id, name, slug, description, is_active)
    - `product_images` (product_id, path, is_featured)
    - `variants` (product_id, sku, size, color, price_modifier, stock)
    - `carts` (user_id [nullable], session_id, total_price)
    - `cart_items` (cart_id, variant_id, quantity)
    - `promotions` (name, type [qty_based, total_based], threshold, discount_percent)
    - `orders` (user_id, total_amount, status, payment_method [notchpay, cod], payment_reference, payment_status, payment_data)
    - `order_items` (order_id, variant_id, quantity, unit_price)

    Toutes incluent `id`, `created_at`, `updated_at`.

    ---

    ## 🔁 FLUX PRIORITAIRE : PAIEMENT NOTCH PAY

    1. Client valide son panier
    2. `CheckoutController@store` → `CheckoutRequest`
    3. `ApplyPromotionAction` (automatique)
    4. `CreateOrderAction` (status = pending)
    5. `InitializeNotchPayPaymentAction` (génère l’URL hosted checkout)
    6. Redirection Inertia vers Notch Pay
    7. Webhook `HandleNotchPayWebhookAction` → met à jour order → `PaymentSucceeded` event
    8. `UpdateOrderAfterPayment` listener (stock, facture PDF, email)

    ---

    ## 💳 PAIEMENT À LA LIVRAISON (COD)
    - Option disponible au checkout
    - Pas d’appel Notch Pay
    - `status = paid` immédiat, `payment_method = cod`
    - Stock mis à jour immédiatement

    ---

    ## 🎨 FRONTEND VUE 3 (composants clés à générer)

    - `ProductCard.vue`
    - `CartSidebar.vue`
    - `CartIndex.vue`
    - `CheckoutStepper.vue`
    - `PromotionBadge.vue`
    - `OrderSummary.vue`
    - `Dashboard/OrdersList.vue`
    - `Admin/Products/ProductForm.vue`

    Pages Inertia :
    - `Products/Index.vue`
    - `Products/Show.vue`
    - `Cart/Index.vue`
    - `Checkout/Index.vue`
    - `Checkout/Success.vue`
    - `Dashboard/Index.vue`
    - `Admin/Products/Index.vue`
    - `Admin/Orders/Index.vue`

    ---

    ## 🔧 GÉNÉRATION ATTENDUE (par Antigravity)

    Tu dois générer **fichier par fichier** avec contenu complet :

    1. Toutes les migrations SQL/Blueprint
    2. Tous les modèles Eloquent (relations + casts + events)
    3. Toutes les factories + seeders (données réalistes)
    4. Toutes les Form Requests
    5. Tous les contrôleurs (Client + Admin)
    6. Tous les Actions (ex : `ApplyPromotionAction`, `CreateOrderAction`, `HandleNotchPayWebhookAction`)
    7. Tous les Services (`CartService`, `PaymentService`, etc.)
    8. Tous les Events + Listeners + Notifications
    9. Toutes les Policies (OrderPolicy, ProductPolicy)
    10. Routes web.php + wayfinder
    11. Composants Vue 3 (Typescript + `<script setup>`)
    12. Fichiers de config : `notchpay.php`, `queue.php`, `mail.php`
    13. Tests Pest : `CheckoutTest`, `PromotionTest`, `WebhookTest`
    14. `README.md` avec `setup`, `env`, `php artisan serve`, `queue work`

    ---

    ## 🎨 DESIGN & NOM
    - Nom de l’application : **ShopTech**
    - Design épuré, moderne, responsive, dark mode automatique
    - Typographie lisible, espacements larges, arrondis (`rounded-2xl`)
    - Pas de librairie UI externe (Tailwind uniquement)

    ---

    ## ✅ LIVRABLES FINAUX (à fournir dans la réponse)

    > Un **fichier `.md`** structuré contenant :
    > - Tous les extraits de code prêts à être copiés/collés
    > - Arborescence complète du projet généré
    > - Instructions d’installation et de test
    > - Variables d’environnement type (.env.example)

    > ⚠️ Si l’IA peut générer un **fichier `.py`** qui écrit tous les fichiers automatiquement, c’est encore mieux.

    ---

    ## 🧪 TESTS OBLIGATOIRES (Pest)

    - `it_applies_qty_based_promotion_automatically`
    - `it_creates_order_with_notchpay_pending`
    - `it_handles_notchpay_webhook_success`
    - `it_allows_cod_checkout`
    - `it_reduces_stock_after_payment`

    ---

    ## 📦 VARIABLES D’ENV (exemple)

    ```env
    NOTCHPAY_PUBLIC_KEY=pk_...
    NOTCHPAY_SECRET_KEY=sk_...
    NOTCHPAY_CURRENCY=XAF
    NOTCHPAY_WEBHOOK_SECRET=...
    APP_NAME=ShopTech 

    NB : Tu doit faire ceci en utilisant les meilleures pratiques de developpement et en respectant les normes de l'architecture logicielle et aussi ajouter des commentaires pour expliquer chaque partie du code. ET tu doit ajouter les ement important que tu juge neccessaire. mais en proposant