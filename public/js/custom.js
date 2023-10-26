document.addEventListener("DOMContentLoaded", function () {
  // Sélectionnez l'élément select par son ID

  var selectElement = document.getElementById("Creneau_formateur");
  var SelectModule = document.getElementById("Creneau_moduleFormation");
  // Sélectionnez les deux checkboxes "Accepte" et "Envoye"
  const accepteCheckbox = document.querySelector('[data-toggle-url*="fieldName=accepte"]');
  const envoyeCheckbox = document.querySelector('[data-toggle-url*="fieldName=envoye"]');

  if (document.getElementById("Creneau_accepte") && document.getElementById("Creneau_envoye")) {
    document.getElementById("Creneau_accepte").addEventListener("change", function () {
      if (this.checked) {
        document.getElementById("Creneau_envoye").checked = false;
      }
    });

    document.getElementById("Creneau_envoye").addEventListener("change", function () {
      if (this.checked) {
        document.getElementById("Creneau_accepte").checked = false;
      }
    });
  }

  // Ajoutez un gestionnaire d'événements pour le changement sur le checkbox "Accepte"
  accepteCheckbox.addEventListener("change", function () {
    if (this.checked) {
      envoyeCheckbox.checked = false;
    }
  });

  // Ajoutez un gestionnaire d'événements pour le changement sur le checkbox "Envoye"
  envoyeCheckbox.addEventListener("change", function () {
    if (this.checked) {
      accepteCheckbox.checked = false;
    }
  });


  var selectedValueModule = SelectModule.value;


  console.log(selectedValueModule)

  function checkFormations() {

    var selectedValue = selectElement.value;


    fetch('/formationsPossibles/' + selectedValue)
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
          // Ciblez le champ "moduleFormation" dans le widget d'AssociationField


          var selectElement = SelectModule;

          // Liste d'options sous forme de tableau de données


          // Construisez le contenu HTML pour les options
          var optionsHTML = '';
          for (var key in data) {
            if (data.hasOwnProperty(key)) {
              var value = data[key];
              console.log(value);
              var selected = (key == selectedValueModule) ? 'selected' : '';
              optionsHTML += '<option value="' + key + '" ' + selected + '>' + value + '</option>';
            }

          }


          // Définissez le contenu HTML de la liste déroulante
          selectElement.innerHTML = optionsHTML;

        }

        // Ajoutez les nouvelles options en fonction des données reçues
      )

  }

  checkFormations();
  // Vérifiez si l'élément a été trouvé
  if (selectElement) {
    // Ajoutez un gestionnaire d'événement pour le changement de valeur
    selectElement.addEventListener("change", function () {
      checkFormations();

    });
  } else {
    console.log("Élément select non trouvé");
  }

});
