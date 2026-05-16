<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvelle demande de consultation</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background-color: #0c2340; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 20px; }
        .message { font-size: 15px; color: #475569; line-height: 1.6; margin-bottom: 30px; }
        
        .rdv-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 30px; }
        .rdv-row { margin-bottom: 12px; }
        .rdv-label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px; margin-bottom: 4px; }
        .rdv-value { font-size: 16px; color: #0f172a; font-weight: bold; }
        
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background: #f8fafc; border-top: 1px solid #e2e8f0; }
        .btn { display: inline-block; padding: 14px 28px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>DOKITA - ÉTABLISSEMENT</h1>
    </div>
    
    <div class="content">
        <div class="greeting">Bonjour {{ $rdv->hopital->nom ?? 'Établissement' }},</div>
        
        <div class="message">
            Le patient <strong>{{ $rdv->patient->name ?? 'Un patient' }}</strong> vient de formuler une nouvelle demande de consultation médicale au sein de votre établissement. Cette demande est actuellement <strong>en attente</strong> de votre confirmation.
        </div>

        <div class="rdv-card">
            <div class="rdv-row">
                <div class="rdv-label">Date & Heure souhaitées</div>
                <div class="rdv-value">
                    {{ $rdv->date_heure ? $rdv->date_heure->format('l d F Y à H:i') : 'Non définie' }}
                </div>
            </div>
            <div class="rdv-row">
                <div class="rdv-label">Patient</div>
                <div class="rdv-value">{{ $rdv->patient->name ?? 'Inconnu' }} (Tél: {{ $rdv->patient->telephone ?? 'Non renseigné' }})</div>
            </div>
            <div class="rdv-row" style="margin-bottom: 0;">
                <div class="rdv-label">Médecin Sollicité</div>
                <div class="rdv-value">Dr. {{ $rdv->medecin->user->name ?? 'Non assigné' }}</div>
            </div>
        </div>

        <div style="text-align: center;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 15px;">Veuillez vous connecter à votre portail pour confirmer ou reprogrammer ce créneau.</p>
            <a href="{{ config('app.url') }}/hopital/rdv" class="btn">Gérer ce rendez-vous</a>
        </div>

    </div>
    
    <div class="footer">
        Cet email a été envoyé automatiquement par la plateforme e-santé Dokita.<br>
        Ne répondez pas directement à ce message.
    </div>
</div>

</body>
</html>
