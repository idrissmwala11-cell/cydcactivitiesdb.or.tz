<style>
    .report-card-sheet { max-width: 940px; margin: 0 auto; color: #111; }
    .report-head { padding: 16px; text-align: center; border-bottom: 2px solid #12372a; }
    .report-meta { display: grid; grid-template-columns: repeat(2, 1fr); border-bottom: 2px solid #12372a; }
    .report-meta > div { padding: 8px 12px; border-right: 1px solid #12372a; }
    .report-meta > div:nth-child(even) { border-right: 0; }
    .report-footer { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; padding: 12px; }
    .report-page + .report-page { margin-top: 2rem; }
    @media(max-width: 600px) {
        .report-meta, .report-footer { grid-template-columns: 1fr; }
        .report-meta > div { border-right: 0; }
    }
    @media print {
        .report-page { break-after: page; page-break-after: always; }
        .report-page:last-child { break-after: auto; page-break-after: auto; }
        .report-page + .report-page { margin-top: 0; }
    }
</style>
