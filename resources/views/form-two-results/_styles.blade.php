<style>
    .f2-shell { --f2-green: #0b6b3a; --f2-dark: #12372a; --f2-gold: #f4c430; --f2-pale: #eef8f1; }
    .f2-sheet { border: 2px solid var(--f2-dark); border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 12px 28px rgba(18,55,42,.12); }
    .f2-title { background: linear-gradient(135deg, var(--f2-dark), var(--f2-green)); color: #fff; padding: 1.2rem 1.4rem; }
    .f2-title h2, .f2-title h5 { margin: 0; font-weight: 800; letter-spacing: .02em; }
    .f2-ribbon { background: var(--f2-gold); color: #1c281f; padding: .55rem 1rem; font-weight: 800; text-align: center; border-bottom: 2px solid var(--f2-dark); }
    .f2-tabs { gap: .4rem; overflow-x: auto; flex-wrap: nowrap; padding-bottom: .35rem; }
    .f2-tabs .nav-link { white-space: nowrap; color: var(--f2-dark) !important; border: 1px solid #b8d6c2; background: #fff; font-weight: 700; }
    .f2-tabs .nav-link i { color: var(--f2-green) !important; }
    .f2-tabs .nav-link.active { color: #fff !important; background: var(--f2-green); border-color: var(--f2-green); }
    .f2-tabs .nav-link.active i { color: #fff !important; }
    .f2-stat { border: 1px solid #bdd8c5; border-left: 5px solid var(--f2-green); border-radius: 10px; background: linear-gradient(180deg,#fff,var(--f2-pale)); padding: 1rem; height: 100%; }
    .f2-stat .value { font-size: 1.8rem; font-weight: 800; color: var(--f2-dark); }
    .f2-workflow { border-left: 4px solid var(--f2-gold); padding: .65rem .85rem; background: #fffdf0; border-radius: 0 8px 8px 0; }
    .f2-table thead th { background: var(--f2-dark); color: #fff; border-color: #557466; vertical-align: middle; text-align: center; white-space: nowrap; }
    .f2-table tbody td { vertical-align: middle; }
    .f2-table .sticky-col { position: sticky; left: 0; z-index: 2; background: #fff; min-width: 190px; }
    .f2-table thead .sticky-col { z-index: 3; background: var(--f2-dark); }
    .f2-marks-table { width: 100%; table-layout: fixed; }
    .f2-marks-table .sticky-col { min-width: 0; }
    .f2-marks-table .f2-student-name-col { width: 180px; max-width: 180px; white-space: normal; overflow-wrap: anywhere; line-height: 1.35; }
    .f2-marks-table .f2-fcp-name-col { width: 145px; max-width: 145px; white-space: normal; overflow-wrap: anywhere; line-height: 1.35; }
    .f2-mark { min-width: 76px; text-align: center; }
    .f2-mark.is-absent { background: #fff0f0; color: #a11919; }
    .f2-subject-entry-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(118px, 1fr)); gap: .55rem; }
    .f2-subject-entry { min-width: 0; padding: .55rem; border: 1px solid #cbd8cf; border-radius: 8px; background: #f8fbf9; text-align: center; }
    .f2-subject-entry__title { display: flex; justify-content: space-between; align-items: baseline; gap: .35rem; margin-bottom: .4rem; color: var(--f2-dark); }
    .f2-subject-entry__title span { color: #6b7280; font-size: .7rem; }
    .f2-code { display: block; font-size: .72rem; opacity: .75; font-weight: 500; }
    .f2-grade-A { background: #d9f6e4 !important; color: #075c2e; font-weight: 800; }
    .f2-grade-B { background: #e6f3ff !important; color: #174f7a; font-weight: 800; }
    .f2-grade-C { background: #fff8d5 !important; color: #735d00; font-weight: 800; }
    .f2-grade-D, .f2-grade-E, .f2-grade-F { background: #ffe2e2 !important; color: #8a1515; font-weight: 800; }
    .f2-empty { padding: 3rem 1rem; text-align: center; color: #68766e; }
    .f2-logo { width: 76px; height: 76px; object-fit: contain; }
    .division-celebration { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 1.45rem; height: 1.45rem; margin-right: .35rem; color: #f4b400; vertical-align: middle; }
    .division-celebration i { position: relative; z-index: 2; filter: drop-shadow(0 1px 2px rgba(0,0,0,.25)); animation: divisionStarPop 1.25s ease-in-out infinite; }
    .division-celebration span { position: absolute; width: .32rem; height: .32rem; border-radius: 999px; background: #f4c430; opacity: 0; animation: divisionSpark 1.15s ease-out infinite; }
    .division-celebration span:nth-child(2) { --x: -12px; --y: -12px; background: #22c55e; }
    .division-celebration span:nth-child(3) { --x: 12px; --y: -10px; background: #0ea5e9; animation-delay: .16s; }
    .division-celebration span:nth-child(4) { --x: 0; --y: -16px; background: #ef4444; animation-delay: .32s; }
    @keyframes divisionSpark {
        0% { transform: translate(0, 0) scale(.4); opacity: 0; }
        25% { opacity: 1; }
        100% { transform: translate(var(--x), var(--y)) scale(.05); opacity: 0; }
    }
    @keyframes divisionStarPop {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-3px) scale(1.12); }
    }
    @media print {
        body { background: #fff !important; }
        .sidebar,
        .sidebar-backdrop,
        .navbar,
        .topbar,
        .topbar-icon-link,
        .dropdown-menu,
        .offcanvas,
        .modal,
        .f2-no-print,
        footer { display: none !important; }
        .main-content, .content-wrapper, .container-fluid, .f2-shell { margin: 0 !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
        .f2-sheet { box-shadow: none; border-radius: 0; }
        .division-celebration i, .division-celebration span { animation: none !important; }
    }
</style>
