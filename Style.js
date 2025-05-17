document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('course');
    const yearLevelSelect = document.getElementById('year-level');

    if (!courseSelect || !yearLevelSelect) {
        console.error("Course or Year-Level dropdown not found!");
        return;
    }

    // Initialize year level options
    updateYearLevelOptions(courseSelect.value);

    courseSelect.addEventListener('change', function () {
        updateYearLevelOptions(courseSelect.value);
    });

    function updateYearLevelOptions(course) {
        yearLevelSelect.innerHTML = ''; // Clear previous options

        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Select Year Level --';
        yearLevelSelect.appendChild(defaultOption);

        let options = [];
        if (['STEM', 'GAS', 'ABM', 'TVL', 'ICT'].includes(course)) {
            options = ['Grade 11', 'Grade 12'];
        } else if (course === 'BSIS') {
            options = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
        } else if (['DHRT', 'DIT'].includes(course)) {
            options = ['1st Year', '2nd Year', '3rd Year'];
        } else if (course === 'ACT') {
            options = ['1st Year', '2nd Year'];
        }

        // Populate the dropdown
        options.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearLevelSelect.appendChild(option);
        });
    }
});
