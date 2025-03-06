// Initialize DataTables
$(document).ready(function () {
    $('#studentsTable').DataTable({
        responsive: true,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: "Search Student:"
        }
    });
});

$(document).ready(function () {
    $('#subjectsTable').DataTable({
        responsive: true,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: "Search Student:"
        }
    });
});

$(document).ready(function () {
    $('#enrollmentsTable').DataTable({
        responsive: true,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: "Search Student:"
        }
    });
});
