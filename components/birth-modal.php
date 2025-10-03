<style>
    .modal-dialog {
        /* margin: 20px; */
        /* display: flex;
        align-items: center;
        justify-content: center; */
    }

    .modal-content {
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

    .mb-3 {
        font-weight: 700;
    }
</style>

<!-- Add Birth Certificate Modal -->
<div class="modal fade" id="addBirthModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Birth Record</h5>
                <button type="button" class="btn-close" id="closeModalBtn"></button>
            </div>
            <div class="modal-body">
                <!-- Duplicate Detection Alert
                <div class="duplicate-alert" id="duplicateAlert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Possible Duplicate Detected!</strong> 
                    <span id="duplicateMessage">A record with similar information already exists.</span>
                    <button class="btn btn-sm btn-warning ms-2" id="viewDuplicateBtn">View Similar Records</button>
                </div> -->

                <!-- Duplicate Alert -->
                <div id="duplicateAlert" class="alert alert-warning" style="display: none;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="duplicateMessage"></span>
                            <div id="similarRecordsList" style="display: none;"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning" id="viewDuplicateBtn" style="display: none;" onclick="viewDuplicateRecords()">
                            <i class="fas fa-search me-1"></i> View Similar Records
                        </button>
                    </div>
                </div>

                <form id="birthCertForm">
                    <!-- Step Progress Indicator -->
                    <div class="stepper">
                        <div class="step active" data-step="1">
                            <span>Child Info</span>
                            <div class="step-completion-indicator" id="step1Indicator"></div>
                        </div>
                        <div class="step" data-step="2">
                            <span>Mother</span>
                            <div class="step-completion-indicator" id="step2Indicator"></div>
                        </div>
                        <div class="step" data-step="3">
                            <span>Father</span>
                            <div class="step-completion-indicator" id="step3Indicator"></div>
                        </div>
                        <div class="step" data-step="4">
                            <span>Parents Marriage</span>
                            <div class="step-completion-indicator" id="step4Indicator"></div>
                        </div>
                        <div class="step" data-step="5">
                            <span>Birth Details</span>
                            <div class="step-completion-indicator" id="step5Indicator"></div>
                        </div>
                        <div class="step" data-step="6">
                            <span>Attendant</span>
                            <div class="step-completion-indicator" id="step6Indicator"></div>
                        </div>
                        <div class="step" data-step="7">
                            <span>Informant</span>
                            <div class="step-completion-indicator" id="step7Indicator"></div>
                        </div>
                        <div class="step" data-step="8">
                            <span>Finalize</span>
                            <div class="step-completion-indicator" id="step8Indicator"></div>
                        </div>
                    </div>

                    <!-- ALL YOUR EXISTING FORM STEPS REMAIN EXACTLY THE SAME -->
                    <!-- Step 1: Child Info -->
                    <div class="form-step active" id="step1">
                        <h5 class="mb-3">Child Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="child_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="child_middle_name" required>
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="child_last_name" required>
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
                                    <input type="date" class="form-control" name="date_of_birth" required>
                                    <label>Date of Birth *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="place_of_birth" required>
                                    <label>Place of Birth (Hospital/Institution) *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="birth_address_house" placeholder="House No., Street" required>
                                    <label>House No., Street</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="birth_address_barangay" placeholder="Barangay" required>
                                    <label>Barangay</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="birth_address_city" placeholder="City/Municipality" required>
                                    <label>City/Municipality *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="type_of_birth" required>
                                        <option value="">Select Type of Birth</option>
                                        <option value="Single">Single</option>
                                        <option value="Twin">Twin</option>
                                        <option value="Triplet">Triplet</option>
                                        <option value="Quadruplet">Quadruplet</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Type of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="multiple_birth_order" id="multipleBirthOrder" disabled>
                                        <option value="">Select Birth Order</option>
                                        <option value="First">First</option>
                                        <option value="Second">Second</option>
                                        <option value="Third">Third</option>
                                        <option value="Fourth">Fourth</option>
                                        <option value="Fifth">Fifth</option>
                                    </select>
                                    <label>If Multiple Birth, Child was *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="birth_order" min="1" required>
                                    <label>Birth Order (1st, 2nd, 3rd child, etc.) *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Mother's Information -->
                    <div class="form-step" id="step2">
                        <h5 class="mb-3">Mother's Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_middle_name" required>
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_citizenship" required>
                                    <label>Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_religion" required>
                                    <label>Religion/Religious Sect</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="mother_children_born_alive" min="0" required>
                                    <label>Total Children Born Alive *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="mother_children_still_living" min="0" required>
                                    <label>Children Still Living *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="mother_children_deceased" min="0" required>
                                    <label>Children Born Alive but Deceased *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_occupation" required>
                                    <label>Occupation</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="mother_age_at_birth" min="15" max="60" required>
                                    <label>Age at Time of Birth *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="mt-3 mb-2">Mother's Residence</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_house_no" placeholder="House No." required>
                                    <label>House No., St., Barangay</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_barangay" placeholder="Barangay" required>
                                    <label>Barangay *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_city" placeholder="City/Municipality" required>
                                    <label>City/Municipality *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_province" placeholder="Province" required>
                                    <label>Province *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="mother_country" value="Philippines" required>
                                    <label>Country *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Father's Information -->
                    <div class="form-step" id="step3">
                        <h5 class="mb-3">Father's Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_middle_name" required>
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_citizenship" required>
                                    <label>Citizenship *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_religion" required>
                                    <label>Religion/Religious Sect</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_occupation" required>
                                    <label>Occupation</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="father_age_at_birth" min="15" max="80" required>
                                    <label>Age at Time of Birth *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="mt-3 mb-2">Father's Residence</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_house_no" placeholder="House No." required>
                                    <label>House No., St., Barangay</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_barangay" placeholder="Barangay" required>
                                    <label>Barangay *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_city" placeholder="City/Municipality" required>
                                    <label>City/Municipality *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_province" placeholder="Province" required>
                                    <label>Province *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="father_country" value="Philippines" required>
                                    <label>Country *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Parents Marriage Information -->
                    <div class="form-step" id="step4">
                        <h5 class="mb-3">Parents Marriage Information</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Complete this section if parents are married. If not married, leave blank.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="marriage_date">
                                    <label>Date of Marriage</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="marriage_place_city" placeholder="City/Municipality">
                                    <label>Place of Marriage (City/Municipality)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="marriage_place_province" placeholder="Province">
                                    <label>Province</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="marriage_place_country" placeholder="Country" value="Philippines">
                                    <label>Country</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Birth Details -->
                    <div class="form-step" id="step5">
                        <h5 class="mb-3">Birth Details</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="time" class="form-control" name="time_of_birth" required>
                                    <label>Time of Birth *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="birth_weight" step="0.01" min="0.5" max="5.0" required>
                                    <label>Birth Weight (kg) *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="birth_notes" style="height: 100px" placeholder="Any additional birth details"></textarea>
                                    <label>Additional Birth Notes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Attendant Information -->
                    <div class="form-step" id="step6">
                        <h5 class="mb-3">Birth Attendant Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="attendant_type" required>
                                        <option value="">Select Attendant Type</option>
                                        <option value="Physician">Physician</option>
                                        <option value="Nurse">Nurse</option>
                                        <option value="Midwife">Midwife</option>
                                        <option value="Hilot">Hilot (Traditional Birth Attendant)</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Attendant Type *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="attendant_name" required>
                                    <label>Attendant Name *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="attendant_license">
                                    <label>License Number (if applicable)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="attendant_certification" style="height: 80px" required></textarea>
                                    <label>Certification Statement *</label>
                                    <small class="form-text text-muted">"I hereby certify that I attended the birth of the child who was born alive..."</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="attendant_address" required>
                                    <label>Attendant Address *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="attendant_title" required>
                                    <label>Title/Position *</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 7: Informant Information -->
                    <div class="form-step" id="step7">
                        <h5 class="mb-3">Informant Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_first_name" required>
                                    <label>First Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_middle_name" required>
                                    <label>Middle Name</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_last_name" required>
                                    <label>Last Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="informant_relationship" required>
                                        <option value="">Select Relationship</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Relative">Relative</option>
                                        <option value="Hospital Staff">Hospital Staff</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label>Relationship to Child *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="informant_address" required>
                                    <label>Address *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="informantCertification" required>
                                    <label class="form-check-label" for="informantCertification">
                                        I hereby certify that all information supplied are true and correct to my own knowledge and belief.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 8: Finalize -->
                    <div class="form-step" id="step8">
                        <h5 class="mb-3">Review and Submit</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Please review all information before submitting.
                            Once submitted, the record will be added to the system.
                        </div>

                        <div class="summary-card p-3 border rounded mb-3">
                            <h6 class="fw-bold">Record Summary</h6>
                            <div id="formSummary">
                                <!-- Summary will be populated by JavaScript -->
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmAccuracy" required>
                            <label class="form-check-label" for="confirmAccuracy">
                                I confirm that all information provided is accurate to the best of my knowledge
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-light" id="prevBtn">Previous</button>
                        <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>