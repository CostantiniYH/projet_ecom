AOS.init();

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

document.addEventListener("DOMContentLoaded", function() {
  // 1. Récupérer l'URL actuelle
  const currentLocation = location.href;
  
  // 2. Sélectionner tous les liens de la navbar
  const menuItem = document.querySelectorAll('.nav-link');
  const menuLength = menuItem.length;
  
  // 3. Boucler sur les liens pour trouver la correspondance
  for (let i = 0; i < menuLength; i++) {
    // Si le lien correspond à l'URL actuelle
    if (menuItem[i].href === currentLocation) {
      // Ajouter la classe 'active'
      menuItem[i].classList.add("active");
      
      // Optionnel : Pour l'accessibilité (screen readers)
      menuItem[i].setAttribute("aria-current", "page");
    }
  }
});