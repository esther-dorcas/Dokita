<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conditions d'utilisation — Dokita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background: #f8fafc; min-height: 100vh; padding: 60px 20px; font-family: system-ui, -apple-system, sans-serif;">
    <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 24px;">Conditions d'utilisation</h1>
        <p style="color: #64748b; margin-bottom: 32px;">Dernière mise à jour : {{ date('d/m/Y') }}</p>

        <div style="color: #334155; line-height: 1.8; font-size: 15px;">
            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">1. Acceptation des conditions</h2>
            <p>En accédant et en utilisant la plateforme Dokita, vous acceptez d'être lié par les présentes Conditions d'Utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser nos services.</p>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">2. Description du service</h2>
            <p>Dokita est une plateforme de mise en relation entre patients, médecins et établissements de santé. Nous facilitons la prise de rendez-vous et la gestion des urgences médicales.</p>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">3. Responsabilités des utilisateurs</h2>
            <ul style="list-style-type: disc; margin-left: 20px; margin-bottom: 16px;">
                <li>Fournir des informations exactes lors de l'inscription.</li>
                <li>Ne pas utiliser la plateforme à des fins frauduleuses ou illégales.</li>
                <li>Respecter la confidentialité des informations médicales.</li>
            </ul>

            <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 32px; margin-bottom: 12px;">4. Modification des services</h2>
            <p>Dokita se réserve le droit de modifier ou d'interrompre temporairement ou définitivement le service avec ou sans préavis.</p>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
            <a href="{{ url()->previous() }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">&larr; Retour</a>
        </div>
    </div>
</body>
</html>
