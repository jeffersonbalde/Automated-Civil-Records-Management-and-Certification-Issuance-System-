<style>
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

    .checkbox-group {
        display: flex;
        gap: 20px;
        margin: 10px 0;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin: 10px 0;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

<!-- Add Death Certificate Modal -->
<div class="modal fade" id="addDeathModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Death Record</h5>
                <button type="button" class="btn-close" id="closeDeathModalBtn"></button>
            </div>
            <div class="modal-body">
                <!-- Duplicate Alert -->
                <div id="duplicateDeathAlert" class="alert alert-warning" style="display: none;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="duplicateDeathMessage"></span>
                            <div id="similarDeathRecordsList" style="display: none;"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning" id="viewDeathDuplicateBtn" style="display: none;" onclick="viewDuplicateDeathRecords()">
                            <i class="fas fa-search me-1"></i> View Similar Records
                        </button>
                    </div>
                </div>

                <form id="deathCertForm">
                    <!-- Step Progress Indicator -->
                    <div class="stepper">
                        <div class="step active" data-step="1">
                            <span>Personal Info</span>
                            <div class="step-completion-indicator" id="step1Indicator"></div>
                        </div>
                        <div class="step" data-step="2">
                            <span>Medical Info</span>
                            <div class="step-completion-indicator" id="step2Indicator"></div>
                        </div>
                        <div class="step" data-step="3">
                            <span>Death Certification</span>
                            <div class="step-completion-indicator" id="step3Indicator"></div>
                        </div>
                        <div class="step" data-step="4">
                            <span>Burial Details</span>
                            <div class="step-completion-indicator" id="step4Indicator"></div>
                        </div>
                        <div class="step" data-step="5">
                            <span>Informant</span>
                            <div class="step-completion-indicator" id="step5Indicator"></div>
                        </div>
                        <div class="step" data-step="6">
                            <span>Finalize</span>
                            <div class="step-completion-indicator" id="step6Indicator"></div>
                        </div>
                    </div>

                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step1">
                        <h5 class="section-title">Personal Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="middle_name" required>
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="sex" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label>Sex *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="civil_status" required>
                                        <option value="">Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Annulled">Annulled</option>
                                    </select>
                                    <label>Civil Status *</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="date_of_death" required>
                                    <label>Date of Death *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="date_of_birth" required>
                                    <label>Date of Birth *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Age at Time of Death</h6>
                                <div class="row g-3">
                                    <!-- In the Age at Time of Death section -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <!-- Remove min="0" from age_years -->
                                            <input type="number" class="form-control" name="age_years" required>
                                            <label>Completed Years (if 1 year or above)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkbox-group">
                                            <div class="checkbox-item">
                                                <input type="checkbox" name="age_under_1"> Under 1 year
                                            </div>
                                        </div>
                                        <div class="row g-2 mt-2">
                                            <!-- Remove min/max constraints from age fields -->
                                            <div class="col-3">
                                                <input type="number" class="form-control" name="age_months" placeholder="Months">
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control" name="age_days" placeholder="Days">
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control" name="age_hours" placeholder="Hours">
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control" name="age_minutes" placeholder="Minutes">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="place_of_death" style="height: 80px" required></textarea>
                                    <label>Place of Death (Hospital/Clinic/Institution/House No., St., Barangay, City/Municipality, Province) *</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="religion" required>
                                    <label>Religion/Religious Sect</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="citizenship" required>
                                    <label>Citizenship *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="residence" style="height: 80px" required></textarea>
                                    <label>Residence (House No., St., Barangay, City/Municipality, Province, Country) *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="occupation" required>
                                    <label>Occupation</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Parents Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_name" required>
                                    <label>Name of Father *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_maiden_name" required>
                                    <label>Maiden Name of Mother *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Medical Information -->
                    <div class="form-step" id="step2">
                        <h5 class="section-title">Medical Certificate Information</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <h6 class="subsection-title">Causes of Death</h6>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="immediate_cause" required>
                                    <label>I. Immediate cause *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="antecedent_cause" required>
                                    <label>Antecedent cause</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="underlying_cause" required>
                                    <label>Underlying cause</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="other_significant_conditions" required>
                                    <label>II. Other significant conditions contributing to death</label>
                                </div>
                            </div>

                            <div class="col-12" id="maternalConditionSection" style="display: none;">
                                <h6 class="subsection-title">Maternal Condition (If female aged 15-49 years old)</h6>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="maternal_condition" value="Pregnant"> Pregnant
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="maternal_condition" value="Pregnant, in labour"> Pregnant, in labour
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="maternal_condition" value="Less than 42 days after delivery"> Less than 42 days after delivery
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="maternal_condition" value="42 days to 1 year after delivery"> 42 days to 1 year after delivery
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="maternal_condition" value="None of the above"> None of the above
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Death by External Causes</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="manner_of_death" required>
                                    <label>Manner of death (Homicide, Suicide, Accident, etc.)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="place_of_occurrence" required>
                                    <label>Place of occurrence (home, farm, factory, street, sea, etc.)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="autopsy" requried>
                                        <option value="">Autopsy Performed?</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <label>Autopsy</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="attendant" required>
                                        <option value="">Select Attendant</option>
                                        <option value="Private Physician">Private Physician</option>
                                        <option value="Public Health Officer">Public Health Officer</option>
                                        <option value="Hospital Authority">Hospital Authority</option>
                                    <option value="None">None</option>
                                        <option value="Others">Others (Specify)</option>
                                    </select>
                                    <label>Attendant *</label>
                                </div>
                            </div>

                            <div class="col-12" id="attendantOtherSection" style="display: none;">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="attendant_other">
                                    <label>Specify Other Attendant</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="attended_from">
                                    <label>If attended, duration from</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="attended_to">
                                    <label>If attended, duration to</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Death Certification -->
                    <div class="form-step" id="step3">
                        <h5 class="section-title">Certification of Death</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    "I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I [ ] have attended / [ ] have not attended the deceased and that death occurred at ___ am/pm on the date of death specified above."
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="certifier_signature" required>
                                    <label>Signature</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="certifier_name" required>
                                    <label>Name in Print *</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="certifier_title" required>
                                    <label>Title or Position</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="certifier_address" required>
                                    <label>Address</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="certifier_date" required>
                                    <label>Date</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="attended_deceased" required>
                                        <option value="">Attended Deceased?</option>
                                        <option value="Yes">Have attended</option>
                                        <option value="No">Have not attended</option>
                                    </select>
                                    <label>Attended Status</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="death_occurred_time" required>
                                    <label>Time of Death Occurrence (am/pm)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Burial Details -->
                    <div class="form-step" id="step4">
                        <h5 class="section-title">Corpse Disposal and Burial Details</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="corpse_disposal" required>
                                        <option value="">Select Disposal Method</option>
                                        <option value="Burial">Burial</option>
                                        <option value="Cremation">Cremation</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Corpse Disposal</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Burial/Cremation Permit</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="burial_permit_number" required>
                                    <label>Permit Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="burial_permit_date" required>
                                    <label>Date Issued</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="subsection-title">Transfer Permit</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="transfer_permit_number" required>
                                    <label>Transfer Permit Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="transfer_permit_date" required>
                                    <label>Transfer Permit Date Issued</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="cemetery_name" required>
                                    <label>Name of Cemetery or Crematory</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="cemetery_address" style="height: 80px" required></textarea>
                                    <label>Address of Cemetery or Crematory</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Informant Information -->
                    <div class="form-step" id="step5">
                        <h5 class="section-title">Informant Certification</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    "I hereby certify that all information supplied are true and correct to my own knowledge and belief."
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_signature" required>
                                    <label>Signature</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_name" required>
                                    <label>Name in Print *</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_relationship" required>
                                    <label>Relationship to the Deceased *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_address" required>
                                    <label>Address</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="informant_date" required>
                                    <label>Date</label>
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
                            <h6 class="fw-bold">Death Record Summary</h6>
                            <div id="deathFormSummary">
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-sync fa-spin me-2"></i>
                                    Loading summary...
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmDeathAccuracy" required>
                            <label class="form-check-label" for="confirmDeathAccuracy">
                                I confirm that all information provided is accurate to the best of my knowledge
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light" id="prevDeathBtn">Previous</button>
                        <button type="button" class="btn btn-primary" id="nextDeathBtn">Next</button>
                        <button type="submit" class="btn btn-success d-none" id="submitDeathBtn">Save Death Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide maternal condition based on sex and age
    document.addEventListener('DOMContentLoaded', function() {
        const sexSelect = document.querySelector('select[name="sex"]');
        const maternalSection = document.getElementById('maternalConditionSection');

        if (sexSelect) {
            sexSelect.addEventListener('change', function() {
                if (this.value === 'Female') {
                    maternalSection.style.display = 'block';
                } else {
                    maternalSection.style.display = 'none';
                }
            });
        }

        // Show/hide attendant other field
        const attendantSelect = document.querySelector('select[name="attendant"]');
        const attendantOtherSection = document.getElementById('attendantOtherSection');

        if (attendantSelect) {
            attendantSelect.addEventListener('change', function() {
                if (this.value === 'Others') {
                    attendantOtherSection.style.display = 'block';
                } else {
                    attendantOtherSection.style.display = 'none';
                }
            });
        }
    });
</script>