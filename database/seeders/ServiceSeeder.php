<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Plomberie
            [
                'name' => 'Installation de Robinetterie',
                'type' => 'plomberie',
                'description' => 'Installation professionnelle de robinets, mélangeurs et accessoires de salle de bain.',
                'details' => 'Service incluant : démontage ancien robinet, installation nouvelle robinetterie, étanchéité et tests.',
                'base_price' => 35000,
                'image_url' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?q=80&w=800',
            ],
            [
                'name' => 'Réparation de Tuyauterie',
                'type' => 'plomberie',
                'description' => 'Diagnostic et réparation de fuites d\'eau et problèmes de tuyauterie.',
                'details' => 'Détection des fuites, remplacement de sections endommagées, renforcement des joints.',
                'base_price' => 45000,
                'image_url' => 'https://images.unsplash.com/photo-1581092335392-8bda2b5f8b3e?q=80&w=800',
            ],
            [
                'name' => 'Installation Chauffe-eau',
                'type' => 'plomberie',
                'description' => 'Installation et mise en service de chauffe-eau électrique ou gaz.',
                'details' => 'Raccordement complet, test de sécurité, explication de fonctionnement et maintenance.',
                'base_price' => 55000,
                'image_url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=800',
            ],
            [
                'name' => 'Débouchage de Canalisation',
                'type' => 'plomberie',
                'description' => 'Dégagement des canalisations bouchées avec équipement professionnel.',
                'details' => 'Intervention d\'urgence, utilisation de furet électrique ou hydrocurage selon besoin.',
                'base_price' => 30000,
                'image_url' => 'https://images.unsplash.com/photo-1581092335392-8bda2b5f8b3e?q=80&w=800',
            ],

            // Électricité
            [
                'name' => 'Installation Électrique Complète',
                'type' => 'electricite',
                'description' => 'Installation complète de circuit électrique avec tableau, disjoncteurs et fils aux normes.',
                'details' => 'Respect des normes NFC 15-100, pose de circuit, test et mise en conformité.',
                'base_price' => 150000,
                'image_url' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800',
            ],
            [
                'name' => 'Installation d\'Éclairage LED',
                'type' => 'electricite',
                'description' => 'Pose de luminaires LED pour intérieur ou extérieur avec gestion de l\'énergie.',
                'details' => 'Installation, branchement et programmation des éclairages, garantie 2 ans.',
                'base_price' => 40000,
                'image_url' => 'https://images.unsplash.com/photo-1550985616-10810253b84d?q=80&w=800',
            ],
            [
                'name' => 'Maintenance Tableau Électrique',
                'type' => 'electricite',
                'description' => 'Vérification annuelle et maintenance du tableau électrique de votre habitation.',
                'details' => 'Test de sécurité, vérification des disjoncteurs, nettoyage et ajustements.',
                'base_price' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800',
            ],
            [
                'name' => 'Installation de Prise et Interrupteur',
                'type' => 'electricite',
                'description' => 'Ajout ou remplacement de prises électriques et interrupteurs aux normes.',
                'details' => 'Travail aux normes NFC 15-100, finitions professionnelles et garantie.',
                'base_price' => 20000,
                'image_url' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800',
            ],
            [
                'name' => 'Diagnostic Électrique Complet',
                'type' => 'electricite',
                'description' => 'Audit complet de votre installation électrique pour détecter les anomalies.',
                'details' => 'Rapport détaillé avec recommandations de mise en conformité et travaux nécessaires.',
                'base_price' => 35000,
                'image_url' => 'https://images.unsplash.com/photo-1621905252507-b354bcadc964?q=80&w=800',
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'type' => $service['type'],
                'base_price' => $service['base_price'],
                'details' => $service['details'],
                'image_url' => $service['image_url'],
                'is_active' => true,
            ]);
        }
    }
}
