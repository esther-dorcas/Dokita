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

    /* ── RESET TAILWIND CONFLICTS ── */
    /* Tailwind préflight casse les tables et les grilles FullCalendar */
    #calendar table  { display: table !important; width: 100% !important; border-collapse: separate !important; }
    #calendar thead  { display: table-header-group !important; }
    #calendar tbody  { display: table-row-group !important; }
    #calendar tr     { display: table-row !important; }
    #calendar th,
    #calendar td     { display: table-cell !important; }

    /* Corrections pour le timegrid (vue Semaine / Jour) */
    .fc-timegrid-slot         { height: 40px !important; }
    .fc-timegrid-slot-label   { font-size: 11px !important; font-weight: 700 !important; color: #94a3b8 !important; vertical-align: middle !important; padding: 0 8px !important; white-space: nowrap !important; }
    .fc-timegrid-axis         { width: 60px !important; }
    .fc-timegrid-col          { min-width: 80px !important; }
    .fc-timegrid-body         { overflow: visible !important; }
    .fc-scroller              { overflow-y: auto !important; }
    .fc-scroller-harness      { overflow: visible !important; }

    /* ── OVERRIDE FULLCALENDAR DESIGN ── */
    .fc { font-family: 'Inter', sans-serif !important; }
    .fc .fc-toolbar { margin-bottom: 20px !important; flex-wrap: wrap; gap: 8px; }
    .fc .fc-toolbar-title { font-size: 1.2rem !important; font-weight: 800 !important; color: #0f172a !important; text-transform: capitalize; }

    .fc .fc-button {
        background: #f8fafc !important;
        border: 1.5px solid #e2e8f0 !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        text-transform: capitalize !important;
        box-shadow: none !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        transition: all .15s !important;
        margin: 0 2px !important;
        cursor: pointer !important;
    }
    .fc .fc-button:hover   { background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #0f172a !important; }
    .fc .fc-button:focus   { box-shadow: 0 0 0 3px rgba(37,99,235,.15) !important; }
    .fc .fc-button-active,
    .fc .fc-button:not(:disabled):active {
        background: var(--blue) !important;
        border-color: var(--blue) !important;
        color: #fff !important;
    }
    .fc .fc-button-group .fc-button { border-radius: 0 !important; }
    .fc .fc-button-group .fc-button:first-child { border-radius: 8px 0 0 8px !important; }
    .fc .fc-button-group .fc-button:last-child  { border-radius: 0 8px 8px 0 !important; }

    /* En-têtes colonnes */
    .fc-col-header-cell {
        background: #f8fafc !important;
        border-color: #f1f5f9 !important;
        padding: 10px 0 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        text-transform: uppercase !important;
        letter-spacing: .06em !important;
    }
    .fc-col-header-cell a { color: inherit !important; text-decoration: none !important; }

    /* Cellules */
    .fc-theme-standard td,
    .fc-theme-standard th { border-color: #f1f5f9 !important; }
    .fc-day-today          { background: #f0f9ff !important; }
    .fc-day-today .fc-col-header-cell-cushion { color: var(--blue) !important; }

    /* Numéros de jour en vue Mois */
    .fc-daygrid-day-number { font-size: 12px !important; font-weight: 700 !important; color: #475569 !important; padding: 6px 8px !important; }
    .fc-day-today .fc-daygrid-day-number {
        background: var(--blue) !important; color: #fff !important;
        border-radius: 50% !important; width: 26px; height: 26px;
        display: flex !important; align-items: center; justify-content: center;
        margin: 4px !important;
    }

    /* Événements */
    .fc-event {
        border: none !important; border-radius: 6px !important;
        padding: 2px 6px !important; font-size: 11px !important;
        font-weight: 700 !important; cursor: pointer !important;
        transition: opacity .15s !important;
    }
    .fc-event:hover { opacity: .85 !important; }
    .fc-event-title { font-weight: 700 !important; }
    .fc-event-time  { font-size: 10px !important; opacity: .8 !important; }

    .event-passed   { background: #f1f5f9 !important; color: #64748b !important; border-left: 3px solid #cbd5e1 !important; }
    .event-upcoming { background: #dbeafe !important; color: #1e40af !important; border-left: 3px solid var(--blue) !important; }
    .event-urgent   { background: #fee2e2 !important; color: #991b1b !important; border-left: 3px solid #ef4444 !important; }

    /* Liste */
    .fc-list-event-title a { color: #0f172a !important; font-weight: 700 !important; }
    .fc-list-day-cushion    { background: #f8fafc !important; font-size: 12px !important; font-weight: 800 !important; }

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
            initialView: 'dayGridWeek', // Vue par défaut: Semaine avec un affichage par jour (comme le mois)
            locale: 'fr', // En français
            firstDay: 1, // La semaine commence le Lundi
            height: 700,
            
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay,listMonth'
            },

            buttonText: {
                today: "Aujourd'hui",
                month: 'Mois',
                week: 'Semaine',
                dayGridDay: 'Jour',
                listMonth: 'Historique'
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

            events: {!! $eventsJson ?? '[]' !!}
        });

        calendar.render();
    });
</script>
@endpush
