<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mise à jour de votre rendez-vous</title>
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
        
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .status-confirme { background: #dcfce7; color: #16a34a; }
        .status-annule { background: #fee2e2; color: #dc2626; }
        .status-reprogramme { background: #dbeafe; color: #2563eb; }
        
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background: #f8fafc; border-top: 1px solid #e2e8f0; }
        .btn { display: inline-block; padding: 14px 28px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>DOKITA</h1>
    </div>
    
    <div class="content">
        <div class="greeting">
            @if($recipientType === 'medecin')
                Bonjour Dr. {{ $rdv->medecin->user->name ?? 'Docteur' }},
            @else
                Bonjour {{ $rdv->patient->name ?? 'Patient' }},
            @endif
        </div>
        
        <div class="message">
            @if($recipientType === 'medecin')
                @if($status === 'confirme')
                    Le rendez-vous avec le patient <strong>{{ $rdv->patient->name ?? 'inconnu' }}</strong> a été <strong>confirmé</strong> par l'établissement.
                @elseif($status === 'annule')
                    Le rendez-vous avec le patient <strong>{{ $rdv->patient->name ?? 'inconnu' }}</strong> a été <strong>annulé</strong>.
                @elseif($status === 'reprogramme')
                    L'établissement a <strong>reprogrammé</strong> votre consultation avec le patient <strong>{{ $rdv->patient->name ?? 'inconnu' }}</strong>. Veuillez prendre note de la nouvelle date ci-dessous.
                @endif
            @else
                @if($status === 'confirme')
                    Nous avons le plaisir de vous informer que votre rendez-vous médical a été <strong>confirmé</strong> par l'établissement.
                @elseif($status === 'annule')
                    Nous vous informons que votre rendez-vous médical a dû être <strong>annulé</strong> par l'établissement. Veuillez nous excuser pour ce désagrément.
                @elseif($status === 'reprogramme')
                    Votre établissement a <strong>reprogrammé</strong> votre rendez-vous médical. Veuillez prendre note de la nouvelle date ci-dessous.
                @endif
            @endif
        </div>
        
        <div style="text-align: center; margin-bottom: 30px;">
            <span class="status-badge status-{{ $status }}">
                @if($status === 'confirme')
                    ✅ Rendez-vous Confirmé
                @elseif($status === 'annule')
                    ❌ Rendez-vous Annulé
                @elseif($status === 'reprogramme')
                    🔄 Rendez-vous Reprogrammé
                @endif
            </span>
        </div>

        <div class="rdv-card">
            <div class="rdv-row">
                <div class="rdv-label">Date & Heure</div>
                <div class="rdv-value">
                    {{ $rdv->date_heure ? $rdv->date_heure->format('l d F Y à H:i') : 'Non définie' }}
                </div>
            </div>
            <div class="rdv-row">
                <div class="rdv-label">Médecin / Spécialiste</div>
                <div class="rdv-value">Dr. {{ $rdv->medecin->user->name ?? 'Non assigné' }}</div>
            </div>
            <div class="rdv-row" style="margin-bottom: 0;">
                <div class="rdv-label">Établissement</div>
                <div class="rdv-value">{{ $rdv->medecin->hopital->nom ?? 'Votre Centre Médical' }}</div>
            </div>
        </div>

        @if($status !== 'annule')
        <div style="text-align: center;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 15px;">Vous pouvez consulter les détails complets sur votre espace personnel.</p>
            <a href="{{ config('app.url') }}/patient/dashboard" class="btn">Accéder à mon espace</a>
        </div>
        @endif

    </div>
    
    <div class="footer">
        Cet email a été envoyé automatiquement par la plateforme e-santé Dokita.<br>
        Ne répondez pas directement à ce message.
    </div>
</div>

</body>
</html>
