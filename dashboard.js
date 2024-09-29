// Function to open the profile modal
function openModal() {
    document.getElementById('profileModal').style.display = 'flex';
}

// Function to close the profile modal
function closeModal() {
    document.getElementById('profileModal').style.display = 'none';
}

// Function to toggle the sidebar on mobile view
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.style.transform = sidebar.style.transform === 'translateX(0px)' ? 'translateX(-100%)' : 'translateX(0px)';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('profileModal');
    if (event.target === modal) {
        closeModal();
    }
};
