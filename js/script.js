const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle");
      sidebar = body.querySelector("nav");
      sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})

// function afficherDonnees(event) {
//     event.preventDefault(); // Empêche le rechargement de la page
//     $.ajax({
//     type: "POST",
//     url: "../php/requete.php",
//     data: { data_stocks_print: true },
//     success: function(response) {
//         // Si la réponse est au format JSON
//         try {
//             var data = JSON.parse(response);
//             updateTable(data);
//         } catch (e) {
//             document.body.innerHTML += response;
//         }
//     },
//     error: function(xhr, status, error) {
//         // En cas d'erreur AJAX
//         console.error("Erreur AJAX :", error);
//     }
// });

// }

function updateTable(data) {
    const articles = document.getElementById('articlesList');
    const codes = document.getElementById('codesList');
    const rangements = document.getElementById('rangementsList');
    const quantites = document.getElementById('quantitesList');

    articles.innerHTML = "";
    codes.innerHTML = "";
    rangements.innerHTML = "";
    quantites.innerHTML = "";

    data.forEach(function(item) {
        console.log(item[item]);
        articles.innerHTML += "<br>" + item['Article'];
        codes.innerHTML += "<br>" + item['Code'];
        rangements.innerHTML += "<br>" + item['Rangement'];
        quantites.innerHTML += "<br>" + item['Quantite'];
    });
}