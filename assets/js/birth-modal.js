// Modal-specific JavaScript - KEEPING ALL YOUR EXISTING FUNCTIONALITY
    document.addEventListener('DOMContentLoaded', function() {
        // Multi-step form functionality - ALL YOUR EXISTING CODE
        const steps = document.querySelectorAll(".form-step");
        const stepIndicators = document.querySelectorAll(".step");
        const nextBtn = document.getElementById("nextBtn");
        const prevBtn = document.getElementById("prevBtn");
        const submitBtn = document.getElementById("submitBtn");
        let currentStep = 0;

        // NEW: Check if form has data
// IMPROVED: Check if form has data - more comprehensive
function hasFormData() {
    const form = document.getElementById('birthCertForm');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    for (let input of inputs) {
        // Skip the confirmation checkbox as it's not actual form data
        if (input.id === 'confirmAccuracy') continue;
        
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
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                className: className,
                style: {
                    background: backgroundColor,
                    borderRadius: '8px',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                    fontFamily: 'inherit',
                    fontSize: '14px',
                    fontWeight: '500'
                },
                onClick: function() {
                    // Close toast on click
                    this.hideToast();
                }
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
                    cancelButton: 'custom-swal-cancel'
                },
                background: 'var(--bg-color, #fff)',
                color: 'var(--text-color, #000)'
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
                    popup: 'custom-swal-popup'
                },
                background: 'var(--bg-color, #fff)',
                color: 'var(--text-color, #000)'
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
                el.classList.toggle("active", index === step);
            });
            
            stepIndicators.forEach((el, index) => {
                el.classList.toggle("active", index === step);
            });

            prevBtn.style.display = step === 0 ? "none" : "inline-block";
            nextBtn.style.display = step === steps.length - 1 ? "none" : "inline-block";
            submitBtn.classList.toggle("d-none", step !== steps.length - 1);

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
            if (stepIndex === 3) { // Step 4 is index 3
                return true; // Always mark as completed since it's optional
            }
            
            // Special handling for step 7 (Informant) - checkbox is not required
            if (stepIndex === 6) { // Step 7 is index 6
                const requiredFieldsWithoutCheckbox = stepElement.querySelectorAll('input[required]:not([type="checkbox"]), select[required], textarea[required]');
                requiredFieldsWithoutCheckbox.forEach(field => {
                    if (!field.value.trim()) {
                        isComplete = false;
                    }
                });
                return isComplete;
            }
            
            requiredFields.forEach(field => {
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
            
            // Special handling for step 7 (Informant) - ALL fields including checkbox are required
            if (step === 6) { // Step 7 is index 6
                requiredFields = currentStepElement.querySelectorAll('[required]');
            } else {
                requiredFields = currentStepElement.querySelectorAll('[required]');
            }
            
            let isValid = true;
            
            // First, remove all existing error messages for this step
            const existingErrors = currentStepElement.querySelectorAll('.invalid-feedback');
            existingErrors.forEach(error => error.remove());
            
            // Remove all invalid classes first
            requiredFields.forEach(field => {
                field.classList.remove('is-invalid');
                // For checkboxes, also remove invalid class from parent
                if (field.type === 'checkbox') {
                    field.closest('.form-check')?.classList.remove('is-invalid');
                }
            });
            
            // Now validate each field
            requiredFields.forEach(field => {
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

        // Real-time validation as user types
        function setupRealTimeValidation() {
            const allRequiredFields = document.querySelectorAll('#birthCertForm [required]');
            
            allRequiredFields.forEach(field => {
                // Validate on input change
                field.addEventListener('input', function() {
                    const currentStepElement = steps[currentStep];
                    let currentStepRequiredFields;
                    
                    // Special handling for step 7 (Informant) - checkbox is not required
                    if (currentStep === 6) {
                        currentStepRequiredFields = currentStepElement.querySelectorAll('input[required]:not([type="checkbox"]), select[required], textarea[required]');
                    } else {
                        currentStepRequiredFields = currentStepElement.querySelectorAll('[required]');
                    }
                    
                    // Check if this field belongs to current step
                    let isInCurrentStep = false;
                    currentStepRequiredFields.forEach(stepField => {
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
                field.addEventListener('blur', function() {
                    const currentStepElement = steps[currentStep];
                    let currentStepRequiredFields;
                    
                    if (currentStep === 6) {
                        currentStepRequiredFields = currentStepElement.querySelectorAll('input[required]:not([type="checkbox"]), select[required], textarea[required]');
                    } else {
                        currentStepRequiredFields = currentStepElement.querySelectorAll('[required]');
                    }
                    
                    let isInCurrentStep = false;
                    currentStepRequiredFields.forEach(stepField => {
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

        nextBtn.addEventListener("click", () => {
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

        prevBtn.addEventListener("click", () => {
            if (currentStep > 0) {
                // Clear validation errors when going back
                const currentStepElement = steps[currentStep];
                const errors = currentStepElement.querySelectorAll('.invalid-feedback');
                errors.forEach(error => error.remove());
                
                const invalidFields = currentStepElement.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
                
                currentStep--;
                showStep(currentStep);
            }
            
            // Update indicators after step change
            updateStepIndicators();
        });

        // MODIFIED: Form submission - now shows SweetAlert confirmation
// MODIFIED: Form submission - now shows SweetAlert confirmation
document.getElementById('birthCertForm').addEventListener('submit', function(e) {
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
    
    // NEW: Show SweetAlert confirmation instead of custom modal
    showConfirmation(
        'Confirm Save', 
        'Are you sure you want to save this birth record? Please verify all information before proceeding.',
        'question'
    ).then((result) => {
        if (result.isConfirmed) {
            // Show saving indicator - store the Swal instance
            let savingSwal = null;
            
            Swal.fire({
                title: 'Saving Birth Record',
                text: 'Please wait while we save your record...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'custom-swal-popup'
                },
                background: 'var(--bg-color, #fff)',
                color: 'var(--text-color, #000)'
            }).then((swalInstance) => {
                savingSwal = swalInstance;
            });
            
            // Collect form data
            const formData = new FormData(document.getElementById('birthCertForm'));
            const data = Object.fromEntries(formData.entries());
            
            // Add additional data
            data.action = 'save_birth_record';
            
            // Send data to server
            fetch('../../handlers/save-birth-record.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                // Close saving indicator
                Swal.close();
                
                if (result.success) {
                    showToast('Birth record added successfully!', 'success');
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                    modal.hide();
                    
                    // Reset form
                    document.getElementById('birthCertForm').reset();
                    currentStep = 0;
                    showStep(currentStep);
                    
                    // Refresh the page or update table if needed
                    if (typeof updateBirthRecordsTable === 'function') {
                        updateBirthRecordsTable();
                    }
                } else {
                    showToast(result.message, 'error');
                }
            })
            .catch(error => {
                // Close saving indicator
                Swal.close();
                console.error('Error:', error);
                showToast('An error occurred while saving the record.', 'error');
            });
        }
    });
});

        // MODIFIED: Close modal button handler - now uses SweetAlert
// MODIFIED: Close modal button handler - now uses SweetAlert and checks for form data
document.getElementById('closeModalBtn').addEventListener('click', function() {
    if (hasFormData()) {
        // Show SweetAlert confirmation only if there's form data
        showConfirmation(
            'Unsaved Changes',
            'You have unsaved changes. Are you sure you want to exit? All progress will be lost.',
            'warning'
        ).then((result) => {
            if (result.isConfirmed) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                modal.hide();
                
                // Reset form
                document.getElementById('birthCertForm').reset();
                currentStep = 0;
                showStep(currentStep);
            }
        });
    } else {
        // No data, close directly without confirmation
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('birthCertForm').reset();
        currentStep = 0;
        showStep(currentStep);
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
        document.getElementById('viewDuplicateBtn').addEventListener('click', function() {
            alert('This would show similar records in a modal or new page.');
        });

        // Birth type change handler
        document.querySelector('select[name="type_of_birth"]').addEventListener('change', handleBirthTypeChange);

        // Reset form when modal is closed
        document.getElementById('addBirthModal').addEventListener('hidden.bs.modal', function() {
            // Clear all validation errors
            const allErrors = document.querySelectorAll('.invalid-feedback');
            allErrors.forEach(error => error.remove());
            
            const allInvalidFields = document.querySelectorAll('.is-invalid');
            allInvalidFields.forEach(field => field.classList.remove('is-invalid'));
            
            document.getElementById('birthCertForm').reset();
            currentStep = 0;
            showStep(currentStep);
            document.getElementById('duplicateAlert').style.display = 'none';
            
            // Reset indicators
            updateStepIndicators();
        });

        // Initialize
        showStep(currentStep);
        setupRealTimeValidation();
        handleBirthTypeChange(); // Initial call to set proper state
        updateStepIndicators(); // Initial call to set step indicators
    });