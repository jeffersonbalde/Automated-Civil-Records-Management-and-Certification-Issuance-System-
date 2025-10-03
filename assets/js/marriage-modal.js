// Marriage Modal JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Multi-step form functionality
    const steps = document.querySelectorAll('#marriageCertForm .form-step');
    const stepIndicators = document.querySelectorAll('#marriageCertForm .step');
    const nextBtn = document.getElementById('nextMarriageBtn');
    const prevBtn = document.getElementById('prevMarriageBtn');
    const submitBtn = document.getElementById('submitMarriageBtn');
    let currentStep = 0;

    // NEW: Check if a step is completed
    function isStepCompleted(stepIndex) {
        const stepElement = steps[stepIndex];
        const requiredFields = stepElement.querySelectorAll('[required]');
        let isComplete = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                isComplete = false;
            }
        });

        return isComplete;
    }

    // NEW: Update step completion indicators
    function updateStepIndicators() {
        stepIndicators.forEach((step, index) => {
            const indicator = document.getElementById(`step${index + 1}Indicator`);

            if (isStepCompleted(index)) {
                step.classList.add('completed');
                step.classList.remove('incomplete');
                indicator.classList.add('visible');
                indicator.classList.remove('incomplete');
                indicator.innerHTML = '<i class="fas fa-check"></i>';
            } else {
                step.classList.remove('completed');
                step.classList.add('incomplete');
                indicator.classList.add('visible', 'incomplete');
                indicator.innerHTML = '<i class="fas fa-times"></i>';
            }
        });
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

        // Update summary on final step with a small delay to ensure DOM is ready
        if (step === steps.length - 1) {
            setTimeout(() => {
                updateMarriageFormSummary();
            }, 100);
        }

        // Update indicators after step change
        updateStepIndicators();
    }

    function validateStep(step) {
        const currentStepElement = steps[step];
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        // Remove all existing error messages for this step
        const existingErrors = currentStepElement.querySelectorAll('.invalid-feedback');
        existingErrors.forEach((error) => error.remove());

        // Remove all invalid classes first
        requiredFields.forEach((field) => {
            field.classList.remove('is-invalid');
        });

        // Validate each field
        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;

                // Create error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'This field is required.';
                field.parentNode.appendChild(errorDiv);
            }
        });

        // Update indicators after validation
        updateStepIndicators();

        return isValid;
    }

    function setupRealTimeValidation() {
        const allRequiredFields = document.querySelectorAll('#marriageCertForm [required]');

        allRequiredFields.forEach((field) => {
            field.addEventListener('input', function () {
                if (field.value.trim()) {
                    field.classList.remove('is-invalid');
                    const errorMessage = field.parentNode.querySelector('.invalid-feedback');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }

                // Update indicators after input
                updateStepIndicators();
            });

            field.addEventListener('blur', function () {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    if (!field.parentNode.querySelector('.invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'This field is required.';
                        field.parentNode.appendChild(errorDiv);
                    }
                }

                // Update indicators after blur
                updateStepIndicators();
            });
        });

        // Also update indicators when checkbox changes
        document.getElementById('confirmMarriageAccuracy').addEventListener('change', updateStepIndicators);
    }

    function updateMarriageFormSummary() {
        const form = document.getElementById('marriageCertForm');
        const summary = document.getElementById('marriageFormSummary');

        if (!form || !summary) return;

        // Get form data using FormData
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Format names properly
        const husbandName =
            `${data.husband_first_name || ''} ${data.husband_middle_name || ''} ${data.husband_last_name || ''}`
                .trim()
                .replace(/\s+/g, ' ');
        const wifeName = `${data.wife_first_name || ''} ${data.wife_middle_name || ''} ${data.wife_last_name || ''}`
            .trim()
            .replace(/\s+/g, ' ');

        // Format time if available
        const marriageTime = data.time_of_marriage
            ? new Date('1970-01-01T' + data.time_of_marriage).toLocaleTimeString('en-US', {
                  hour: '2-digit',
                  minute: '2-digit',
                  hour12: true,
              })
            : 'Not specified';

        // Format dates
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            try {
                return new Date(dateString).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                });
            } catch (e) {
                return 'Invalid Date';
            }
        };

        const summaryHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="subsection-title">Basic Information</h6>
                <div class="summary-item">
                    <strong>Date of Marriage:</strong> ${formatDate(data.date_of_marriage)}
                </div>
                <div class="summary-item">
                    <strong>Time of Marriage:</strong> ${marriageTime}
                </div>
                <div class="summary-item">
                    <strong>Place:</strong> ${data.place_of_marriage || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Type:</strong> ${data.marriage_type || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Property Regime:</strong> ${data.property_regime || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Location & License</h6>
                <div class="summary-item">
                    <strong>Province:</strong> ${data.province || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>City/Municipality:</strong> ${data.city_municipality || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>License Number:</strong> ${data.license_number || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>License Date:</strong> ${formatDate(data.license_date)}
                </div>
                <div class="summary-item">
                    <strong>Place Issued:</strong> ${data.license_place || 'N/A'}
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="subsection-title">Husband's Information</h6>
                <div class="summary-item">
                    <strong>Name:</strong> ${husbandName || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Birthdate:</strong> ${formatDate(data.husband_birthdate)}
                </div>
                <div class="summary-item">
                    <strong>Birthplace:</strong> ${data.husband_birthplace || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Citizenship:</strong> ${data.husband_citizenship || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Civil Status:</strong> ${data.husband_civil_status || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Address:</strong> ${data.husband_address || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Wife's Information</h6>
                <div class="summary-item">
                    <strong>Name:</strong> ${wifeName || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Birthdate:</strong> ${formatDate(data.wife_birthdate)}
                </div>
                <div class="summary-item">
                    <strong>Birthplace:</strong> ${data.wife_birthplace || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Citizenship:</strong> ${data.wife_citizenship || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Civil Status:</strong> ${data.wife_civil_status || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Address:</strong> ${data.wife_address || 'N/A'}
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="subsection-title">Marriage Details</h6>
                <div class="summary-item">
                    <strong>Officiating Officer:</strong> ${data.officiating_officer || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Officiant Title:</strong> ${data.officiant_title || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Legal Basis:</strong> ${data.legal_basis || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Witnesses</h6>
                <div class="summary-item">
                    <strong>Witness 1:</strong> ${data.witness1_name || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Witness 1 Address:</strong> ${data.witness1_address || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Witness 2:</strong> ${data.witness2_name || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Witness 2 Address:</strong> ${data.witness2_address || 'N/A'}
                </div>
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
            }
        } else {
            const firstError = steps[currentStep].querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 0) {
            const currentStepElement = steps[currentStep];
            const errors = currentStepElement.querySelectorAll('.invalid-feedback');
            errors.forEach((error) => error.remove());

            const invalidFields = currentStepElement.querySelectorAll('.is-invalid');
            invalidFields.forEach((field) => field.classList.remove('is-invalid'));

            currentStep--;
            showStep(currentStep);
        }
    });

    // Form submission
    document.getElementById('marriageCertForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate all steps
        let allStepsValid = true;
        for (let i = 0; i < steps.length - 1; i++) {
            if (!validateStep(i)) {
                allStepsValid = false;
                currentStep = i;
                showStep(currentStep);
                break;
            }
        }

        if (!allStepsValid) {
            showToast('Please complete all required fields before submitting.', 'error');
            return;
        }

        if (!document.getElementById('confirmMarriageAccuracy').checked) {
            showToast('Please confirm the accuracy of the information before submitting.', 'error');
            return;
        }

        const isEditMode = this.dataset.editId;
        const actionText = isEditMode ? 'update' : 'save';

        // Show confirmation
        showConfirmation(
            `Confirm ${isEditMode ? 'Update' : 'Save'}`,
            `Are you sure you want to ${isEditMode ? 'update' : 'save'} this marriage record?`,
            'question',
        ).then((result) => {
            if (result.isConfirmed) {
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${isEditMode ? 'Updating...' : 'Saving...'}`;

                // Show saving indicator
                Swal.fire({
                    title: `${isEditMode ? 'Updating' : 'Saving'} Marriage Record`,
                    text: `Please wait while we ${isEditMode ? 'update' : 'save'} your record...`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Collect form data
                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());
                data.action = isEditMode ? 'update_marriage_record' : 'save_marriage_record';

                if (isEditMode) {
                    data.marriage_id = isEditMode;
                }

                const endpoint = isEditMode
                    ? '../../handlers/update-marriage-record.php'
                    : '../../handlers/save-marriage-record.php';

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                    .then((response) => response.json())
                    .then((result) => {
                        Swal.close();

                        if (result.success) {
                            // Close modal immediately
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addMarriageModal'));
                            modal.hide();

                            // Show success message
                            Toastify({
                                text: isEditMode
                                    ? 'Marriage record updated successfully!'
                                    : 'Marriage record saved successfully!',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                style: {
                                    background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                },
                                stopOnFocus: true,
                                callback: function () {
                                    reloadMarriagePageData();
                                },
                            }).showToast();

                            // Reload data
                            setTimeout(() => {
                                reloadMarriagePageData();
                            }, 1000);

                            // Reset edit mode
                            if (isEditMode) {
                                delete this.dataset.editId;
                            }
                        } else {
                            showToast(result.message, 'error');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = isEditMode ? 'Update Marriage Record' : 'Save Marriage Record';
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Error:', error);
                        showToast(`An error occurred while ${isEditMode ? 'updating' : 'saving'} the record.`, 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = isEditMode ? 'Update Marriage Record' : 'Save Marriage Record';
                    });
            }
        });
    });

    function reloadMarriagePageData() {
        if (typeof marriageManager !== 'undefined') {
            marriageManager.showInitialLoading();
            marriageManager.loadRecords();
        } else {
            window.location.reload();
        }
        resetMarriageFormAndSteps();
    }

    function resetMarriageFormAndSteps() {
        const form = document.getElementById('marriageCertForm');
        if (form) {
            form.reset();
        }

        // Reset to first step
        const steps = document.querySelectorAll('#marriageCertForm .step');
        const formSteps = document.querySelectorAll('#marriageCertForm .form-step');

        if (steps.length > 0 && formSteps.length > 0) {
            steps.forEach((step, index) => {
                if (index === 0) {
                    step.classList.add('active');
                    step.classList.remove('completed', 'incomplete');
                } else {
                    step.classList.remove('active', 'completed', 'incomplete');
                }
            });

            formSteps.forEach((step, index) => {
                if (index === 0) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });

            const prevBtn = document.getElementById('prevMarriageBtn');
            const nextBtn = document.getElementById('nextMarriageBtn');
            const submitBtn = document.getElementById('submitMarriageBtn');

            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'block';
            if (submitBtn) {
                submitBtn.classList.add('d-none');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Marriage Record';
            }

            currentStep = 0;
        }

        // Clear validation errors
        const allErrors = document.querySelectorAll('.invalid-feedback');
        allErrors.forEach((error) => error.remove());

        const allInvalidFields = document.querySelectorAll('.is-invalid');
        allInvalidFields.forEach((field) => field.classList.remove('is-invalid'));

        // Hide duplicate alert
        document.getElementById('duplicateMarriageAlert').style.display = 'none';

        // Reset indicators
        updateStepIndicators();
    }

    // NEW FUNCTION: Completely close and reset marriage modal
    function closeMarriageModalCompletely() {
        // Cancel any pending requests from marriage manager
        if (typeof marriageManager !== 'undefined') {
            marriageManager.closeEditModal();
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('addMarriageModal'));
        if (modal) {
            modal.hide();
        }
        
        // Reset form and steps
        resetMarriageFormAndSteps();
        
        // Ensure edit mode is completely reset
        const form = document.getElementById('marriageCertForm');
        if (form && form.dataset.editId) {
            delete form.dataset.editId;
        }

        const modalTitle = document.querySelector('#addMarriageModal .modal-title');
        if (modalTitle) {
            modalTitle.textContent = 'Add New Marriage Record';
        }

        const submitBtn = document.getElementById('submitMarriageBtn');
        if (submitBtn) {
            submitBtn.textContent = 'Save Marriage Record';
        }
    }

    // Close modal handler - IMPROVED VERSION
    document.getElementById('closeMarriageModalBtn').addEventListener('click', function () {
        const form = document.getElementById('marriageCertForm');
        let hasData = false;

        // Check if form has data
        const inputs = form.querySelectorAll('input, select, textarea');
        for (let input of inputs) {
            if (input.value && input.value.trim() !== '' && input.type !== 'checkbox') {
                hasData = true;
                break;
            }
        }

        if (hasData) {
            showConfirmation(
                'Unsaved Changes',
                'You have unsaved changes. Are you sure you want to exit?',
                'warning',
            ).then((result) => {
                if (result.isConfirmed) {
                    closeMarriageModalCompletely();
                }
            });
        } else {
            closeMarriageModalCompletely();
        }
    });

    // Reset form when modal is closed - IMPROVED VERSION
    document.getElementById('addMarriageModal').addEventListener('hidden.bs.modal', function () {
        // Small delay to ensure everything is settled
        setTimeout(() => {
            resetMarriageFormAndSteps();
            
            // Clear any edit mode completely
            const form = document.getElementById('marriageCertForm');
            if (form && form.dataset.editId) {
                delete form.dataset.editId;
            }

            document.querySelector('#addMarriageModal .modal-title').textContent = 'Add New Marriage Record';
            const submitBtn = document.getElementById('submitMarriageBtn');
            if (submitBtn) {
                submitBtn.textContent = 'Save Marriage Record';
            }
            
            // Reset marriage manager state
            if (typeof marriageManager !== 'undefined') {
                marriageManager.isModalLoading = false;
                marriageManager.currentEditId = null;
                marriageManager.pendingEditRequest = null;
            }
        }, 100);
    });

    // Helper functions
    function showToast(message, type = 'success') {
        const backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
        Toastify({
            text: message,
            duration: 5000,
            gravity: 'top',
            position: 'right',
            stopOnFocus: true,
            style: {
                background: backgroundColor,
                borderRadius: '8px',
            },
        }).showToast();
    }

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
        });
    }

    // Add this function to set up real-time summary updates
    function setupRealTimeSummaryUpdates() {
        const form = document.getElementById('marriageCertForm');
        if (!form) return;

        // Listen for input changes on all form fields
        const allFields = form.querySelectorAll('input, select, textarea');
        allFields.forEach((field) => {
            field.addEventListener('input', function () {
                // Only update summary if we're on the final step
                if (currentStep === steps.length - 1) {
                    updateMarriageFormSummary();
                }
            });

            field.addEventListener('change', function () {
                // Only update summary if we're on the final step
                if (currentStep === steps.length - 1) {
                    updateMarriageFormSummary();
                }
            });
        });
    }

    // Initialize
    showStep(currentStep);
    setupRealTimeValidation();
    setupRealTimeSummaryUpdates(); // Add this line
    updateStepIndicators(); // Initial call to set step indicators
});