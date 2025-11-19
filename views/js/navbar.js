// JS exclusivo para o menu hamburguer do usuário na navbar

document.addEventListener('DOMContentLoaded', function() {
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userDropdown');
    if (userMenuToggle && userDropdown) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        document.addEventListener('click', function(e) {
            if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
