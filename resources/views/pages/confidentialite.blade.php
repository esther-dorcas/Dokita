<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Politique de confidentialité — Dokita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background: #f8fafc; min-height: 100vh; padding: 60px 20px; font-family: system-ui, -apple-system, sans-serif;">
    <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 24px;">Politique de confidentialité</h1>
        <p style="color: #64748b; margin-bottom: 32px;">Dernière mise à jour : {{ date('d/m/Y') }}</p>

        <div style="color: #334155; line-height: 1.8; font-size: 15px;">
            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">1. Collecte des données</h2>
            <p>Nous collectons les informations que vous nous fournissez lors de votre inscription : nom, adresse e-mail, numéro de téléphone, et, le cas échéant, données de géolocalisation pour les urgences.</p>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">2. Utilisation des données</h2>
            <p>Vos données sont utilisées pour :</p>
            <ul style="list-style-type: disc; margin-left: 20px; margin-bottom: 16px;">
                <li>Gérer vos rendez-vous médicaux.</li>
                <li>Transmettre rapidement vos coordonnées aux hôpitaux en cas d'urgence (SOS).</li>
                <li>Améliorer l'expérience utilisateur sur Dokita.</li>
            </ul>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">3. Protection des données</h2>
            <p>Toutes les données sensibles sont cryptées et stockées de manière sécurisée. Nous ne vendons en aucun cas vos données médicales ou personnelles à des tiers.</p>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">4. Vos droits</h2>
            <p>Conformément à la réglementation en vigueur, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles.</p>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
            <a href="{{ url()->previous() }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">&larr; Retour</a>
        </div>
    </div>
</body>
</html>
