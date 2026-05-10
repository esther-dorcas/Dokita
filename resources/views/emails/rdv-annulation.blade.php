<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Annulation RDV – Dokita</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">

      <!-- Header -->
      <tr>
        <td style="background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 100%);padding:32px 40px;text-align:center;">
          <div style="font-size:28px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;">Dokita</div>
          <div style="color:#bfdbfe;font-size:13px;margin-top:4px;">Votre santé, notre priorité</div>
        </td>
      </tr>

      <!-- Icon + title -->
      <tr>
        <td style="padding:32px 40px 0;text-align:center;">
          <div style="width:64px;height:64px;background:#fee2e2;border-radius:50%;margin:0 auto;font-size:32px;line-height:64px;">❌</div>
          <h1 style="color:#0c2340;font-size:22px;font-weight:700;margin:16px 0 8px;">Rendez-vous annulé</h1>
          <p style="color:#64748b;font-size:15px;margin:0;">Votre rendez-vous a été annulé avec succès.</p>
        </td>
      </tr>

      <!-- Details -->
      <tr>
        <td style="padding:24px 40px;">
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:24px;">
            <tr>
              <td style="padding:0 0 16px 0;">
                <span style="font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Médecin</span><br>
                <span style="font-size:16px;color:#0c2340;font-weight:600;text-decoration:line-through;color:#94a3b8;">Dr {{ $rdv->medecin->user->name ?? '–' }}</span>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 0 0;border-top:1px solid #e2e8f0;">
                <span style="font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Date & Heure</span><br>
                <span style="font-size:16px;color:#94a3b8;font-weight:600;text-decoration:line-through;">
                  {{ $rdv->date_heure->translatedFormat('l d F Y') }} à {{ $rdv->date_heure->format('H\hi') }}
                </span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- CTA -->
      <tr>
        <td style="padding:0 40px 32px;text-align:center;">
          <p style="color:#64748b;font-size:14px;margin:0 0 20px;">Vous pouvez prendre un nouveau rendez-vous à tout moment sur la plateforme.</p>
          <a href="{{ config('app.url') }}/prendre-rdv" style="display:inline-block;background:#2563eb;color:#ffffff;font-size:15px;font-weight:600;padding:12px 32px;border-radius:8px;text-decoration:none;">
            Prendre un nouveau RDV
          </a>
        </td>
      </tr>

      <!-- Footer -->
      <tr>
        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:20px 40px;text-align:center;">
          <p style="color:#94a3b8;font-size:12px;margin:0;">© {{ date('Y') }} Dokita – Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
