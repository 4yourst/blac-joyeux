<?php

namespace App\Http\Controllers;

class FaqController extends Controller
{
    /**
     * Page FAQ / réassurance (doc §10.1).
     *
     * Le contenu éditorial est fourni par le pôle Communication ; il est centralisé
     * ici pour alimenter à la fois l'affichage et les données structurées FAQPage (doc §10.2).
     */
    public function index()
    {
        return view('faq', ['faqs' => $this->faqs()]);
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqs(): array
    {
        return [
            [
                'question' => 'Quels sont les délais de livraison ?',
                'answer' => "À Abidjan, votre commande est livrée sous 1 à 2 jours selon la commune. Pour l'intérieur de la Côte d'Ivoire, comptez environ 3 jours. Le délai exact est indiqué au moment de la finalisation.",
            ],
            [
                'question' => 'Comment puis-je payer ma commande ?',
                'answer' => "Deux options s'offrent à vous : le paiement Mobile Money (Wave, Orange Money, MTN, Moov), ou la finalisation sur WhatsApp pour échanger directement avec nous et convenir du règlement.",
            ],
            [
                'question' => 'Puis-je payer à la livraison ?',
                'answer' => "Oui. En choisissant la finalisation sur WhatsApp, vous pouvez convenir d'un paiement en espèces à la réception de votre sac.",
            ],
            [
                'question' => 'Puis-je être conseillée avant d\'acheter ?',
                'answer' => "Bien sûr. La voie WhatsApp est faite pour cela : posez vos questions, précisez votre adresse si elle est difficile à localiser, et laissez-nous vous accompagner avant et après l'achat.",
            ],
            [
                'question' => 'Où sont fabriqués les sacs Blac Joyaux ?',
                'answer' => "Blac Joyaux est une maison de maroquinerie ivoirienne. La collection Joyau de Bla s'inspire de la poupée de fécondité ashanti et incarne un héritage culturel fort, à des prix maîtrisés (de 40 000 à 100 000 FCFA).",
            ],
            [
                'question' => 'Comment entretenir mon sac ?',
                'answer' => "Nettoyez le cuir avec un chiffon doux et sec, et évitez une exposition prolongée au soleil. Chaque fiche produit précise les recommandations d'entretien propres au modèle.",
            ],
        ];
    }
}
