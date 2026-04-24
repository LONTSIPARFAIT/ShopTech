# MODULE 8 – WEBHOOK NOTCH PAY

Inclure CONTEXTE GLOBAL

## 🎯 Objectif

Validation asynchrone

## 🔧 À GÉNÉRER

1. Route webhook

2. Action :

* HandleNotchPayWebhookAction

3. Event :

* PaymentSucceeded

4. Listener :

* UpdateOrderAfterPayment

## ⚠️ Contraintes

* idempotent
* signature vérifiée
