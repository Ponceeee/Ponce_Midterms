function confirmDelete(formId) {
    if (confirm('Are you sure you want to delete this subject? This action cannot be undone.')) {
        document.getElementById(formId).submit();
    }
} 