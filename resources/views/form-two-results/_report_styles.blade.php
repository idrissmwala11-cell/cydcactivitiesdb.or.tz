<style>
    .report-card-sheet { max-width: 940px; margin: 0 auto; color: #111; }
    .report-head { position: relative; min-height: 112px; padding: 16px 124px; text-align: center; border-bottom: 2px solid #12372a; display: flex; align-items: center; justify-content: center; }
    .report-head__content { max-width: 640px; margin: 0 auto; }
    .report-head__logo { position: absolute; top: 50%; width: 82px; height: 82px; object-fit: contain; transform: translateY(-50%); }
    .report-head__logo--left { left: 76px; }
    .report-head__logo--right { right: 76px; }
    .report-meta { display: grid; grid-template-columns: repeat(2, 1fr); border-bottom: 2px solid #12372a; }
    .report-meta > div { padding: 8px 12px; border-right: 1px solid #12372a; }
    .report-meta > div:nth-child(even) { border-right: 0; }
    .report-footer { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; padding: 12px; }
    .report-page + .report-page { margin-top: 2rem; }
    .full-results-report { max-width: none; color: #111; }
    .full-results-table { font-size: 0.78rem; }
    .full-results-table th, .full-results-table td { padding: 0.42rem; }
    .subject-marks-cell { min-width: 320px; line-height: 1.65; }
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
    .fcp-winner-cell { position: relative; overflow: visible; min-width: 76px; }
    .fcp-winner-trophy { display: inline-block; margin-right: 0.35rem; color: #f6b900; filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.25)); animation: fcpTrophyBounce 1.35s ease-in-out infinite; }
    .fcp-fireworks { position: absolute; left: 50%; top: 50%; width: 58px; height: 58px; transform: translate(-50%, -50%); pointer-events: none; }
    .fcp-fireworks span { position: absolute; left: 50%; top: 50%; width: 7px; height: 7px; border-radius: 999px; background: #f6b900; opacity: 0; animation: fcpSparkBurst 1.25s ease-out infinite; }
    .fcp-fireworks span:nth-child(2) { background: #22c55e; animation-delay: 0.12s; }
    .fcp-fireworks span:nth-child(3) { background: #0ea5e9; animation-delay: 0.24s; }
    .fcp-fireworks span:nth-child(4) { background: #ef4444; animation-delay: 0.36s; }
    .fcp-fireworks span:nth-child(5) { background: #a855f7; animation-delay: 0.48s; }
    @keyframes fcpSparkBurst {
        0% { opacity: 0; transform: translate(-50%, -50%) scale(0.35); }
        20% { opacity: 1; }
        100% { opacity: 0; transform: translate(calc(-50% + var(--x)), calc(-50% + var(--y))) scale(0.1); }
    }
    @keyframes fcpTrophyBounce {
        0%, 100% { transform: translateY(0) rotate(-6deg) scale(1); }
        50% { transform: translateY(-5px) rotate(6deg) scale(1.08); }
    }
    @media(max-width: 600px) {
        .report-meta, .report-footer { grid-template-columns: 1fr; }
        .report-meta > div { border-right: 0; }
        .report-head { padding: 14px 70px; min-height: 92px; }
        .report-head__logo { width: 54px; height: 54px; }
        .report-head__logo--left { left: 12px; }
        .report-head__logo--right { right: 12px; }
    }
    @media print {
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .full-results-report { border: 1px solid #12372a !important; margin: 0 !important; width: 100% !important; }
        .full-results-report .report-head { min-height: 76px; padding: 8px 96px; }
        .full-results-report .report-head__logo { width: 58px; height: 58px; }
        .full-results-report .report-head__logo--left { left: 44px; }
        .full-results-report .report-head__logo--right { right: 44px; }
        .full-results-report .f2-ribbon { padding: 6px 8px; }
        .report-page { break-after: page; page-break-after: always; }
        .report-page:last-child { break-after: auto; page-break-after: auto; }
        .report-page + .report-page { margin-top: 0; }
        .full-results-report .table-responsive { overflow: visible !important; }
        .full-results-table { font-size: 7pt; width: 100% !important; table-layout: fixed; }
        .full-results-table th, .full-results-table td { padding: 3px 4px; }
        .full-results-table th:nth-child(1), .full-results-table td:nth-child(1) { width: 46px; }
        .full-results-table th:nth-child(2), .full-results-table td:nth-child(2) { width: 120px; }
        .full-results-table th:nth-child(3), .full-results-table td:nth-child(3) { width: 82px; }
        .full-results-table th:nth-child(4), .full-results-table td:nth-child(4) { width: 32px; }
        .full-results-table th:nth-child(5), .full-results-table td:nth-child(5) { width: auto; }
        .full-results-table th:nth-last-child(-n+5), .full-results-table td:nth-last-child(-n+5) { width: 54px; }
        .full-results-table thead { display: table-header-group; }
        .full-results-table tr { break-inside: avoid; page-break-inside: avoid; }
        .subject-marks-cell { min-width: 0; line-height: 1.35; white-space: normal; overflow-wrap: anywhere; }
        .division-celebration i, .division-celebration span { animation: none !important; }
        .fcp-winner-trophy, .fcp-fireworks span { animation: none !important; }
    }
</style>
