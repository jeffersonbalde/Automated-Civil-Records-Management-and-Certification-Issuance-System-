// Death Modal JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Multi-step form functionality
    const steps = document.querySelectorAll('#deathCertForm .form-step');
    const stepIndicators = document.querySelectorAll('#deathCertForm .step');
    const nextBtn = document.getElementById('nextDeathBtn');
    const prevBtn = document.getElementById('prevDeathBtn');
    const submitBtn = document.getElementById('submitDeathBtn');
    let currentStep = 0;

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

        if (step === steps.length - 1) {
            setTimeout(() => {
                updateDeathFormSummary();
            }, 100);
        }

        updateStepIndicators();
    }

    function validateStep(step) {
        const currentStepElement = steps[step];
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        const existingErrors = currentStepElement.querySelectorAll('.invalid-feedback');
        existingErrors.forEach((error) => error.remove());

        requiredFields.forEach((field) => {
            field.classList.remove('is-invalid');
        });

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;

                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'This field is required.';
                field.parentNode.appendChild(errorDiv);
            }
        });

        updateStepIndicators();

        return isValid;
    }

    function setupRealTimeValidation() {
        const allRequiredFields = document.querySelectorAll('#deathCertForm [required]');

        allRequiredFields.forEach((field) => {
            field.addEventListener('input', function () {
                if (field.value.trim()) {
                    field.classList.remove('is-invalid');
                    const errorMessage = field.parentNode.querySelector('.invalid-feedback');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }

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

                updateStepIndicators();
            });
        });

        document.getElementById('confirmDeathAccuracy').addEventListener('change', updateStepIndicators);
    }

    function updateDeathFormSummary() {
        const form = document.getElementById('deathCertForm');
        const summary = document.getElementById('deathFormSummary');

        if (!form || !summary) return;

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const deceasedName = `${data.first_name || ''} ${data.middle_name || ''} ${data.last_name || ''}`
            .trim()
            .replace(/\s+/g, ' ');

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
                <h6 class="subsection-title">Personal Information</h6>
                <div class="summary-item">
                    <strong>Deceased Name:</strong> ${deceasedName || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Sex:</strong> ${data.sex || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Date of Death:</strong> ${formatDate(data.date_of_death)}
                </div>
                <div class="summary-item">
                    <strong>Date of Birth:</strong> ${formatDate(data.date_of_birth)}
                </div>
                <div class="summary-item">
                    <strong>Civil Status:</strong> ${data.civil_status || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Additional Information</h6>
                <div class="summary-item">
                    <strong>Religion:</strong> ${data.religion || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Citizenship:</strong> ${data.citizenship || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Occupation:</strong> ${data.occupation || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Place of Death:</strong> ${data.place_of_death || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Residence:</strong> ${data.residence || 'N/A'}
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="subsection-title">Parents Information</h6>
                <div class="summary-item">
                    <strong>Father's Name:</strong> ${data.father_name || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Mother's Maiden Name:</strong> ${data.mother_maiden_name || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Medical Information</h6>
                <div class="summary-item">
                    <strong>Immediate Cause:</strong> ${data.immediate_cause || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Antecedent Cause:</strong> ${data.antecedent_cause || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Underlying Cause:</strong> ${data.underlying_cause || 'N/A'}
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h6 class="subsection-title">Death Certification</h6>
                <div class="summary-item">
                    <strong>Certifier Name:</strong> ${data.certifier_name || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Attended Status:</strong> ${data.attended_deceased || 'N/A'}
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="subsection-title">Informant Information</h6>
                <div class="summary-item">
                    <strong>Informant Name:</strong> ${data.informant_name || 'N/A'}
                </div>
                <div class="summary-item">
                    <strong>Relationship:</strong> ${data.informant_relationship || 'N/A'}
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
    document.getElementById('deathCertForm').addEventListener('submit', function (e) {
        e.preventDefault();

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

        if (!document.getElementById('confirmDeathAccuracy').checked) {
            showToast('Please confirm the accuracy of the information before submitting.', 'error');
            return;
        }

        const isEditMode = this.dataset.editId;
        const actionText = isEditMode ? 'update' : 'save';

        showConfirmation(
            `Confirm ${isEditMode ? 'Update' : 'Save'}`,
            `Are you sure you want to ${isEditMode ? 'update' : 'save'} this death record?`,
            'question',
        ).then((result) => {
            if (result.isConfirmed) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${isEditMode ? 'Updating...' : 'Saving...'}`;

                Swal.fire({
                    title: `${isEditMode ? 'Updating' : 'Saving'} Death Record`,
                    text: `Please wait while we ${isEditMode ? 'update' : 'save'} your record...`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());
                data.action = isEditMode ? 'update_death_record' : 'save_death_record';

                if (isEditMode) {
                    data.death_id = isEditMode;
                }

                const endpoint = isEditMode
                    ? '../../handlers/update-death-record.php'
                    : '../../handlers/save-death-record.php';

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
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addDeathModal'));
                            modal.hide();

                            Toastify({
                                text: isEditMode
                                    ? 'Death record updated successfully!'
                                    : 'Death record saved successfully!',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                style: {
                                    background: 'linear-gradient(to right, #00b09b, #96c93d)',
                                },
                                stopOnFocus: true,
                                callback: function () {
                                    reloadDeathPageData();
                                },
                            }).showToast();

                            setTimeout(() => {
                                reloadDeathPageData();
                            }, 1000);

                            if (isEditMode) {
                                delete this.dataset.editId;
                            }
                        } else {
                            showToast(result.message, 'error');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = isEditMode ? 'Update Death Record' : 'Save Death Record';
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Error:', error);
                        showToast(`An error occurred while ${isEditMode ? 'updating' : 'saving'} the record.`, 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = isEditMode ? 'Update Death Record' : 'Save Death Record';
                    });
            }
        });
    });

    function reloadDeathPageData() {
        if (typeof deathManager !== 'undefined') {
            deathManager.showInitialLoading();
            deathManager.loadRecords();
        } else {
            window.location.reload();
        }
        resetDeathFormAndSteps();
    }

    function resetDeathFormAndSteps() {
        const form = document.getElementById('deathCertForm');
        if (form) {
            form.reset();
        }

        const steps = document.querySelectorAll('#deathCertForm .step');
        const formSteps = document.querySelectorAll('#deathCertForm .form-step');

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

            const prevBtn = document.getElementById('prevDeathBtn');
            const nextBtn = document.getElementById('nextDeathBtn');
            const submitBtn = document.getElementById('submitDeathBtn');

            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'block';
            if (submitBtn) {
                submitBtn.classList.add('d-none');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Save Death Record';
            }

            currentStep = 0;
        }

        const allErrors = document.querySelectorAll('.invalid-feedback');
        allErrors.forEach((error) => error.remove());

        const allInvalidFields = document.querySelectorAll('.is-invalid');
        allInvalidFields.forEach((field) => field.classList.remove('is-invalid'));

        document.getElementById('duplicateDeathAlert').style.display = 'none';

        updateStepIndicators();
    }

    function closeDeathModalCompletely() {
        if (typeof deathManager !== 'undefined') {
            deathManager.closeEditModal();
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('addDeathModal'));
        if (modal) {
            modal.hide();
        }

        resetDeathFormAndSteps();

        const form = document.getElementById('deathCertForm');
        if (form && form.dataset.editId) {
            delete form.dataset.editId;
        }

        const modalTitle = document.querySelector('#addDeathModal .modal-title');
        if (modalTitle) {
            modalTitle.textContent = 'Add New Death Record';
        }

        const submitBtn = document.getElementById('submitDeathBtn');
        if (submitBtn) {
            submitBtn.textContent = 'Save Death Record';
        }
    }

    document.getElementById('closeDeathModalBtn').addEventListener('click', function () {
        const form = document.getElementById('deathCertForm');
        let hasData = false;

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
                    closeDeathModalCompletely();
                }
            });
        } else {
            closeDeathModalCompletely();
        }
    });

    document.getElementById('addDeathModal').addEventListener('hidden.bs.modal', function () {
        setTimeout(() => {
            resetDeathFormAndSteps();

            const form = document.getElementById('deathCertForm');
            if (form && form.dataset.editId) {
                delete form.dataset.editId;
            }

            document.querySelector('#addDeathModal .modal-title').textContent = 'Add New Death Record';
            const submitBtn = document.getElementById('submitDeathBtn');
            if (submitBtn) {
                submitBtn.textContent = 'Save Death Record';
            }

            if (typeof deathManager !== 'undefined') {
                deathManager.isModalLoading = false;
                deathManager.currentEditId = null;
                deathManager.pendingEditRequest = null;
            }
        }, 100);
    });

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

    function setupRealTimeSummaryUpdates() {
        const form = document.getElementById('deathCertForm');
        if (!form) return;

        const allFields = form.querySelectorAll('input, select, textarea');
        allFields.forEach((field) => {
            field.addEventListener('input', function () {
                if (currentStep === steps.length - 1) {
                    updateDeathFormSummary();
                }
            });

            field.addEventListener('change', function () {
                if (currentStep === steps.length - 1) {
                    updateDeathFormSummary();
                }
            });
        });
    }

    // Add this function to death-modal.js
    function checkForDeathDuplicates() {
        const form = document.getElementById('deathCertForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Only check if we have the minimum required fields
        if (!data.first_name || !data.last_name || !data.date_of_death || !data.date_of_birth) {
            return;
        }

        data.action = 'check_duplicate';

        fetch('../../handlers/save-death-record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((result) => {
                const duplicateAlert = document.getElementById('duplicateDeathAlert');
                const duplicateMessage = document.getElementById('duplicateDeathMessage');
                const viewDuplicateBtn = document.getElementById('viewDeathDuplicateBtn');
                const similarRecordsList = document.getElementById('similarDeathRecordsList');

                if (result.is_duplicate) {
                    duplicateMessage.textContent = 'A similar death record already exists in the system.';
                    duplicateAlert.style.display = 'block';
                    viewDuplicateBtn.style.display = 'none';
                } else if (result.similar_records && result.similar_records.length > 0) {
                    duplicateMessage.textContent = `Found ${result.similar_records.length} similar record(s). Please review before saving.`;
                    duplicateAlert.style.display = 'block';
                    viewDuplicateBtn.style.display = 'inline-block';

                    // Store similar records for viewing
                    window.similarDeathRecords = result.similar_records;
                } else {
                    duplicateAlert.style.display = 'none';
                }
            })
            .catch((error) => {
                console.error('Error checking duplicates:', error);
            });
    }

    // Add this function to view duplicate records
    function viewDuplicateDeathRecords() {
        if (!window.similarDeathRecords || window.similarDeathRecords.length === 0) {
            return;
        }

        const modalBody = document.querySelector('#duplicateRecordsModal .modal-body');
        let html = '<div class="similar-records-list">';

        window.similarDeathRecords.forEach((record) => {
            html += `
            <div class="similar-record-item border rounded p-3 mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name:</strong> ${record.first_name} ${record.middle_name || ''} ${record.last_name}<br>
                        <strong>Registry No:</strong> ${record.registry_number}
                    </div>
                    <div class="col-md-6">
                        <strong>Date of Death:</strong> ${new Date(record.date_of_death).toLocaleDateString()}<br>
                        <strong>Date of Birth:</strong> ${new Date(record.date_of_birth).toLocaleDateString()}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <small class="text-muted">
                            Registered: ${new Date(record.date_registered).toLocaleDateString()}
                        </small>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';
        modalBody.innerHTML = html;

        const modal = new bootstrap.Modal(document.getElementById('duplicateRecordsModal'));
        modal.show();
    }

    // Add event listeners for real-time duplicate checking
    document.addEventListener('DOMContentLoaded', function () {
        // Add input event listeners for key fields
        const keyFields = ['first_name', 'last_name', 'date_of_death', 'date_of_birth'];

        keyFields.forEach((fieldName) => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                let timeout;
                field.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        checkForDeathDuplicates();
                    }, 1000);
                });
            }
        });
    });

    // Initialize
    showStep(currentStep);
    setupRealTimeValidation();
    setupRealTimeSummaryUpdates();
    updateStepIndicators();
});
