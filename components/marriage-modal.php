<style>
    /* Your existing CSS styles remain exactly the same */
    .modal-dialog {
        max-width: 1200px;
    }

    .modal-content {
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        background-color: #F5F5F5;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border-bottom: 1px solid var(--border);
    }

    .modal-title {
        font-weight: 700;
    }

    .btn-close {
        filter: invert(1);
    }

    /* Stepper */
    .stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }

    .stepper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--border);
        z-index: 1;
    }

    .step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step::before {
        content: attr(data-step);
        width: 40px;
        height: 40px;
        background: white;
        border: 2px solid var(--border);
        border-radius: 50%;
        display: block;
        margin: 0 auto 10px;
        line-height: 36px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .step.active::before {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .step.completed::before {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .step.incomplete::before {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .step span {
        font-size: 0.8rem;
        color: var(--light-text);
        transition: all 0.3s;
    }

    .step.active span {
        color: var(--primary);
        font-weight: 600;
    }

    .step.completed span {
        color: #28a745;
        font-weight: 600;
    }

    .step.incomplete span {
        color: #dc3545;
        font-weight: 600;
    }

    .step-completion-indicator {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: #28a745;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        z-index: 3;
    }

    .step-completion-indicator.visible {
        display: flex;
    }

    .step-completion-indicator.incomplete {
        background: #dc3545;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Duplicate Alert */
    .duplicate-alert {
        background: #FFF3E0;
        border: 1px solid #FFB74D;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 16px;
        display: none;
        color: #E65100;
    }

    /* Form Styling */
    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label {
        color: var(--primary);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(255, 152, 0, 0.25);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: var(--text);
    }

    .summary-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .section-title {
        color: var(--primary);
        font-weight: 700;
        border-bottom: 2px solid var(--primary-light);
        padding-bottom: 8px;
        margin-bottom: 20px;
        
    }

    .subsection-title {
        color: var(--secondary);
        font-weight: 600;
        font-size: 0.9rem;
        margin: 15px 0 10px 0;
        padding-bottom: 5px;
        border-bottom: 1px solid var(--border);
    }

    @media (max-width: 768px) {
        .stepper {
            flex-wrap: wrap;
            gap: 10px;
        }

        .step {
            flex: 0 0 calc(33.333% - 10px);
        }
    }

    @media (max-width: 576px) {
        .step {
            flex: 0 0 calc(50% - 10px);
        }
    }

    .form-check.is-invalid .form-check-input {
        border-color: #dc3545;
    }

    .form-check.is-invalid .form-check-label {
        color: #dc3545;
    }

    /* Summary styling */
    .summary-item {
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .summary-item:last-child {
        border-bottom: none;
    }
</style>

<!-- Add Marriage Certificate Modal -->
<div class="modal fade" id="addMarriageModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Marriage Record</h5>
                <button type="button" class="btn-close" id="closeMarriageModalBtn"></button>
            </div>
            <div class="modal-body">
                <!-- Duplicate Alert -->
                <div id="duplicateMarriageAlert" class="alert alert-warning" style="display: none;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="duplicateMarriageMessage"></span>
                            <div id="similarMarriageRecordsList" style="display: none;"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning" id="viewMarriageDuplicateBtn" style="display: none;" onclick="viewDuplicateMarriageRecords()">
                            <i class="fas fa-search me-1"></i> View Similar Records
                        </button>
                    </div>
                </div>

                <form id="marriageCertForm">
                    <!-- Step Progress Indicator -->
                    <div class="stepper">
                        <div class="step active" data-step="1">
                            <span>Basic Info</span>
                            <div class="step-completion-indicator" id="step1Indicator"></div>
                        </div>
                        <div class="step" data-step="2">
                            <span>Husband</span>
                            <div class="step-completion-indicator" id="step2Indicator"></div>
                        </div>
                        <div class="step" data-step="3">
                            <span>Wife</span>
                            <div class="step-completion-indicator" id="step3Indicator"></div>
                        </div>
                        <div class="step" data-step="4">
                            <span>Marriage Details</span>
                            <div class="step-completion-indicator" id="step4Indicator"></div>
                        </div>
                        <div class="step" data-step="5">
                            <span>Witnesses</span>
                            <div class="step-completion-indicator" id="step5Indicator"></div>
                        </div>
                        <div class="step" data-step="6">
                            <span>Finalize</span>
                            <div class="step-completion-indicator" id="step6Indicator"></div>
                        </div>
                    </div>

                    <!-- ALL YOUR EXISTING FORM STEPS REMAIN EXACTLY THE SAME -->
                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" id="step1">
                        <h5 class="section-title">Basic Marriage Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="date_of_marriage" required>
                                    <label>Date of Marriage *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="time" class="form-control" name="time_of_marriage" required>
                                    <label>Time of Marriage *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="province" required>
                                    <label>Province *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="city_municipality" required>
                                    <label>City/Municipality *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="place_of_marriage" required>
                                    <label>Place of Marriage (Church/Municipality) *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="marriage_type" required>
                                        <option value="">Select Type</option>
                                        <option value="Civil">Civil</option>
                                        <option value="Church">Church</option>
                                        <option value="Tribal">Tribal</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Type of Marriage *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="license_number" required>
                                    <label>Marriage License Number *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="license_date" required>
                                    <label>License Date *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="license_place" required>
                                    <label>Place Issued *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="property_regime" required>
                                        <option value="">Select Property Regime</option>
                                        <option value="Absolute Community">Absolute Community</option>
                                        <option value="Conjugal Partnership">Conjugal Partnership</option>
                                        <option value="Separation of Property">Separation of Property</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Property Regime *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Husband's Information -->
                    <div class="form-step" id="step2">
                        <h5 class="section-title">Husband's Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_middle_name">
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="husband_birthdate" required>
                                    <label>Date of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_birthplace" required>
                                    <label>Place of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="husband_sex" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label>Sex *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_citizenship" required>
                                    <label>Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_religion">
                                    <label>Religion</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="husband_civil_status" required>
                                        <option value="">Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Annulled">Annulled</option>
                                    </select>
                                    <label>Civil Status at Time of Marriage *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_occupation">
                                    <label>Occupation</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="husband_address" style="height: 80px" required></textarea>
                                    <label>Complete Address *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Parent's Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_father_name" required>
                                    <label>Father's Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_father_citizenship" required>
                                    <label>Father's Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_mother_name" required>
                                    <label>Mother's Maiden Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_mother_citizenship" required>
                                    <label>Mother's Citizenship *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Consent Information (if applicable)</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_consent_giver">
                                    <label>Name of Consent Giver</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_consent_relationship">
                                    <label>Relationship</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="husband_consent_address">
                                    <label>Consent Giver Address</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Wife's Information -->
                    <div class="form-step" id="step3">
                        <h5 class="section-title">Wife's Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_middle_name">
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="wife_birthdate" required>
                                    <label>Date of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_birthplace" required>
                                    <label>Place of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="wife_sex" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label>Sex *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_citizenship" required>
                                    <label>Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_religion">
                                    <label>Religion</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="wife_civil_status" required>
                                        <option value="">Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Annulled">Annulled</option>
                                    </select>
                                    <label>Civil Status at Time of Marriage *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_occupation">
                                    <label>Occupation</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="wife_address" style="height: 80px" required></textarea>
                                    <label>Complete Address *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Parent's Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_father_name" required>
                                    <label>Father's Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_father_citizenship" required>
                                    <label>Father's Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_mother_name" required>
                                    <label>Mother's Maiden Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_mother_citizenship" required>
                                    <label>Mother's Citizenship *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Consent Information (if applicable)</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_consent_giver">
                                    <label>Name of Consent Giver</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_consent_relationship">
                                    <label>Relationship</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="wife_consent_address">
                                    <label>Consent Giver Address</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Marriage Details -->
                    <div class="form-step" id="step4">
                        <h5 class="section-title">Marriage Ceremony Details</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="officiating_officer" required>
                                    <label>Officiating Officer/Priest *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="officiant_title">
                                    <label>Officiant Title/Position</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="officiant_license">
                                    <label>Officiant License Number</label>
                                </div>
                            </div>

                            <!-- Marriage License Details -->
                            <div class="col-12">
                                <h6 class="subsection-title">Marriage License Details</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="license_number_ceremony">
                                    <label>License Number</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="license_date_ceremony">
                                    <label>License Date</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="license_place_ceremony">
                                    <label>Place Issued</label>
                                </div>
                            </div>

                            <!-- Legal Basis -->
                            <div class="col-12">
                                <h6 class="subsection-title">Legal Basis</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="legal_basis">
                                        <option value="">Select Legal Basis</option>
                                        <option value="Executive Order 209">Executive Order No. 209</option>
                                        <option value="Presidential Decree 1083">Presidential Decree No. 1083</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Legal Basis for Marriage</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="legal_basis_article">
                                    <label>Article/Provision (if applicable)</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="marriage_remarks" style="height: 100px"></textarea>
                                    <label>Additional Remarks/Certification Details</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Witnesses -->
                    <div class="form-step" id="step5">
                        <h5 class="section-title">Witness Information</h5>
                        <div class="row g-3">
                            <!-- Primary Witness 1 -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness1_name" required>
                                    <label>Witness 1 Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness1_address" required>
                                    <label>Witness 1 Address *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness1_relationship">
                                    <label>Relationship to Couple</label>
                                </div>
                            </div>

                            <!-- Primary Witness 2 -->
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness2_name" required>
                                    <label>Witness 2 Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness2_address" required>
                                    <label>Witness 2 Address *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="witness2_relationship">
                                    <label>Relationship to Couple</label>
                                </div>
                            </div>

                            <!-- Additional Witnesses Note -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Additional witnesses can be added in the remarks section if needed.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Finalize -->
                    <div class="form-step" id="step6">
                        <h5 class="section-title">Review and Submit</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Please review all information before submitting.
                            Once submitted, the record will be added to the system.
                        </div>

                        <div class="summary-card p-3 border rounded mb-3">
                            <h6 class="fw-bold">Marriage Record Summary</h6>
                            <div id="marriageFormSummary">
                                <!-- Summary will be populated by JavaScript -->
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-sync fa-spin me-2"></i>
                                    Loading summary...
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmMarriageAccuracy" required>
                            <label class="form-check-label" for="confirmMarriageAccuracy">
                                I confirm that all information provided is accurate to the best of my knowledge
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light" id="prevMarriageBtn">Previous</button>
                        <button type="button" class="btn btn-primary" id="nextMarriageBtn">Next</button>
                        <button type="submit" class="btn btn-success d-none" id="submitMarriageBtn">Save Marriage Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>