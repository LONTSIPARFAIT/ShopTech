# Intégrations de Paiement

## 1. Notch Pay
Intégration du gateway camerounais pour les paiements mobiles (Orange, MTN) et Cartes.
- **Service** : `PaymentService` gère l'initialisation et la vérification.
- **Flux** : Initialisation -> Redirection -> Callback/Webhook.
- **Webhook** : Validation asynchrone des transactions pour plus de fiabilité.

## 2. Cash on Delivery (COD)
Option de paiement à la livraison.
- **Service** : `CODService` confirme la commande immédiatement avec un statut de paiement "unpaid".
- **Validation** : Le statut passe à "paid" manuellement par l'admin après réception du paiement physique.
