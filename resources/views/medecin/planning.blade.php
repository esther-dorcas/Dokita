@extends('layouts.medecin')

@section('title', 'Mon Planning — Dokita PRO')

@push('head')
<!-- FullCalendar CSS & JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<style>
    :root {
        --blue: #2563eb;
        --dark: #0c2340;
        --radius-xl: 20px;
    }

    @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .animate-in { animation: fadeIn .4s ease-out forwards; }

    /* ── HEADER ── */
    .page-header {
        background: #fff;
        border-radius: var(--radius-xl);
        padding: 24px 30px;
        margin-bottom: 24px;
        border: 1px solid #e8edf5;
        box-shadow: 0 10px 30px rgba(0,0,0,.02);
    }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    /* ── CALENDAR WRAPPER ── */
    .calendar-card {
        background: #fff;
        border-radius: var(--radius-xl);
        padding: 24px;
        border: 1px solid #e8edf5;
        box-shadow: 0 10px 30px rgba(0,0,0,.02);
    }

    /* Override FullCalendar Design pour le rendre Premium */
    .fc { font-family: 'Inter', sans-serif !important; }
    .fc .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 800 !important; color: #0f172a; text-transform: capitalize; }
    
    .fc .fc-button-primary {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
        font-weight: 700 !important;
        text-transform: capitalize !important;
        box-shadow: none !important;
        border-radius: 8px !important;
        transition: 0.2s;
        margin: 0 2px !important;
    }
    .fc .fc-button-primary:hover { background: #e2e8f0 !important; color: #0f172a !important; }
    .fc .fc-button-primary:not(:disabled).fc-button-active, 
    .fc .fc-button-primary:not(:disabled):active {
        background: var(--blue) !important;
        border-color: var(--blue) !important;
        color: #fff !important;
    }
    
    .fc-theme-standard th { background: #f8fafc; padding: 10px 0 !important; border-color: #f1f5f9; font-size: 13px; color: #64748b; font-weight: 700; text-transform: uppercase; }
    .fc-theme-standard td { border-color: #f1f5f9; }
    .fc-day-today { background: #f0f9ff !important; }

    .fc-event { border: none !important; border-radius: 6px !important; padding: 3px 5px !important; font-size: 11px !important; font-weight: 600 !important; cursor: pointer; }
    
    /* Types d'évènements */
    .event-passed { background: #f1f5f9 !important; color: #64748b !important; text-decoration: line-through; border-left: 3px solid #cbd5e1 !important; }
    .event-upcoming { background: #e0f2fe !important; color: #0369a1 !important; border-left: 3px solid var(--blue) !important; }
    .event-urgent { background: #fef2f2 !important; color: #b91c1c !important; border-left: 3px solid #ef4444 !important; }

</style>
@endpush

@section('content')
<div class="animate-in">

    <div class="page-header">
        <h1 class="page-title">Planning & Calendrier</h1>
        <p class="page-desc">Gérez vos rendez-vous, vos disponibilités et consultez l'historique de vos consultations passées.</p>
    </div>

    <div class="calendar-card">
        <div id="calendar"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Création de quelques dates dynamiques (Aujourd'hui, Hier, etc.) pour que la démo marche tout le temps.
        var today = new Date();
        var y = today.getFullYear();
        var m = String(today.getMonth() + 1).padStart(2, '0');
        var d = String(today.getDate()).padStart(2, '0');
        var todayStr = y + '-' + m + '-' + d;

        // Date d'hier
        var yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        var yD = String(yesterday.getDate()).padStart(2, '0');
        var yM = String(yesterday.getMonth() + 1).padStart(2, '0');
        var yesterdayStr = yesterday.getFullYear() + '-' + yM + '-' + yD;

        // Date de la semaine dernière
        var lastWeek = new Date(today);
        lastWeek.setDate(lastWeek.getDate() - 5);
        var lD = String(lastWeek.getDate()).padStart(2, '0');
        var lM = String(lastWeek.getMonth() + 1).padStart(2, '0');
        var lastWeekStr = lastWeek.getFullYear() + '-' + lM + '-' + lD;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek', // Vue par défaut: Semaine avec les heures
            slotMinTime: '08:00:00', // Commence à 8h
            slotMaxTime: '19:00:00', // Finit à 19h
            allDaySlot: false, // Enlève la ligne "Toute la journée"
            locale: 'fr', // En français
            firstDay: 1, // La semaine commence le Lundi
            height: 700,
            
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            
            buttonText: {
                today: "Aujourd'hui",
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour',
                list: 'Liste (Historique)'
            },

            // Personnalisation du rendu des évènements pour injecter nos propres classes CSS
            eventClassNames: function(arg) {
                if (arg.event.extendedProps.isPast) {
                    return [ 'event-passed' ];
                } else if (arg.event.extendedProps.isUrgent) {
                    return [ 'event-urgent' ];
                } else {
                    return [ 'event-upcoming' ];
                }
            },

            events: [
                // === ÉVÈNEMENTS PASSÉS (HISTORIQUE) ===
                {
                    title: 'TOSSOU Marc (Terminé)',
                    start: lastWeekStr + 'T10:00:00',
                    end: lastWeekStr + 'T10:30:00',
                    extendedProps: { isPast: true }
                },
                {
                    title: 'DOSSA Clémence (Terminé)',
                    start: yesterdayStr + 'T14:00:00',
                    end: yesterdayStr + 'T14:45:00',
                    extendedProps: { isPast: true }
                },
                {
                    title: 'BIO Tchané (Terminé)',
                    start: yesterdayStr + 'T16:00:00',
                    end: yesterdayStr + 'T16:30:00',
                    extendedProps: { isPast: true }
                },

                // === ÉVÈNEMENTS DU JOUR (À VENIR) ===
                {
                    title: 'SOGLO Jean-Paul - Contrôle',
                    start: todayStr + 'T09:00:00',
                    end: todayStr + 'T09:30:00',
                    extendedProps: { isPast: false }
                },
                {
                    title: 'AMADOU Aminata - Fièvre',
                    start: todayStr + 'T09:30:00',
                    end: todayStr + 'T10:00:00',
                    extendedProps: { isPast: false }
                },
                {
                    title: 'URGENCE - Détresse Resp.',
                    start: todayStr + 'T10:30:00',
                    end: todayStr + 'T11:00:00',
                    extendedProps: { isPast: false, isUrgent: true }
                },
                {
                    title: 'DOSSOU Maxime - Analyses',
                    start: todayStr + 'T11:15:00',
                    end: todayStr + 'T11:45:00',
                    extendedProps: { isPast: false }
                },
                {
                    title: 'KOUASSI Eliane - Douleurs',
                    start: todayStr + 'T14:00:00',
                    end: todayStr + 'T14:30:00',
                    extendedProps: { isPast: false }
                }
            ]
        });

        calendar.render();
    });
</script>
@endpush
