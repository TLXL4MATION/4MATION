
document.addEventListener('DOMContentLoaded', function() {
    const userEmail = document.getElementById('userEmail');
    const sidebar = document.getElementById('userSidebar');
    const closeBtn = document.getElementById('closeUser_sidebar');

    userEmail.addEventListener('click', function() {
        sidebar.classList.add('active');
    });

    closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('active');
    });

    userEmail.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la propagation de l'événement de fermeture
        sidebar.classList.add('active');
    });

    closeBtn.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la propagation de l'événement de fermeture
        sidebar.classList.remove('active');
    });

    // Gestionnaire d'événement pour fermer la sidebar lorsque l'on clique en dehors
    document.addEventListener('click', function(event) {
        const targetElement = event.target;
        if (!sidebar.contains(targetElement) && !userEmail.contains(targetElement)) {
            sidebar.classList.remove('active');
        }
    });
});