<!-- death-details-modal.php -->
<div class="modal fade" id="deathDetailsModal" tabindex="-1" aria-labelledby="deathDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="deathDetailsModalLabel">
                    <i class="fas fa-file-medical me-2"></i>Death Record Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Loading State -->
                <div id="deathModalLoadingState" class="text-center py-5">
                    <div class="loading-spinner"></div>
                    <p class="mt-3 text-muted">Loading record details...</p>
                </div>

                <!-- Record Details Content -->
                <div id="deathModalRecordDetails" style="display: none;">
                    <div class="p-4">
                        <!-- Personal Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-user text-primary me-2"></i>Personal Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Registry Number</div>
                                    <div class="info-value" id="deathModalRegistryNumber">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value" id="deathModalDeceasedName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Sex</div>
                                    <div class="info-value" id="deathModalSex">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Civil Status</div>
                                    <div class="info-value" id="deathModalCivilStatus">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Date of Death</div>
                                    <div class="info-value" id="deathModalDateOfDeath">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value" id="deathModalDateOfBirth">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Age at Death</div>
                                    <div class="info-value" id="deathModalAge">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Religion</div>
                                    <div class="info-value" id="deathModalReligion">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Citizenship</div>
                                    <div class="info-value" id="deathModalCitizenship">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Occupation</div>
                                    <div class="info-value" id="deathModalOccupation">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Place of Death</div>
                                    <div class="info-value" id="deathModalPlaceOfDeath">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Residence</div>
                                    <div class="info-value" id="deathModalResidence">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Parents Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-users text-primary me-2"></i>Parents Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Father's Name</div>
                                    <div class="info-value" id="deathModalFatherName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Mother's Maiden Name</div>
                                    <div class="info-value" id="deathModalMotherName">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-stethoscope text-primary me-2"></i>Medical Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item col-span-2">
                                    <div class="info-label">Immediate Cause</div>
                                    <div class="info-value" id="deathModalImmediateCause">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Antecedent Cause</div>
                                    <div class="info-value" id="deathModalAntecedentCause">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Underlying Cause</div>
                                    <div class="info-value" id="deathModalUnderlyingCause">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Other Significant Conditions</div>
                                    <div class="info-value" id="deathModalOtherConditions">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Manner of Death</div>
                                    <div class="info-value" id="deathModalMannerOfDeath">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Place of Occurrence</div>
                                    <div class="info-value" id="deathModalPlaceOfOccurrence">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Autopsy Performed</div>
                                    <div class="info-value" id="deathModalAutopsy">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Attendant</div>
                                    <div class="info-value" id="deathModalAttendant">-</div>
                                </div>
                                <div class="info-item" id="deathModalAttendantOtherContainer" style="display: none;">
                                    <div class="info-label">Other Attendant</div>
                                    <div class="info-value" id="deathModalAttendantOther">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Attended Duration</div>
                                    <div class="info-value" id="deathModalAttendedDuration">-</div>
                                </div>
                                <div class="info-item" id="deathModalMaternalConditionContainer" style="display: none;">
                                    <div class="info-label">Maternal Condition</div>
                                    <div class="info-value" id="deathModalMaternalCondition">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Death Certification Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-certificate text-primary me-2"></i>Death Certification
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Certifier Name</div>
                                    <div class="info-value" id="deathModalCertifierName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Certifier Title</div>
                                    <div class="info-value" id="deathModalCertifierTitle">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Attended Deceased</div>
                                    <div class="info-value" id="deathModalAttendedDeceased">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Time of Death</div>
                                    <div class="info-value" id="deathModalDeathOccurredTime">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Certification Date</div>
                                    <div class="info-value" id="deathModalCertifierDate">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Burial Details Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-archive text-primary me-2"></i>Burial Details
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Corpse Disposal</div>
                                    <div class="info-value" id="deathModalCorpseDisposal">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Burial Permit Number</div>
                                    <div class="info-value" id="deathModalBurialPermitNumber">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Burial Permit Date</div>
                                    <div class="info-value" id="deathModalBurialPermitDate">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Transfer Permit Number</div>
                                    <div class="info-value" id="deathModalTransferPermitNumber">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Transfer Permit Date</div>
                                    <div class="info-value" id="deathModalTransferPermitDate">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Cemetery Name</div>
                                    <div class="info-value" id="deathModalCemeteryName">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Cemetery Address</div>
                                    <div class="info-value" id="deathModalCemeteryAddress">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informant Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-user-check text-primary me-2"></i>Informant Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Informant Name</div>
                                    <div class="info-value" id="deathModalInformantName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Relationship to Deceased</div>
                                    <div class="info-value" id="deathModalInformantRelationship">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Informant Date</div>
                                    <div class="info-value" id="deathModalInformantDate">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Informant Address</div>
                                    <div class="info-value" id="deathModalInformantAddress">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>Registration Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Date Registered</div>
                                    <div class="info-value" id="deathModalDateRegistered">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Record ID</div>
                                    <div class="info-value" id="deathModalRecordId">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div id="deathModalErrorState" class="empty-state" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Record Not Found</h4>
                    <p id="deathModalErrorMessage">The requested death record could not be found.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="deathModalPrintBtn">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .section-card {
        background: white;
        border: 1px solid #E0E0E0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        color: #FF9800;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #FFE0B2;
        font-size: 1.1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 15px;
    }

    .info-item {
        margin-bottom: 12px;
    }

    .info-label {
        font-weight: 700;
        color: black;
        font-size: 1rem;
        margin-bottom: 4px;
    }

    .info-value {
        color: #424242;
        font-size: 0.95rem;
        word-break: break-word;
    }

    .col-span-2 {
        grid-column: span 2;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #E0E0E0;
        border-top: 4px solid #FF9800;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #757575;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .col-span-2 {
            grid-column: span 1;
        }
        
        .modal-dialog {
            margin: 10px;
        }
    }

    .modal-content {
        background-color: #F5F5F5;
    }
</style>