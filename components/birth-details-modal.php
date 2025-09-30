<!-- birth-details-modal.php -->
<div class="modal fade" id="birthDetailsModal" tabindex="-1" aria-labelledby="birthDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="birthDetailsModalLabel">
                    <i class="fas fa-baby me-2"></i>Birth Record Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Loading State -->
                <div id="modalLoadingState" class="text-center py-5">
                    <div class="loading-spinner"></div>
                    <p class="mt-3 text-muted">Loading record details...</p>
                </div>

                <!-- Record Details Content -->
                <div id="modalRecordDetails" style="display: none;">
                    <div class="p-4">
                        <!-- Child Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-baby text-primary me-2"></i>Child Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Registry Number</div>
                                    <div class="info-value" id="modalRegistryNumber">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value" id="modalChildFullName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Sex</div>
                                    <div class="info-value" id="modalChildSex">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value" id="modalDateOfBirth">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Time of Birth</div>
                                    <div class="info-value" id="modalTimeOfBirth">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Birth Weight</div>
                                    <div class="info-value" id="modalBirthWeight">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Type of Birth</div>
                                    <div class="info-value" id="modalTypeOfBirth">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Birth Order</div>
                                    <div class="info-value" id="modalBirthOrder">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Place of Birth</div>
                                    <div class="info-value" id="modalPlaceOfBirth">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Birth Address</div>
                                    <div class="info-value" id="modalBirthAddress">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Birth Notes</div>
                                    <div class="info-value" id="modalBirthNotes">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Mother's Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-female text-primary me-2"></i>Mother's Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value" id="modalMotherFullName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Citizenship</div>
                                    <div class="info-value" id="modalMotherCitizenship">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Religion</div>
                                    <div class="info-value" id="modalMotherReligion">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Occupation</div>
                                    <div class="info-value" id="modalMotherOccupation">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Age at Birth</div>
                                    <div class="info-value" id="modalMotherAge">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Children Born Alive</div>
                                    <div class="info-value" id="modalMotherChildrenBorn">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Children Still Living</div>
                                    <div class="info-value" id="modalMotherChildrenLiving">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Children Deceased</div>
                                    <div class="info-value" id="modalMotherChildrenDeceased">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Residence Address</div>
                                    <div class="info-value" id="modalMotherAddress">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Father's Information Section -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-male text-primary me-2"></i>Father's Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value" id="modalFatherFullName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Citizenship</div>
                                    <div class="info-value" id="modalFatherCitizenship">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Religion</div>
                                    <div class="info-value" id="modalFatherReligion">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Occupation</div>
                                    <div class="info-value" id="modalFatherOccupation">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Age at Birth</div>
                                    <div class="info-value" id="modalFatherAge">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Residence Address</div>
                                    <div class="info-value" id="modalFatherAddress">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Parents Marriage Information -->
                        <div class="section-card" id="modalMarriageSection" style="display: none;">
                            <h4 class="section-title">
                                <i class="fas fa-ring text-primary me-2"></i>Parents Marriage Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Marriage Date</div>
                                    <div class="info-value" id="modalMarriageDate">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Place of Marriage</div>
                                    <div class="info-value" id="modalMarriagePlace">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Birth Attendant Information -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-user-md text-primary me-2"></i>Birth Attendant Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Attendant Type</div>
                                    <div class="info-value" id="modalAttendantType">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Attendant Name</div>
                                    <div class="info-value" id="modalAttendantName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">License Number</div>
                                    <div class="info-value" id="modalAttendantLicense">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Title/Position</div>
                                    <div class="info-value" id="modalAttendantTitle">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Address</div>
                                    <div class="info-value" id="modalAttendantAddress">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Certification</div>
                                    <div class="info-value" id="modalAttendantCertification">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informant Information -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-user-check text-primary me-2"></i>Informant Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value" id="modalInformantFullName">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Relationship to Child</div>
                                    <div class="info-value" id="modalInformantRelationship">-</div>
                                </div>
                                <div class="info-item col-span-2">
                                    <div class="info-label">Address</div>
                                    <div class="info-value" id="modalInformantAddress">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Certification Accepted</div>
                                    <div class="info-value" id="modalInformantCertified">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Information -->
                        <div class="section-card">
                            <h4 class="section-title">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>Registration Information
                            </h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Date Registered</div>
                                    <div class="info-value" id="modalDateRegistered">-</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Record ID</div>
                                    <div class="info-value" id="modalRecordId">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div id="modalErrorState" class="empty-state" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Record Not Found</h4>
                    <p id="modalErrorMessage">The requested birth record could not be found.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="modalPrintBtn">
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