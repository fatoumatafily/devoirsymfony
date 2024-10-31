# Méthodes de repository permet de récupérer les données d'une entité:
    - findAll() - Récupère tous les clients
    - find($id) - Récupère un client par son ID
    - findBy(array $criteria) - Récupère un client par critères
    - findByExampleField($value) - Récupère un client par valeur d'un champ exemple
    - findOneBy(array $criteria) - Récupère le premier client par critères
    - findOneByExampleField($value) - Récupère le premier client par valeur d'un champ exemple


// Lorsque le DOM est entièrement chargé
    document.addEventListener('DOMContentLoaded', () => {
        if (sideMenu.classList.contains("hidden")) {
            inputTitle.classList.add("hidden");
            sideMenu.classList.remove("hidden");
        }
    });