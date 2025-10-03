// Modal-specific JavaScript - KEEPING ALL YOUR EXISTING FUNCTIONALITY
document.addEventListener('DOMContentLoaded', function () {
    // Multi-step form functionality - ALL YOUR EXISTING CODE
    const steps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.step');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    let currentStep = 0;

    // NEW: Display similar records in the alert
    function displaySimilarRecords(similarRecords) {
        const similarRecordsList = document.getElementById('similarRecordsList');
        const viewDuplicateBtn = document.getElementById('viewDuplicateBtn');

        if (similarRecords.length > 0) {
            let recordsHTML = '<div class="mt-2"><strong>Similar Records:</strong><ul class="mb-2">';

            similarRecords.slice(0, 3).forEach((record) => {
                const recordDate = new Date(record.date_of_birth).toLocaleDateString();
                const regDate = new Date(record.date_registered).toLocaleDateString();
                recordsHTML += `
                <li class="small">
                    <strong>${record.child_first_name} ${record.child_last_name}</strong> 
                    - Born: ${recordDate} 
                    - Reg: ${record.registry_number}
                    - Place: ${record.place_of_birth || 'N/A'}
                </li>
            `;
            });

            recordsHTML += '</ul></div>';

            if (similarRecords.length > 3) {
                recordsHTML += `<small class="text-muted">... and ${similarRecords.length - 3} more similar records</small>`;
            }

            similarRecordsList.innerHTML = recordsHTML;
            similarRecordsList.style.display = 'block';
            viewDuplicateBtn.style.display = 'inline-block';
        }
    }

    // NEW: View duplicate records in a modal
    function viewDuplicateRecords() {
        const childFirstName = document.querySelector('input[name="child_first_name"]').value.trim();
        const childLastName = document.querySelector('input[name="child_last_name"]').value.trim();
        const dob = document.querySelector('input[name="date_of_birth"]').value;

        const isEditMode = document.getElementById('birthCertForm').dataset.editId;
        const birthId = isEditMode || null;

        const checkData = {
            action: 'find_similar',
            child_first_name: childFirstName,
            child_last_name: childLastName,
            date_of_birth: dob,
        };

        if (isEditMode) {
            checkData.birth_id = birthId;
        }

        const endpoint = isEditMode ? '../../handlers/update-birth-record.php' : '../../handlers/save-birth-record.php';

        // Show loading in modal
        const duplicateModal = new bootstrap.Modal(document.getElementById('duplicateRecordsModal'));
        const modalBody = document.querySelector('#duplicateRecordsModal .modal-body');
        modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="loading-spinner mb-3"></div>
            <p>Loading similar records...</p>
        </div>
    `;
        duplicateModal.show();

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(checkData),
        })
            .then((response) => response.json())
            .then((result) => {
                if (result.similar_records && result.similar_records.length > 0) {
                    let modalContent = `
                <h6>Similar Records Found (${result.similar_records.length})</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Reg No.</th>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Place of Birth</th>
                                <th>Date Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                    result.similar_records.forEach((record) => {
                        const recordDate = new Date(record.date_of_birth).toLocaleDateString();
                        const regDate = new Date(record.date_registered).toLocaleDateString();
                        modalContent += `
                    <tr>
                        <td>${record.registry_number}</td>
                        <td>${record.child_first_name} ${record.child_middle_name || ''} ${record.child_last_name}</td>
                        <td>${recordDate}</td>
                        <td>${record.place_of_birth || 'N/A'}</td>
                        <td>${regDate}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewDuplicateRecord(${record.birth_id})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });

                    modalContent += `
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3">
                    <small><i class="fas fa-info-circle"></i> These are records with similar names. Please review to avoid creating duplicates.</small>
                </div>
            `;

                    modalBody.innerHTML = modalContent;
                } else {
                    modalBody.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                    <h6>No Similar Records Found</h6>
                    <p class="text-muted">No similar records were found in the system.</p>
                </div>
            `;
                }
            })
            .catch((error) => {
                console.error('Error loading similar records:', error);
                modalBody.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> Error loading similar records. Please try again.
            </div>
        `;
            });
    }

    // NEW: View a specific duplicate record
    function viewDuplicateRecord(birthId) {
        if (typeof birthManager !== 'undefined') {
            // Close the duplicate modal first
            const duplicateModal = bootstrap.Modal.getInstance(document.getElementById('duplicateRecordsModal'));
            duplicateModal.hide();

            // Open the birth details modal for the selected record
            setTimeout(() => {
                birthManager.openBirthDetailsModal(birthId);
            }, 300);
        }
    }

    // NEW: Setup real-time duplicate checking
    function setupRealTimeDuplicateChecking() {
        const firstNameInput = document.querySelector('input[name="child_first_name"]');
        const lastNameInput = document.querySelector('input[name="child_last_name"]');
        const dobInput = document.querySelector('input[name="date_of_birth"]');

        let duplicateCheckTimeout;

        [firstNameInput, lastNameInput, dobInput].forEach((input) => {
            if (input) {
                input.addEventListener('input', function () {
                    clearTimeout(duplicateCheckTimeout);
                    duplicateCheckTimeout = setTimeout(() => {
                        checkForDuplicates();
                    }, 1000); // Check after 1 second of inactivity
                });

                input.addEventListener('blur', function () {
                    clearTimeout(duplicateCheckTimeout);
                    checkForDuplicates();
                });
            }
        });
    }

    // NEW: Check if form has data
    // IMPROVED: Check if form has data - more comprehensive
    function hasFormData() {
        // If modal is still loading, don't show confirmation
        if (isModalLoading()) {
            return false;
        }

        const form = document.getElementById('birthCertForm');
        const inputs = form.querySelectorAll('input, select, textarea');

        for (let input of inputs) {
            // Skip the confirmation checkbox and loading-related fields
            if (input.id === 'confirmAccuracy' || input.classList.contains('loading-field')) {
                continue;
            }

            // Check different input types
            if (input.type === 'checkbox' || input.type === 'radio') {
                if (input.checked) return true;
            } else if (input.type === 'select-one' || input.type === 'select-multiple') {
                if (input.value && input.value !== '') return true;
            } else {
                if (input.value && input.value.trim() !== '') return true;
            }
        }
        return false;
    }

    // NEW: Show Toastify notification
    function showToast(message, type = 'success') {
        const backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
        const className = type === 'success' ? 'success-toast' : 'error-toast';

        Toastify({
            text: message,
            duration: 5000,
            gravity: 'top',
            position: 'right',
            stopOnFocus: true,
            className: className,
            style: {
                background: backgroundColor,
                borderRadius: '8px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                fontFamily: 'inherit',
                fontSize: '14px',
                fontWeight: '500',
            },
            onClick: function () {
                // Close toast on click
                this.hideToast();
            },
        }).showToast();
    }

    // NEW: Show SweetAlert confirmation
    function showConfirmation(title, text, icon = 'warning') {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'custom-swal-confirm',
                cancelButton: 'custom-swal-cancel',
            },
            background: 'var(--bg-color, #fff)',
            color: 'var(--text-color, #000)',
        });
    }

    // NEW: Show saving indicator using SweetAlert
    function showSavingIndicator() {
        return Swal.fire({
            title: 'Saving Birth Record',
            text: 'Please wait while we save your record...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'custom-swal-popup',
            },
            background: 'var(--bg-color, #fff)',
            color: 'var(--text-color, #000)',
        });
    }

    // ALL YOUR EXISTING FUNCTIONS REMAIN EXACTLY THE SAME
    // Enable/disable multiple birth order based on type of birth
    function handleBirthTypeChange() {
        const birthType = document.querySelector('select[name="type_of_birth"]');
        const multipleBirthOrder = document.getElementById('multipleBirthOrder');

        if (birthType.value === 'Single') {
            multipleBirthOrder.disabled = true;
            multipleBirthOrder.value = '';
            multipleBirthOrder.removeAttribute('required');
        } else {
            multipleBirthOrder.disabled = false;
            multipleBirthOrder.setAttribute('required', 'required');
        }
    }

    function showStep(step) {
        steps.forEach((el, index) => {
            el.classList.toggle('active', index === step);
        });

        stepIndicators.forEach((el, index) => {
            el.classList.toggle('active', index === step);
        });

        prevBtn.style.display = step === 0 ? 'none' : 'inline-block';
        nextBtn.style.display = step === steps.length - 1 ? 'none' : 'inline-block';
        submitBtn.classList.toggle('d-none', step !== steps.length - 1);

        // Update summary on final step
        if (step === steps.length - 1) {
            updateFormSummary();
        }
    }

    // Check if a step is completed
    function isStepCompleted(stepIndex) {
        const stepElement = steps[stepIndex];
        const requiredFields = stepElement.querySelectorAll('[required]');
        let isComplete = true;

        // Special handling for step 4 (Parents Marriage) - it's optional
        if (stepIndex === 3) {
            // Step 4 is index 3
            return true; // Always mark as completed since it's optional
        }

        // Special handling for step 7 (Informant) - checkbox is not required
        if (stepIndex === 6) {
            // Step 7 is index 6
            const requiredFieldsWithoutCheckbox = stepElement.querySelectorAll(
                'input[required]:not([type="checkbox"]), select[required], textarea[required]',
            );
            requiredFieldsWithoutCheckbox.forEach((field) => {
                if (!field.value.trim()) {
                    isComplete = false;
                }
            });
            return isComplete;
        }

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                isComplete = false;
            }
        });

        return isComplete;
    }

    // Update step completion indicators
    function updateStepIndicators() {
        stepIndicators.forEach((step, index) => {
            const indicator = document.getElementById(`step${index + 1}Indicator`);
            if (isStepCompleted(index)) {
                step.classList.add('completed');
                indicator.classList.add('visible');
            } else {
                step.classList.remove('completed');
                indicator.classList.remove('visible');
            }
        });
    }

    function validateStep(step) {
        const currentStepElement = steps[step];
        let requiredFields;

        // Special handling for step 1 (Child Information) - multiple_birth_order is only required if type_of_birth is not Single
        if (step === 0) {
            const birthType = document.querySelector('select[name="type_of_birth"]');
            const multipleBirthOrder = document.querySelector('select[name="multiple_birth_order"]');

            // Remove required attribute if birth type is Single
            if (birthType.value === 'Single') {
                multipleBirthOrder.removeAttribute('required');
            } else {
                multipleBirthOrder.setAttribute('required', 'required');
            }

            requiredFields = currentStepElement.querySelectorAll('[required]');
        }
        // Special handling for step 7 (Informant) - ALL fields including checkbox are required
        else if (step === 6) {
            requiredFields = currentStepElement.querySelectorAll('[required]');
        } else {
            requiredFields = currentStepElement.querySelectorAll('[required]');
        }

        let isValid = true;

        // First, remove all existing error messages for this step
        const existingErrors = currentStepElement.querySelectorAll('.invalid-feedback');
        existingErrors.forEach((error) => error.remove());

        // Remove all invalid classes first
        requiredFields.forEach((field) => {
            field.classList.remove('is-invalid');
            // For checkboxes, also remove invalid class from parent
            if (field.type === 'checkbox') {
                field.closest('.form-check')?.classList.remove('is-invalid');
            }
        });

        // Now validate each field
        requiredFields.forEach((field) => {
            let fieldIsValid = true;

            if (field.type === 'checkbox') {
                // For checkboxes, check if they're checked
                if (!field.checked) {
                    fieldIsValid = false;
                    isValid = false;
                }
            } else if (field.type === 'number') {
                // For number fields, check if they have value and meet min/max requirements
                const value = parseFloat(field.value);
                const min = parseFloat(field.min);
                const max = parseFloat(field.max);

                if (isNaN(value) || field.value.trim() === '') {
                    fieldIsValid = false;
                    isValid = false;
                } else if (!isNaN(min) && value < min) {
                    fieldIsValid = false;
                    isValid = false;
                } else if (!isNaN(max) && value > max) {
                    fieldIsValid = false;
                    isValid = false;
                }
            } else {
                // For other fields, check if they have value
                if (!field.value.trim()) {
                    fieldIsValid = false;
                    isValid = false;
                }
            }

            if (!fieldIsValid) {
                field.classList.add('is-invalid');
                // For checkboxes, also add invalid class to parent for styling
                if (field.type === 'checkbox') {
                    field.closest('.form-check')?.classList.add('is-invalid');
                }

                // Create error message only if it doesn't exist
                if (!field.parentNode.querySelector('.invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';

                    if (field.type === 'checkbox') {
                        errorDiv.textContent = 'You must accept this certification to proceed.';
                        // Insert after the form-check element for checkboxes
                        field.closest('.form-check')?.parentNode?.appendChild(errorDiv);
                    } else if (field.type === 'number') {
                        const min = parseFloat(field.min);
                        const max = parseFloat(field.max);
                        if (!isNaN(min) && !isNaN(max)) {
                            errorDiv.textContent = `Please enter a value between ${min} and ${max}`;
                        } else if (!isNaN(min)) {
                            errorDiv.textContent = `Please enter a value greater than or equal to ${min}`;
                        } else if (!isNaN(max)) {
                            errorDiv.textContent = `Please enter a value less than or equal to ${max}`;
                        } else {
                            errorDiv.textContent = 'This field is required.';
                        }
                        field.parentNode.appendChild(errorDiv);
                    } else {
                        errorDiv.textContent = 'This field is required.';
                        field.parentNode.appendChild(errorDiv);
                    }
                }
            } else {
                field.classList.remove('is-invalid');
                // For checkboxes, also remove invalid class from parent
                if (field.type === 'checkbox') {
                    field.closest('.form-check')?.classList.remove('is-invalid');
                }
                // Remove error message if field is now valid
                const existingError = field.parentNode.querySelector('.invalid-feedback');
                if (existingError) {
                    existingError.remove();
                }
            }
        });

        return isValid;
    }

    function setupRealTimeValidation() {
        const allRequiredFields = document.querySelectorAll('#birthCertForm [required]');

        allRequiredFields.forEach((field) => {
            // Validate on input change
            field.addEventListener('input', function () {
                // Special handling for type_of_birth changes
                if (this.name === 'type_of_birth') {
                    handleBirthTypeChange();
                    updateStepIndicators();
                    return;
                }

                const currentStepElement = steps[currentStep];
                let currentStepRequiredFields;

                // Special handling for step 1 - adjust required fields based on birth type
                if (currentStep === 0) {
                    const birthType = document.querySelector('select[name="type_of_birth"]');
                    const multipleBirthOrder = document.querySelector('select[name="multiple_birth_order"]');

                    if (birthType.value === 'Single') {
                        multipleBirthOrder.removeAttribute('required');
                    } else {
                        multipleBirthOrder.setAttribute('required', 'required');
                    }

                    currentStepRequiredFields = currentStepElement.querySelectorAll('[required]');
                }
                // Special handling for step 7 (Informant)
                else if (currentStep === 6) {
                    currentStepRequiredFields = currentStepElement.querySelectorAll(
                        'input[required]:not([type="checkbox"]), select[required], textarea[required]',
                    );
                } else {
                    currentStepRequiredFields = currentStepElement.querySelectorAll('[required]');
                }

                // Check if this field belongs to current step
                let isInCurrentStep = false;
                currentStepRequiredFields.forEach((stepField) => {
                    if (stepField === field) {
                        isInCurrentStep = true;
                    }
                });

                if (isInCurrentStep) {
                    if (field.value.trim()) {
                        field.classList.remove('is-invalid');
                        const errorMessage = field.parentNode.querySelector('.invalid-feedback');
                        if (errorMessage) {
                            errorMessage.remove();
                        }
                    } else {
                        field.classList.add('is-invalid');
                        if (!field.parentNode.querySelector('.invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'This field is required.';
                            field.parentNode.appendChild(errorDiv);
                        }
                    }
                }

                // Update step indicators after input
                updateStepIndicators();
            });

            // Validate on blur (when user leaves the field)
            field.addEventListener('blur', function () {
                const currentStepElement = steps[currentStep];
                let currentStepRequiredFields;

                if (currentStep === 6) {
                    currentStepRequiredFields = currentStepElement.querySelectorAll(
                        'input[required]:not([type="checkbox"]), select[required], textarea[required]',
                    );
                } else {
                    currentStepRequiredFields = currentStepElement.querySelectorAll('[required]');
                }

                let isInCurrentStep = false;
                currentStepRequiredFields.forEach((stepField) => {
                    if (stepField === field) {
                        isInCurrentStep = true;
                    }
                });

                if (isInCurrentStep && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    if (!field.parentNode.querySelector('.invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'This field is required.';
                        field.parentNode.appendChild(errorDiv);
                    }
                }

                // Update step indicators after blur
                updateStepIndicators();
            });
        });

        // Also update indicators when checkbox changes (for step 7)
        document.getElementById('informantCertification').addEventListener('change', updateStepIndicators);
        document.getElementById('finalizeCertification').addEventListener('change', updateStepIndicators);
    }

    function updateFormSummary() {
        const form = document.getElementById('birthCertForm');
        const summary = document.getElementById('formSummary');

        const childName = `${form.child_first_name.value} ${form.child_middle_name.value} ${form.child_last_name.value}`;
        const motherName = `${form.mother_first_name.value} ${form.mother_middle_name.value} ${form.mother_last_name.value}`;
        const fatherName = `${form.father_first_name.value} ${form.father_middle_name.value} ${form.father_last_name.value}`;

        let summaryHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Child:</strong> ${childName}<br>
                        <strong>DOB:</strong> ${form.date_of_birth.value}<br>
                        <strong>Sex:</strong> ${form.sex.value}<br>
                        <strong>Type of Birth:</strong> ${form.type_of_birth.value}<br>
                        <strong>Birth Order:</strong> ${form.birth_order.value}
                    </div>
                    <div class="col-md-6">
                        <strong>Mother:</strong> ${motherName}<br>
                        <strong>Age at Birth:</strong> ${form.mother_age_at_birth.value}<br>
                        <strong>Father:</strong> ${fatherName}<br>
                        <strong>Age at Birth:</strong> ${form.father_age_at_birth.value}<br>
                        <strong>Birth Weight:</strong> ${form.birth_weight.value} kg
                    </div>
                </div>
            `;

        summary.innerHTML = summaryHTML;
    }

    nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);

                if (currentStep === 1) {
                    checkForDuplicates();
                }
            }
        } else {
            // Scroll to first error if validation fails
            const firstError = steps[currentStep].querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }

        // Update indicators after step change
        updateStepIndicators();
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 0) {
            // Clear validation errors when going back
            const currentStepElement = steps[currentStep];
            const errors = currentStepElement.querySelectorAll('.invalid-feedback');
            errors.forEach((error) => error.remove());

            const invalidFields = currentStepElement.querySelectorAll('.is-invalid');
            invalidFields.forEach((field) => field.classList.remove('is-invalid'));

            currentStep--;
            showStep(currentStep);
        }

        // Update indicators after step change
        updateStepIndicators();
    });

    // MODIFIED: Form submission - now shows SweetAlert confirmation
    // UPDATED: Form submission - with immediate modal close and proper loading states
    // ENHANCED: Now supports both create and edit operations
    document.getElementById('birthCertForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate all steps before final submission
        let allStepsValid = true;
        for (let i = 0; i < steps.length - 1; i++) {
            if (!validateStep(i)) {
                allStepsValid = false;
                // Show the first invalid step
                currentStep = i;
                showStep(currentStep);
                break;
            }
        }

        if (!allStepsValid) {
            showToast('Please complete all required fields before submitting.', 'error');
            return;
        }

        if (!document.getElementById('confirmAccuracy').checked) {
            showToast('Please confirm the accuracy of the information before submitting.', 'error');
            return;
        }

        // Check if we're in edit mode
        const isEditMode = this.dataset.editId;
        const actionText = isEditMode ? 'update' : 'save';

        // UPDATE SUBMIT BUTTON TEXT BASED ON MODE
        const submitBtn = document.getElementById('submitBtn');
        if (isEditMode) {
            submitBtn.textContent = 'Update Record';
        } else {
            submitBtn.textContent = 'Save Record';
        }

        // Show SweetAlert confirmation
        showConfirmation(
            `Confirm ${isEditMode ? 'Update' : 'Save'}`,
            `Are you sure you want to ${isEditMode ? 'update' : 'save'} this birth record? Please verify all information before proceeding.`,
            'question',
        ).then((result) => {
            if (result.isConfirmed) {
                // IMMEDIATELY disable the submit button to prevent multiple clicks
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${isEditMode ? 'Updating...' : 'Saving...'}`;

                // Show saving indicator
                Swal.fire({
                    title: `${isEditMode ? 'Updating' : 'Saving'} Birth Record`,
                    text: `Please wait while we ${isEditMode ? 'update' : 'save'} your record...`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        popup: 'custom-swal-popup',
                    },
                    background: 'var(--bg-color, #fff)',
                    color: 'var(--text-color, #000)',
                });

                // Collect form data
                const formData = new FormData(document.getElementById('birthCertForm'));
                const data = Object.fromEntries(formData.entries());

                // Add action type
                data.action = isEditMode ? 'update_birth_record' : 'save_birth_record';

                // Add birth ID if in edit mode
                if (isEditMode) {
                    data.birth_id = isEditMode;
                }

                // Determine the endpoint URL
                const endpoint = isEditMode
                    ? '../../handlers/update-birth-record.php'
                    : '../../handlers/save-birth-record.php';

                // Send data to server
                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                    .then((response) => response.json())
                    .then((result) => {
                        // Close saving indicator
                        Swal.close();

                        if (result.success) {
                            // IMMEDIATELY close the modal first
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                            modal.hide();

                            // Show success Toastify notification
                            Toastify({
                                text: isEditMode
                                    ? 'Birth record updated successfully!'
                                    : 'Birth record saved successfully!',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                style: {
                                    background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                },
                                stopOnFocus: true,
                                callback: function () {
                                    reloadBirthPageData();
                                },
                            }).showToast();

                            // Also reload data after delay
                            setTimeout(() => {
                                reloadBirthPageData();
                            }, 1000);

                            // Reset form and edit mode
                            if (isEditMode) {
                                delete this.dataset.editId;
                            }
                        } else {
                            showToast(result.message, 'error');
                            // Re-enable submit button on error
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = isEditMode ? 'Update Record' : 'Save Record';
                        }
                    })
                    .catch((error) => {
                        // Close saving indicator
                        Swal.close();
                        console.error('Error:', error);
                        showToast(`An error occurred while ${isEditMode ? 'updating' : 'saving'} the record.`, 'error');
                        // Re-enable submit button on error
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = isEditMode ? 'Update Record' : 'Save Record';
                    });
            }
        });
    });

    // NEW: Function to reload birth page data with proper loading states
    function reloadBirthPageData() {
        // Check if birthManager exists and call its methods
        if (typeof birthManager !== 'undefined') {
            // Show loading states for both stats and table
            birthManager.showInitialLoading();
            birthManager.loadRecords();
        } else {
            // Fallback: reload page if birthManager is not available
            window.location.reload();
        }

        // Reset form and steps
        resetFormAndSteps();
    }

    // NEW: Function to reset form and steps
    function resetFormAndSteps() {
        const form = document.getElementById('birthCertForm');
        if (form) {
            form.reset();
        }

        // Reset to first step
        const steps = document.querySelectorAll('.step');
        const formSteps = document.querySelectorAll('.form-step');

        if (steps.length > 0 && formSteps.length > 0) {
            // Reset step indicators
            steps.forEach((step, index) => {
                if (index === 0) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });

            // Reset form steps
            formSteps.forEach((step, index) => {
                if (index === 0) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });

            // Reset navigation buttons
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'block';
            if (submitBtn) {
                submitBtn.classList.add('d-none');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Record';
            }

            // Reset current step
            currentStep = 0;
        }

        // Clear validation errors
        const allErrors = document.querySelectorAll('.invalid-feedback');
        allErrors.forEach((error) => error.remove());

        const allInvalidFields = document.querySelectorAll('.is-invalid');
        allInvalidFields.forEach((field) => field.classList.remove('is-invalid'));

        // Hide duplicate alert
        document.getElementById('duplicateAlert').style.display = 'none';
    }

    // MODIFIED: Close modal button handler - now uses SweetAlert
    // MODIFIED: Close modal button handler - now uses SweetAlert and checks for form data
    document.getElementById('closeModalBtn').addEventListener('click', function () {
        // Don't show confirmation if modal is still loading
        if (isModalLoading()) {
            console.log('Modal is loading, skipping close confirmation');
            return;
        }

        if (hasFormData()) {
            // Show SweetAlert confirmation only if there's form data AND not loading
            showConfirmation(
                'Unsaved Changes',
                'You have unsaved changes. Are you sure you want to exit? All progress will be lost.',
                'warning',
            ).then((result) => {
                if (result.isConfirmed) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                    modal.hide();
                    resetFormAndSteps();
                }
            });
        } else {
            // No data, close directly without confirmation
            const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
            modal.hide();
            resetFormAndSteps();
        }
    });

    // ALL YOUR EXISTING FUNCTIONS REMAIN THE SAME
    // Duplicate detection
    function checkForDuplicates() {
        const childFirstName = document.querySelector('input[name="child_first_name"]').value;
        const childLastName = document.querySelector('input[name="child_last_name"]').value;
        const dob = document.querySelector('input[name="date_of_birth"]').value;

        if (childFirstName && childLastName && dob) {
            setTimeout(() => {
                const hasDuplicate = Math.random() > 0.7;
                if (hasDuplicate) {
                    const duplicateAlert = document.getElementById('duplicateAlert');
                    const duplicateMessage = document.getElementById('duplicateMessage');

                    duplicateMessage.textContent = `A record for ${childFirstName} ${childLastName} born on ${dob} already exists.`;
                    duplicateAlert.style.display = 'block';

                    duplicateAlert.classList.add('animate__animated', 'animate__headShake');
                    setTimeout(() => {
                        duplicateAlert.classList.remove('animate__animated', 'animate__headShake');
                    }, 1000);
                }
            }, 500);
        }
    }

    // View duplicate records
    document.getElementById('viewDuplicateBtn').addEventListener('click', function () {
        alert('This would show similar records in a modal or new page.');
    });

    // Birth type change handler
    document.querySelector('select[name="type_of_birth"]').addEventListener('change', handleBirthTypeChange);

    // Reset form when modal is closed
    document.getElementById('addBirthModal').addEventListener('hidden.bs.modal', function () {
        // Reset birth manager state
        if (typeof birthManager !== 'undefined') {
            birthManager.isModalLoading = false;
            birthManager.currentEditId = null;
            birthManager.pendingEditRequest = null;
        }

        // Clear all validation errors
        const allErrors = document.querySelectorAll('.invalid-feedback');
        allErrors.forEach((error) => error.remove());

        const allInvalidFields = document.querySelectorAll('.is-invalid');
        allInvalidFields.forEach((field) => field.classList.remove('is-invalid'));

        document.getElementById('birthCertForm').reset();

        // Reset to first step
        const steps = document.querySelectorAll('.form-step');
        const stepIndicators = document.querySelectorAll('.step');

        steps.forEach((step, index) => {
            if (index === 0) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        stepIndicators.forEach((step, index) => {
            if (index === 0) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });

        // Reset current step
        if (typeof currentStep !== 'undefined') {
            currentStep = 0;
        }

        document.getElementById('duplicateAlert').style.display = 'none';

        // Reset edit mode
        delete document.getElementById('birthCertForm').dataset.editId;
        document.querySelector('#addBirthModal .modal-title').textContent = 'Add New Birth Record';
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.textContent = 'Save Record';
        }

        // Reset indicators
        if (typeof updateStepIndicators !== 'undefined') {
            updateStepIndicators();
        }
    });

    // ADD THIS METHOD TO CHECK IF MODAL IS LOADING
    function isModalLoading() {
        const loadingOverlay = document.querySelector('#addBirthModal .modal-loading-overlay');
        return loadingOverlay && loadingOverlay.style.display !== 'none';
    }

    // Initialize
    showStep(currentStep);
    setupRealTimeValidation();
    handleBirthTypeChange(); // Initial call to set proper state
    updateStepIndicators(); // Initial call to set step indicators
    // Initialize duplicate checking
    setupRealTimeDuplicateChecking();
});
