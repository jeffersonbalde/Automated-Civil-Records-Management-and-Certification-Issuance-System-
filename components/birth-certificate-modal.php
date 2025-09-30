<!-- birth-certificate-modal.php -->
<div class="modal fade" id="birthCertificateModal" tabindex="-1" aria-labelledby="birthCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="birthCertificateModalLabel">
                    <i class="fas fa-file-certificate me-2"></i>Generate Birth Certificate
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="certificateLoadingState" class="text-center py-5">
                    <div class="loading-spinner"></div>
                    <p class="mt-3 text-muted">Loading certificate data...</p>
                </div>

                <!-- Certificate Preview -->
                <div id="certificatePreview" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Preview the certificate below. Click "Generate PDF" to download the official certificate.
                    </div>

                    <!-- Certificate Template with proper text wrapping -->
                    <div id="certificateContent" class="certificate-container"
                        style="font-family: 'Times New Roman', Times, serif; border: 2px solid #000; padding: 30px; background: white; max-width: 21cm; margin: 0 auto;">
                        <!-- Certificate content will be populated here -->
                    </div>
                </div>

                <!-- Error State -->
                <div id="certificateErrorState" class="empty-state" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Certificate Generation Failed</h4>
                    <p id="certificateErrorMessage">Unable to generate certificate.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-success" id="generatePdfBtn" style="display: none;">
                    <i class="fas fa-download me-2"></i>Generate PDF
                </button>
                <button type="button" class="btn btn-primary" id="printCertificateBtn" style="display: none;">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .certificate-container {
        font-family: 'Times New Roman', Times, serif;
        line-height: 1.4;
        color: #000;
        background: white;
        page-break-inside: avoid;
    }

    .certificate-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
    }

    .certificate-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-section {
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .form-label {
        font-weight: bold;
        font-size: 11px;
        display: block;
        margin-bottom: 3px;
    }

    .form-value {
        border-bottom: 1px solid #000;
        min-height: 22px;
        padding: 2px 8px;
        font-size: 12px;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .form-value-long {
        border-bottom: 1px solid #000;
        min-height: 22px;
        padding: 2px 8px;
        font-size: 12px;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        line-height: 1.3;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 12px;
    }

    .form-grid-5 {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        margin-bottom: 12px;
    }

    .signature-section {
        margin-top: 35px;
        border-top: 1px solid #000;
        padding-top: 15px;
        page-break-inside: avoid;
    }

    .signature-line {
        border-bottom: 1px solid #000;
        margin-bottom: 30px;
        padding-bottom: 8px;
    }

    .text-wrap {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    @media print {
        .certificate-container {
            border: none;
            padding: 20px;
            max-width: none;
        }

        .modal-header,
        .modal-footer {
            display: none !important;
        }

        body {
            background: white !important;
        }
    }

    .certificate-subtitle {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .certificate-main-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-grid-3-top {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 15px;
        border: 1px solid #000;
        padding: 5px;
    }

    .form-grid-3-top .form-section {
        border-right: 1px solid #000;
        padding: 0 5px;
    }

    .form-grid-3-top .form-section:last-child {
        border-right: none;
    }

    .form-grid-3-top .form-label {
        font-weight: bold;
        font-size: 10px;
        margin-bottom: 2px;
    }

    .form-grid-3-top .form-value {
        min-height: 15px;
        font-size: 11px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 12px;
    }

    .form-label-bold {
        font-weight: bold;
        font-size: 11px;
        margin-bottom: 8px;
        display: block;
    }
</style>