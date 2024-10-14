function setEndDateMin() {
    const startDateInput = document.getElementById("startDate");
    const endDateInput = document.getElementById("endDate");
    
    endDateInput.min = startDateInput.value;
}