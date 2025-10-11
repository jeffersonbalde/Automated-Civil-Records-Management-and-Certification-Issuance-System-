<!-- death-certificate-modal.php -->
<div class="modal fade" id="deathCertificateModal" tabindex="-1" aria-labelledby="deathCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="deathCertificateModalLabel">
                    <i class="fas fa-file-certificate me-2"></i>
                    Generate Death Certificate
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="certificateLoadingState" class="text-center py-5">
                    <div class="loading-spinner mb-3"></div>
                    <p class="text-muted">Loading certificate data...</p>
                </div>

                <!-- Error State -->
                <div id="certificateErrorState" class="text-center py-5" style="display: none;">
                    <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-danger">Error Loading Certificate</h5>
                    <p id="certificateErrorMessage" class="text-muted"></p>
                </div>

                <!-- Certificate Preview -->
                <div id="certificatePreview" style="display: none;">
                    <div class="certificate-container border p-4 bg-light">
                        <div id="certificateContent">
                            <!-- Certificate content will be generated here -->
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <button type="button" class="btn btn-success me-2" id="generatePdfBtn">
                            <i class="fas fa-file-pdf me-2"></i>Generate PDF
                        </button>
                        <button type="button" class="btn btn-primary" id="printCertificateBtn">
                            <i class="fas fa-print me-2"></i>Print Certificate
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>