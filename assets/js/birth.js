// Number counting animation with easing
function animateValue(element, start, end, duration) {
    const startTime = performance.now();
    const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);
    
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easedProgress = easeOutQuart(progress);
        const value = Math.floor(easedProgress * (end - start) + start);
        
        element.textContent = value.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            element.style.color = '#FF9800';
            setTimeout(() => {
                element.style.transition = 'color 0.3s ease';
                element.style.color = '';
            }, 300);
        }
    }
    
    requestAnimationFrame(update);
}

// Initialize enhanced counters
function initEnhancedCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        card.style.transition = `all 0.6s ease-out ${index * 200}ms`;
        card.classList.add('animated');
    });
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const finalValue = parseInt(counter.getAttribute('data-value'));
                
                if (!counter.classList.contains('animated')) {
                    animateValue(counter, 0, finalValue, 2000);
                    counter.classList.add('animated');
                }
            }
        });
    }, { 
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    });

    counters.forEach(counter => {
        const currentValue = parseInt(counter.textContent.replace(/,/g, ''));
        counter.setAttribute('data-value', currentValue);
        counter.textContent = '0';
        observer.observe(counter);
    });
}

// Search and filter functionality
function filterRecords() {
    const searchTerm = document.getElementById('recordSearch').value.toLowerCase();
    const yearFilter = document.getElementById('yearFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;
    
    const rows = document.querySelectorAll('#recordsTable tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const regNumber = cells[1].textContent;
        const fullName = cells[2].textContent.toLowerCase();
        const birthDate = cells[3].textContent;
        const status = cells[6].querySelector('.badge').textContent.toLowerCase();
        
        const regYear = regNumber.split('-')[0];
        const birthYear = birthDate.split('-')[0];
        
        let matchesSearch = !searchTerm || 
            fullName.includes(searchTerm) || 
            regNumber.toLowerCase().includes(searchTerm);
        
        let matchesYear = !yearFilter || 
            regYear === yearFilter || 
            birthYear === yearFilter;
        
        let matchesStatus = !statusFilter || 
            status.includes(statusFilter.toLowerCase());
        
        if (matchesSearch && matchesYear && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    updatePaginationInfo(visibleCount);
    sortTable(sortFilter);
}

function sortTable(sortBy) {
    const tbody = document.getElementById('recordsTable');
    const rows = Array.from(tbody.querySelectorAll('tr:not([style*="display: none"])'));
    
    rows.sort((a, b) => {
        const aCells = a.querySelectorAll('td');
        const bCells = b.querySelectorAll('td');
        
        switch(sortBy) {
            case 'newest':
                return new Date(bCells[3].textContent) - new Date(aCells[3].textContent);
            case 'oldest':
                return new Date(aCells[3].textContent) - new Date(bCells[3].textContent);
            case 'name':
                return aCells[2].textContent.localeCompare(bCells[2].textContent);
            default:
                return 0;
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function updatePaginationInfo(visibleCount) {
    const pageInfo = document.querySelector('.page-info');
    pageInfo.textContent = `Showing ${Math.min(1, visibleCount)}-${Math.min(10, visibleCount)} of ${visibleCount} records`;
}

function resetFilters() {
    document.getElementById('recordSearch').value = '';
    document.getElementById('yearFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('sortFilter').value = 'newest';
    filterRecords();
}

// Event listeners for filters
document.getElementById('recordSearch').addEventListener('input', filterRecords);
document.getElementById('yearFilter').addEventListener('change', filterRecords);
document.getElementById('statusFilter').addEventListener('change', filterRecords);
document.getElementById('sortFilter').addEventListener('change', filterRecords);

// Table row actions
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-view')) {
        const row = e.target.closest('tr');
        const regNumber = row.cells[1].textContent;
        alert(`View details for: ${regNumber}`);
    }
    
    if (e.target.closest('.btn-edit')) {
        const row = e.target.closest('tr');
        const regNumber = row.cells[1].textContent;
        alert(`Edit record: ${regNumber}`);
    }
    
    if (e.target.closest('.btn-delete')) {
        const row = e.target.closest('tr');
        const regNumber = row.cells[1].textContent;
        if (confirm(`Are you sure you want to delete record ${regNumber}?`)) {
            row.style.opacity = '0.5';
            setTimeout(() => {
                row.remove();
                updateRecordCounts();
            }, 500);
        }
    }
    
    if (e.target.closest('.btn-certificate')) {
        const row = e.target.closest('tr');
        const regNumber = row.cells[1].textContent;
        alert(`Generate certificate for: ${regNumber}`);
    }
});

// Update record counts after deletion
function updateRecordCounts() {
    const totalRecords = document.querySelectorAll('#recordsTable tr').length;
    const totalRecordsElement = document.querySelector('.stat-number[data-value="1234"]');
    
    if (totalRecordsElement) {
        const newValue = parseInt(totalRecordsElement.getAttribute('data-value')) - 1;
        totalRecordsElement.setAttribute('data-value', newValue);
        totalRecordsElement.textContent = newValue.toLocaleString();
    }
}

// Pagination functionality
function setupPagination() {
    const pageBtns = document.querySelectorAll('.page-btn:not(.disabled)');
    pageBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.classList.contains('active')) {
                document.querySelector('.page-btn.active').classList.remove('active');
                this.classList.add('active');
                simulatePageLoad();
            }
        });
    });
}

function simulatePageLoad() {
    const tbody = document.getElementById('recordsTable');
    tbody.style.opacity = '0.5';
    
    setTimeout(() => {
        tbody.style.opacity = '1';
        tbody.style.transition = 'opacity 0.3s ease';
    }, 300);
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initEnhancedCounters();
    setupPagination();
    filterRecords();
    
    const tbody = document.getElementById('recordsTable');
    tbody.innerHTML = `
        <tr>
            <td colspan="8">
                <div class="loading-spinner"></div>
                <p class="text-center">Loading records...</p>
            </td>
        </tr>
    `;
    
    setTimeout(() => {
        tbody.innerHTML = `
            <tr>
                <td>1</td>
                <td>2023-B-001</td>
                <td>John Michael Doe</td>
                <td>2023-01-15</td>
                <td>Pagadian City Medical Center</td>
                <td>James & Mary Doe</td>
                <td><span class="badge bg-success">Registered</span></td>
                <td>
                    <button class="btn-action btn-view" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action btn-certificate" title="Generate Certificate">
                        <i class="fas fa-file-certificate"></i>
                    </button>
                    <button class="btn-action btn-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action btn-delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>2023-B-002</td>
                <td>Maria Santos Cruz</td>
                <td>2023-02-20</td>
                <td>Zamboanga del Sur Medical Center</td>
                <td>Juan & Elena Cruz</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td>
                    <button class="btn-action btn-view" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action btn-certificate" title="Generate Certificate" disabled>
                        <i class="fas fa-file-certificate"></i>
                    </button>
                    <button class="btn-action btn-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action btn-delete" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }, 1500);
});

// Responsive table handling
function handleTableResponsive() {
    const tableContainer = document.querySelector('.table-container');
    const table = document.querySelector('.table-custom');
    
    if (tableContainer.offsetWidth < table.offsetWidth) {
        tableContainer.classList.add('table-responsive');
    } else {
        tableContainer.classList.remove('table-responsive');
    }
}

window.addEventListener('resize', handleTableResponsive);
handleTableResponsive();

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('recordSearch').focus();
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        document.querySelector('.action-btn').click();
    }
});