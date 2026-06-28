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
    }
</style>
