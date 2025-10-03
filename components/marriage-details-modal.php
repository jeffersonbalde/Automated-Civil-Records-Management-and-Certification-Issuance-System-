<!-- Marriage Details Modal -->
<div class="modal fade" id="marriageDetailsModal" tabindex="-1" aria-labelledby="marriageDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="marriageDetailsModalLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    Marriage Record Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="marriageModalLoadingState">
                    <div class="text-center py-4">
                        <div class="loading-spinner mb-3"></div>
                        <p class="text-muted">Loading marriage record details...</p>
                    </div>
                </div>

                <!-- Error State -->
                <div id="marriageModalErrorState" style="display: none;">
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="marriageModalErrorMessage">Error loading record details</span>
                    </div>
                </div>

                <!-- Record Details -->
                <div id="marriageModalRecordDetails" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-title">Basic Information</h6>
                            <div class="summary-item">
                                <strong>Registry Number:</strong> <span id="marriageModalRegistryNumber">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Date of Marriage:</strong> <span id="marriageModalDate">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Time of Marriage:</strong> <span id="marriageModalTime">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Place of Marriage:</strong> <span id="marriageModalPlace">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Type of Marriage:</strong> <span id="marriageModalType">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Property Regime:</strong> <span id="marriageModalPropertyRegime">-</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="section-title">Registration Information</h6>
                            <div class="summary-item">
                                <strong>Date Registered:</strong> <span id="marriageModalDateRegistered">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Record ID:</strong> <span id="marriageModalRecordId">-</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-title">Husband's Information</h6>
                            <div class="summary-item">
                                <strong>Full Name:</strong> <span id="marriageModalHusbandName">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Date of Birth:</strong> <span id="marriageModalHusbandBirthdate">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Place of Birth:</strong> <span id="marriageModalHusbandBirthplace">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Citizenship:</strong> <span id="marriageModalHusbandCitizenship">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Religion:</strong> <span id="marriageModalHusbandReligion">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Civil Status:</strong> <span id="marriageModalHusbandCivilStatus">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Occupation:</strong> <span id="marriageModalHusbandOccupation">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Address:</strong> <span id="marriageModalHusbandAddress">-</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="section-title">Wife's Information</h6>
                            <div class="summary-item">
                                <strong>Full Name:</strong> <span id="marriageModalWifeName">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Date of Birth:</strong> <span id="marriageModalWifeBirthdate">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Place of Birth:</strong> <span id="marriageModalWifeBirthplace">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Citizenship:</strong> <span id="marriageModalWifeCitizenship">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Religion:</strong> <span id="marriageModalWifeReligion">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Civil Status:</strong> <span id="marriageModalWifeCivilStatus">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Occupation:</strong> <span id="marriageModalWifeOccupation">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Address:</strong> <span id="marriageModalWifeAddress">-</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="section-title">Husband's Parents</h6>
                            <div class="summary-item">
                                <strong>Father's Name:</strong> <span id="marriageModalHusbandFather">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Mother's Name:</strong> <span id="marriageModalHusbandMother">-</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="section-title">Wife's Parents</h6>
                            <div class="summary-item">
                                <strong>Father's Name:</strong> <span id="marriageModalWifeFather">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Mother's Name:</strong> <span id="marriageModalWifeMother">-</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="section-title">Ceremony Details</h6>
                            <div class="summary-item">
                                <strong>Officiating Officer:</strong> <span id="marriageModalOfficiatingOfficer">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Witness 1:</strong> <span id="marriageModalWitness1">-</span>
                            </div>
                            <div class="summary-item">
                                <strong>Witness 2:</strong> <span id="marriageModalWitness2">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="marriageModalPrintBtn">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>