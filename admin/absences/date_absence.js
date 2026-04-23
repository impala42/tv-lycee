    function actualiser() {
        if (document.getElementById("jour_complet_debut").checked == true) {
            document.getElementById("heure_debut").type = "hidden";
            document.getElementById("date_debut").value = document.getElementById("jour_debut").value + "T00:00";
        } else {
            document.getElementById("heure_debut").type = "time";
            document.getElementById("date_debut").value = document.getElementById("jour_debut").value + "T" + document.getElementById("heure_debut").value;
        }

        if (document.getElementById("jour_complet_fin").checked == true) {
            document.getElementById("heure_fin").type = "hidden";
            document.getElementById("date_fin").value = document.getElementById("jour_fin").value + "T23:59";
        } else {
            document.getElementById("heure_fin").type = "time";
            document.getElementById("date_fin").value = document.getElementById("jour_fin").value + "T" + document.getElementById("heure_fin").value;
        }
    }

    document.getElementById("jour_complet_debut").addEventListener("click", (e) => {
        actualiser();
    });
    document.getElementById("jour_debut").addEventListener("input", (e) => {
        actualiser();
    });
    document.getElementById("heure_debut").addEventListener("input", (e) => {
        actualiser();
    });
    document.getElementById("jour_complet_fin").addEventListener("click", (e) => {
        actualiser();
    });
    document.getElementById("jour_fin").addEventListener("input", (e) => {
        actualiser();
    });
    document.getElementById("heure_fin").addEventListener("input", (e) => {
        actualiser();
    });