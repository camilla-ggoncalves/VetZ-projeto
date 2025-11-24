$(window).on("load", function () {
  "use strict";

  var footer_year = document.getElementById("footer-year");
  if (footer_year) {
    footer_year.innerHTML = new Date().getFullYear();
  }

  /* ========================================================== */
  /*   Navigation Background Color                              */
  /* ========================================================== */

  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 450) {
      $(".navbar-fixed-top").addClass("opaque");
    } else {
      $(".navbar-fixed-top").removeClass("opaque");
    }
  });

  /* ========================================================== */
  /*   Hide Responsive Navigation On-Click                      */
  /* ========================================================== */

  $(".navbar-nav li a").on("click", function (event) {
    $(".navbar-collapse").collapse("hide");
  });

  /* ========================================================== */
  /*   Navigation Color                                         */
  /* ========================================================== */

  var navbarCollapse = $("#navbarCollapse");

  if (navbarCollapse.length) {
    navbarCollapse.onePageNav({
      /* Para API - Camilla */
      filter: function () {
        var href = $(this).attr("href");
        return href && href !== "#" && href.charAt(0) === "#";
      },
    });
  }

  /* ========================================================== */
  /*   SmoothScroll                                             */
  /* ========================================================== */

  $(".navbar-nav li a, a.scrool").on("click", function (e) {
    var full_url = this.href;
    var parts = full_url.split("#");
    var trgt = parts[1];
    var target_offset = $("#" + trgt).offset();
    var target_top = target_offset.top;

    $("html,body").animate({ scrollTop: target_top - 70 }, 1000);
    return false;
  });
});

/* ========================================================== */
/*   API Youtube - Arquivo Separado para evitar conflitos      */
/* ========================================================== */

(function () {
  "use strict";

  // Sua chave de API do YouTube
  const apiKey = "AIzaSyAw8C7V9AeqiEtu1RQcmr9dR8W5ULfQ44g";

  const canaisVeterinarios = [
    "UCsKneoQQHq93LsJpfspj_6A",
    "UCTU-01IN0p5JXB7VxEzDdJg",
    "UCpfYQpjkTmxMPN1vUoTaAMw",
  ];

  const MAX_PER_SECTION = 9;

  /* ---------- Funções de navegação ---------- */
  function mostrarRecentes() {
    const recentes = document.getElementById("recentes");
    const antigos = document.getElementById("antigos");
    const btnRecentes = document.querySelector(".video-buttons .recentes");
    const btnAntigos = document.querySelector(".video-buttons .antigos");

    if (recentes && antigos) {
      recentes.classList.add("ativo");
      antigos.classList.remove("ativo");
    }

    if (btnRecentes) btnRecentes.classList.add("active");
    if (btnAntigos) btnAntigos.classList.remove("active");
  }

  function mostrarAntigos() {
    const recentes = document.getElementById("recentes");
    const antigos = document.getElementById("antigos");
    const btnRecentes = document.querySelector(".video-buttons .recentes");
    const btnAntigos = document.querySelector(".video-buttons .antigos");

    if (recentes && antigos) {
      antigos.classList.add("ativo");
      recentes.classList.remove("ativo");
    }

    if (btnAntigos) btnAntigos.classList.add("active");
    if (btnRecentes) btnRecentes.classList.remove("active");
  }

  /* ---------- Inicializar botões ---------- */
  function inicializarBotoes() {
    const btnRecentes = document.querySelector(".video-buttons .recentes");
    const btnAntigos = document.querySelector(".video-buttons .antigos");

    if (btnRecentes) {
      btnRecentes.addEventListener("click", mostrarRecentes);
    }

    if (btnAntigos) {
      btnAntigos.addEventListener("click", mostrarAntigos);
    }

    // Estado inicial
    mostrarRecentes();
  }

  /* ---------- YouTube API ---------- */
  function loadYouTubeAPI() {
    if (!window.gapi) {
      console.error("Google API (gapi) não carregada!");
      return;
    }

    gapi.client
      .init({ apiKey: apiKey })
      .then(() => {
        console.log("✓ Google API inicializada");
        getVideosDeCanaisVeterinarios();
      })
      .catch((err) => {
        console.error("Erro ao inicializar gapi:", err);
      });
  }

  function buscarVideosDoCanal(channelId) {
    return gapi.client
      .request({
        path: "/youtube/v3/search",
        params: {
          part: "snippet",
          channelId: channelId,
          maxResults: 20,
          order: "date",
          type: "video",
        },
      })
      .then((response) => response.result.items || [])
      .catch((err) => {
        console.warn("Erro buscando vídeos do canal", channelId, err);
        return [];
      });
  }

  function getVideosDeCanaisVeterinarios() {
    const promessas = canaisVeterinarios.map((canal) =>
      buscarVideosDoCanal(canal)
    );

    Promise.all(promessas)
      .then((resultados) => {
        const todosVideos = resultados.flat();

        // Remove duplicatas
        const mapa = new Map();
        todosVideos.forEach((v) => {
          const videoId = v.id && v.id.videoId ? v.id.videoId : "";
          if (videoId && !mapa.has(videoId)) {
            mapa.set(videoId, v);
          }
        });

        const uniqueVideos = Array.from(mapa.values());

        // Ordenar por data
        uniqueVideos.sort((a, b) => {
          return (
            new Date(b.snippet.publishedAt) - new Date(a.snippet.publishedAt)
          );
        });

        // Separar em recentes e antigos
        const hoje = new Date();
        const trintaDiasAtras = new Date();
        trintaDiasAtras.setDate(hoje.getDate() - 30);

        const videosRecentes = [];
        const videosAntigos = [];

        uniqueVideos.forEach((v) => {
          const publishedAt = new Date(v.snippet.publishedAt);
          if (!isNaN(publishedAt)) {
            if (publishedAt >= trintaDiasAtras) {
              videosRecentes.push(v);
            } else {
              videosAntigos.push(v);
            }
          }
        });

        // Pegar exatamente 9 de cada
        const recentes9 = videosRecentes.slice(0, MAX_PER_SECTION);
        const antigos9 = videosAntigos.slice(0, MAX_PER_SECTION);

        console.log(`✓ ${recentes9.length} vídeos recentes carregados`);
        console.log(`✓ ${antigos9.length} vídeos antigos carregados`);

        displayVideosSplit(recentes9, antigos9);
      })
      .catch((err) => {
        console.error("Erro ao buscar vídeos:", err);
      });
  }

  function displayVideosSplit(recentes, antigos) {
    const recentList = document.getElementById("recentes");
    const oldList = document.getElementById("antigos");

    if (!recentList || !oldList) {
      console.error("Elementos #recentes ou #antigos não encontrados!");
      return;
    }

    recentList.innerHTML = "";
    oldList.innerHTML = "";

    // Esconder loader e mostrar conteudo
    const loader = document.getElementById("videos-loader");
    const content = document.getElementById("videos-content");
    if (loader) loader.style.display = "none";
    if (content) content.classList.remove("content-hidden");

    function criarItem(video) {
      const title = (video.snippet.title || "").replace(/#[^\s#]+/g, "").trim();
      const videoId = video.id && video.id.videoId ? video.id.videoId : "";
      const videoUrl = videoId
        ? `https://www.youtube.com/watch?v=${videoId}`
        : "#";
      const thumb =
        (video.snippet.thumbnails &&
          (video.snippet.thumbnails.high?.url ||
            video.snippet.thumbnails.medium?.url ||
            video.snippet.thumbnails.default?.url)) ||
        "";

      const publishedAt = new Date(video.snippet.publishedAt);
      const dataFormatada = isNaN(publishedAt)
        ? ""
        : publishedAt.toLocaleDateString("pt-BR");

      const listItem = document.createElement("div");
      listItem.classList.add("video-item");
      listItem.innerHTML = `
                <a href="${videoUrl}" target="_blank" rel="noopener noreferrer" class="video-thumb">
                    <img src="${thumb}" alt="${escapeHtml(title)}">
                </a>
                <div class="video-content">
                    <p class="video-title">${escapeHtml(title)}</p>
                    <p class="video-date">${dataFormatada}</p>
                </div>
            `;
      return listItem;
    }

    recentes.forEach((v) => recentList.appendChild(criarItem(v)));
    antigos.forEach((v) => oldList.appendChild(criarItem(v)));
  }

  function escapeHtml(str) {
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
  }

  /* ---------- Inicialização ---------- */
  function init() {
    // Aguarda o DOM estar pronto
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", function () {
        inicializarBotoes();

        // Carrega a API do YouTube
        if (window.gapi && gapi.load) {
          gapi.load("client", loadYouTubeAPI);
        } else {
          console.error("Google API (gapi) não encontrada!");
        }
      });
    } else {
      inicializarBotoes();

      if (window.gapi && gapi.load) {
        gapi.load("client", loadYouTubeAPI);
      } else {
        console.error("Google API (gapi) não encontrada!");
      }
    }
  }

  // Inicia tudo
  init();
})();

/* ========================================================== */
/*   Pagina de vacinação de Cão - Check das doses ADM         */
/* ========================================================== */
function toggleCheck(button) {
  button.classList.toggle("checked");
  if (button.classList.contains("checked")) {
    button.innerHTML = "✔";
  } else {
    button.innerHTML = button.dataset.originalText || button.textContent;
  }
}
document.querySelectorAll("button").forEach((btn) => {
  btn.dataset.originalText = btn.textContent;
});

function toggleCheck(button) {
  if (!button.classList.contains("checked")) {
    button.classList.add("checked");
    button.innerHTML = "✔";
  } else {
    button.classList.remove("checked");
    button.innerHTML = button.dataset.originalText;
  }
}

/* ========================================================== */
/*   Pagina de vacinação de Gato - Visualização das vacinas   */
/* ========================================================== */
let vacinaModal;

document.addEventListener("DOMContentLoaded", function () {
  vacinaModal = new bootstrap.Modal(document.getElementById("vacinaModal"));
});

function abrirPopup(vacina, dose) {
  document.getElementById("vacinaNome").innerText = vacina;
  document.getElementById("vacinaDose").innerText = dose;
  vacinaModal.show();
}

/* ========================================================== */
/*   Pagina de Perfil - Animal                                */
/* ========================================================== */

// let currentCard = null;

// function editPet(name, description) {
//   document.getElementById('petName').value = name;
//   document.getElementById('petDesc').value = description;

//   const cards = document.querySelectorAll('.pet-card');
//   cards.forEach(card => {
//     const h5 = card.querySelector('h5');
//     if (h5 && h5.textContent.includes(name)) {
//       currentCard = card;
//     }
//   });

//   const modal = new bootstrap.Modal(document.getElementById('editModal'));
//   modal.show();
// }

// function deletePet(button) {
//   if (confirm('Tem certeza que deseja excluir este pet?')) {
//     button.closest('.pet-card').remove();
//   }
// }

// document.getElementById('editForm').addEventListener('submit', function (e)?) {
//   e.preventDefault();
//   if (currentCard) {
//     const newName = document.getElementById('petName').value;
//     const newDesc = document.getElementById('petDesc').value;

//     currentCard.querySelector('h5').innerHTML = `<strong>${newName}</strong>`;
//     currentCard.querySelector('p').textContent = newDesc;

//     bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
//   }

/* ========================================================== */
/*   Termos de Uso.                                           */
/* ========================================================== */
document.getElementById("botaoNext").addEventListener("click", function () {
  const checkbox = document.getElementById("aceite");
  const erroMsg = document.getElementById("erro-termos");

  if (!checkbox.checked) {
    erroMsg.style.display = "block";
  } else {
    erroMsg.style.display = "none";
    alert("Termos aceitos. Prosseguindo...");
  }
});

function deletePet(button) {
  if (confirm("Tem certeza que deseja excluir este pet?")) {
    button.closest(".pet-card").remove();
  }
}

currentCard.querySelector("h5").innerHTML = `<strong>${newName}</strong>`;
currentCard.querySelector("p").textContent = newDesc;

bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();

function mostrarPopup() {
  // Pega o e-mail digitado e coloca no popup
  var email = document.querySelector('input[name="email"]').value;
  document.getElementById("popup-email").value = email;
  setTimeout(function () {
    document.getElementById("popup-codigo").style.display = "flex";
  }, 500); // espera meio segundo para simular envio
  return false; // impede o submit real do form de e-mail
}
function fecharPopup() {
  document.getElementById("popup-codigo").style.display = "none";
} /* ========================================================== */ /*   Vacinação Pet.                                           */ /* ========================================================== */

// Dados simulados do banco de dados
const petData = {
  name: "Luck",
  species: "Cachorro",
  breed: "Vira-lata",
  birthDate: "2019-10-17",
  owner: "Marcela Sanches",
  photo: "🐕",
};

// Função para calcular a idade em semanas
function calculateAgeInWeeks(birthDate) {
  const birth = new Date(birthDate);
  const today = new Date();
  const diffTime = Math.abs(today - birth);
  const diffWeeks = Math.floor(diffTime / (1000 * 60 * 60 * 24 * 7));
  return diffWeeks;
}

// Função para gerar calendário de vacinação baseado na idade
function generateVaccinationSchedule(ageInWeeks, birthDate) {
  const birth = new Date(birthDate);
  const vaccines = []; // Polivalente doses

  if (ageInWeeks >= 6) {
    vaccines.push({
      name: "Polivalente V8/V10",
      subtitle: "1ª Dose - A partir de 6 semanas",
      status: "done",
      appliedDate: addWeeks(birth, 6),
      nextDate: addWeeks(birth, 9),
    });
  }
  if (ageInWeeks >= 9) {
    vaccines.push({
      name: "Polivalente V8/V10",
      subtitle: "2ª Dose - 9 semanas",
      status: ageInWeeks === 9 ? "pending" : "done",
      appliedDate: ageInWeeks > 9 ? addWeeks(birth, 9) : null,
      nextDate: addWeeks(birth, 12),
    });
  } else {
    vaccines.push({
      name: "Polivalente V8/V10",
      subtitle: "2ª Dose - 9 semanas",
      status: "pending",
      appliedDate: null,
      nextDate: addWeeks(birth, 9),
    });
  }

  return vaccines;
}

function addWeeks(date, weeks) {
  const result = new Date(date);
  result.setDate(result.getDate() + weeks * 7);
  return result.toLocaleDateString("pt-BR");
}

// Inicialização
const ageInWeeks = calculateAgeInWeeks(petData.birthDate);
console.log(`Pet tem ${ageInWeeks} semanas de idade`);

// Funções do Modal de Edição de Vacinas
function openEditModal() {
  document.getElementById("editVaccineModal").style.display = "block"; // Pré-preencher checkboxes baseado no status atual
  document.getElementById("vac1").checked = true;
  document.getElementById("date1").value = "2025-10-05";
  document.getElementById("vac4").checked = true;
  document.getElementById("date4").value = "2025-10-05";
}

function closeEditModal() {
  document.getElementById("editVaccineModal").style.display = "none";
}

function saveVaccines(event) {
  event.preventDefault();
  const vaccines = [];
  for (let i = 1; i <= 6; i++) {
    const checkbox = document.getElementById("vac" + i);
    const dateInput = document.getElementById("date" + i);
    if (checkbox.checked && dateInput.value) {
      vaccines.push({
        id: checkbox.value,
        date: dateInput.value,
      });
    }
  } // Atualiza visualmente o status da tabela

  const rows = document.querySelectorAll(".vaccine-table tbody tr");
  vaccines.forEach((vaccine, index) => {
    const row = rows[index];
    if (row) {
      const statusCell = row.querySelector("td:nth-child(2)");
      const dateCell = row.querySelector("td:nth-child(3)"); // Atualiza a data de aplicação
      const formattedDate = new Date(vaccine.date).toLocaleDateString("pt-BR");
      dateCell.textContent = formattedDate; // Atualiza o status para "Aplicada" com o check

      statusCell.innerHTML = `
              <span class="status-badge status-done">
                  <span class="check-icon">✓</span>
                  Aplicada
              </span>
          `;
    }
  }); // Aqui você enviaria os dados para o PHP/banco de dados

  console.log("Vacinas aplicadas:", vaccines);
  alert("✅ Vacinações atualizadas com sucesso!");
  closeEditModal();
}

// Funções do Modal de Adicionar Medicação
function openAddMedicationModal() {
  document.getElementById("addMedicationModal").style.display = "block";
}

function closeAddMedicationModal() {
  document.getElementById("addMedicationModal").style.display = "none";
  document.getElementById("medicationForm").reset();
}

function addMedication(event) {
  event.preventDefault();
  const medication = {
    name: document.getElementById("medName").value,
    dosage: document.getElementById("medDosage").value,
    frequency: document.getElementById("medFrequency").value,
    nextDate: document.getElementById("medNextDate").value,
    notes: document.getElementById("medNotes").value,
  }; // Aqui você enviaria os dados para o PHP/banco de dados

  console.log("Nova medicação:", medication); // Adicionar visualmente na lista

  const medicationsList = document.getElementById("medicationsList");
  const newMedCard = document.createElement("div");
  newMedCard.className = "medication-card";
  newMedCard.style.animation = "slideDown 0.3s";
  const formattedDate = new Date(medication.nextDate).toLocaleDateString(
    "pt-BR"
  );
  newMedCard.innerHTML = `
      <button class="delete-medication-btn" onclick="deleteMedication(this)">×</button>
      <div class="medication-name">${medication.name}</div>
      <div class="medication-info">📊 Dosagem: ${medication.dosage}</div>
      <div class="medication-info">⏰ Frequência: ${medication.frequency}</div>
      <div class="medication-date">Próxima aplicação: ${formattedDate}</div>
      ${
    medication.notes
      ? `<div class="medication-info" style="margin-top: 8px; font-style: italic;">📝 ${medication.notes}</div>`
      : ""
  }
  `;

  medicationsList.appendChild(newMedCard);
  alert("✅ Medicação adicionada com sucesso!");
  closeAddMedicationModal();
}

function deleteMedication(button) {
  if (confirm("Tem certeza que deseja remover esta medicação?")) {
    const card = button.closest(".medication-card");
    card.style.animation = "fadeOut 0.3s";
    setTimeout(() => {
      card.remove(); // Aqui você enviaria a requisição para deletar do banco de dados
      alert("✅ Medicação removida com sucesso!");
    }, 300);
  }
}

// Fechar modais ao clicar fora
window.onclick = function (event) {
  const editModal = document.getElementById("editVaccineModal");
  const addModal = document.getElementById("addMedicationModal");
  if (event.target == editModal) {
    closeEditModal();
  }
  if (event.target == addModal) {
    closeAddMedicationModal();
  }
};

// Animação de fade out
const style = document.createElement("style");
style.textContent = `
  @keyframes fadeOut {
      from { opacity: 1; transform: translateX(0); }
      to { opacity: 0; transform: translateX(100px); }
  }
`;
document.head.appendChild(
  style
); /* ========================================================== */ /*   Perfil usuário.                                          */ /* ========================================================== */

function previewAvatar(event) {
  const input = event.target;
  const file = input.files[0];
  const reader = new FileReader();

  reader.onload = function () {
    const avatarImage = document.getElementById("avatarImage");
    avatarImage.src = reader.result;
  };

  if (file) {
    reader.readAsDataURL(file);
  }
}

// ==================== DADOS DOS PETS ====================
var pets = [
  {
    id: 1,
    nome: "Shakira",
    especie: "Gato",
    idade: 3,
    emoji: "🐱",
    foto: null,
  },
  {
    id: 2,
    nome: "Mané (Luck)",
    especie: "Cachorro",
    idade: 6,
    emoji: "🐶",
    foto: null,
  },
];

var nextPetId = 3;

// ==================== EMOJIS POR ESPÉCIE ====================
var emojis = {
  Cachorro: "🐶",
  Gato: "🐱",
  Coelho: "🐰",
  Pássaro: "🐦",
  Hamster: "🐹",
  Peixe: "🐠",
  Tartaruga: "🐢",
  Outro: "🐾",
};

// ==================== FUNÇÕES DO MODAL ====================
function abrirModal() {
  var modal = document.getElementById("addPetModal");
  modal.style.display = "flex";
  document.body.style.overflow = "hidden";
}

function fecharModal() {
  var modal = document.getElementById("addPetModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Limpar formulário
  document.getElementById("addPetForm").reset();
  document.getElementById("petPhotoPreview").style.display = "none";
  document.getElementById("photoPreview").style.display = "flex";
}

// ==================== RENDERIZAR PETS ====================
function renderizarPets() {
  var petsGrid = document.getElementById("petsGrid");
  petsGrid.innerHTML = "";
  for (var i = 0; i < pets.length; i++) {
    var pet = pets[i];
    var petCard = document.createElement("div");
    petCard.className = "pet-card";
    var avatarHTML = "";
    if (pet.foto) {
      avatarHTML =
        '<img src="' +
        pet.foto +
        '" alt="' +
        pet.nome +
        '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">';
    } else {
      avatarHTML = pet.emoji;
    }
    petCard.innerHTML =
      '<div class="pet-avatar">' +
      avatarHTML +
      "</div>" +
      '<div class="pet-name">' +
      pet.nome +
      "</div>" +
      '<div class="pet-info">' +
      pet.especie +
      " • " +
      pet.idade +
      (pet.idade === 1 ? " ano" : " anos") +
      "</div>" +
      '<button class="view-profile-btn" onclick="abrirPerfilPet(' +
      pet.id +
      ')">Ver Perfil</button>';
    petsGrid.appendChild(petCard);
  }
}

// ==================== ABRIR PERFIL DO PET ====================
function abrirPerfilPet(petId) {
  var pet = null;
  for (var i = 0; i < pets.length; i++) {
    if (pets[i].id === petId) {
      pet = pets[i];
      break;
    }
  }
  if (pet) {
    alert(
      "Abrindo perfil de " +
        pet.nome +
        "...\n\nEspécie: " +
        pet.especie +
        "\nIdade: " +
        pet.idade +
        (pet.idade === 1 ? " ano" : " anos")
    );
  }
}

// ==================== SALVAR PET ====================
function salvarPet(event) {
  event.preventDefault();
  var nome = document.getElementById("petNameInput").value.trim();
  var especie = document.getElementById("petSpeciesInput").value;
  var idade = parseInt(document.getElementById("petAgeInput").value);
  var fotoInput = document.getElementById("petPhotoInput");
  if (!nome || !especie || isNaN(idade)) {
    alert("Por favor, preencha todos os campos obrigatórios!");
    return;
  }
  var novoPet = {
    id: nextPetId++,
    nome: nome,
    especie: especie,
    idade: idade,
    emoji: emojis[especie] || "🐾",
    foto: null,
  };
  if (fotoInput.files.length > 0) {
    var reader = new FileReader();
    reader.onload = function (e) {
      novoPet.foto = e.target.result;
      pets.push(novoPet);
      renderizarPets();
      fecharModal();
      mostrarMensagem(nome + " foi adicionado com sucesso!");
    };
    reader.readAsDataURL(fotoInput.files[0]);
  } else {
    pets.push(novoPet);
    renderizarPets();
    fecharModal();
    mostrarMensagem(nome + " foi adicionado com sucesso!");
  }
}

// ==================== MENSAGEM DE SUCESSO ====================
function mostrarMensagem(texto) {
  var msg = document.createElement("div");
  msg.textContent = texto;
  msg.style.cssText =
    "position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; " +
    "padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); " +
    "z-index: 10000; font-family: Arial, sans-serif; opacity: 0; transition: opacity 0.3s;";
  document.body.appendChild(msg);
  setTimeout(function () {
    msg.style.opacity = "1";
  }, 10);
  setTimeout(function () {
    msg.style.opacity = "0";
    setTimeout(function () {
      msg.remove();
    }, 300);
  }, 3000);
}

// ==================== UPLOAD DE IMAGENS ====================
function alterarAvatar(event) {
  var file = event.target.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("avatarImage").src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function alterarBanner(event) {
  var file = event.target.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var header = document.getElementById("profileHeader");
      header.style.backgroundImage = "url(" + e.target.result + ")";
      header.style.backgroundSize = "cover";
      header.style.backgroundPosition = "center";
    };
    reader.readAsDataURL(file);
  }
}

function previewFotoPet(event) {
  var file = event.target.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("petPhotoPreview").src = e.target.result;
      document.getElementById("petPhotoPreview").style.display = "block";
      document.getElementById("photoPreview").style.display = "none";
    };
    reader.readAsDataURL(file);
  }
}

// ==================== INICIALIZAÇÃO ====================
window.addEventListener("DOMContentLoaded", function () {
  console.log("VetZ Script Carregado!"); // Renderizar pets
  renderizarPets(); // Botão adicionar pet
  document.getElementById("addPetButton").addEventListener("click", abrirModal); // Botões fechar modal
  document
    .getElementById("closeModalBtn")
    .addEventListener("click", fecharModal);
  document.getElementById("cancelBtn").addEventListener("click", fecharModal); // Fechar modal ao clicar fora
  document
    .getElementById("addPetModal")
    .addEventListener("click", function (e) {
      if (e.target.id === "addPetModal") {
        fecharModal();
      }
    }); // Fechar com ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      fecharModal();
    }
  }); // Formulário de adicionar pet
  document.getElementById("addPetForm").addEventListener("submit", salvarPet); // Upload de avatar
  document
    .getElementById("avatarUploadBtn")
    .addEventListener("click", function () {
      document.getElementById("avatarInput").click();
    });
  document
    .getElementById("avatarInput")
    .addEventListener("change", alterarAvatar); // Upload de banner
  document
    .getElementById("bannerUploadBtn")
    .addEventListener("click", function () {
      document.getElementById("bannerInput").click();
    });
  document
    .getElementById("bannerInput")
    .addEventListener("change", alterarBanner); // Upload de foto do pet
  document
    .getElementById("photoUploadArea")
    .addEventListener("click", function () {
      document.getElementById("petPhotoInput").click();
    });
  document
    .getElementById("petPhotoInput")
    .addEventListener("change", previewFotoPet); // Ano no footer
  document.getElementById("footer-year").textContent = new Date().getFullYear();
}); /* ========================================================== */ /*   Cadastro.                                                */ /* ========================================================== */

const senhaInput = document.getElementById("senha");
const mensagemForca = document.getElementById("mensagem-forca");
const erroSenha = document.getElementById("erro-senha");
const tooltip = document.getElementById("tooltip-senha");
const toggleSenha = document.getElementById("toggleSenha");
const form = document.getElementById("formCadastro");

// Mostrar/ocultar senha
toggleSenha.addEventListener("click", () => {
  const tipo =
    senhaInput.getAttribute("type") === "password" ? "text" : "password";
  senhaInput.setAttribute("type", tipo);
  toggleSenha.innerHTML = tipo === "password" ? "🐵" : "🙈";
});

// Mostra tooltip
senhaInput.addEventListener("focus", () => {
  tooltip.style.opacity = "1";
  tooltip.style.pointerEvents = "auto";
});

// Esconde tooltip
senhaInput.addEventListener("blur", () => {
  tooltip.style.opacity = "0";
  tooltip.style.pointerEvents = "none";
});

// Teste de força da senha
senhaInput.addEventListener("input", function () {
  const senha = senhaInput.value;
  let forca = 0;

  if (senha.length >= 8) forca++;
  if (/[A-Z]/.test(senha)) forca++;
  if (/[a-z]/.test(senha)) forca++;
  if (/\d/.test(senha)) forca++;
  if (/[^A-Za-z0-9]/.test(senha)) forca++;

  if (senha.length === 0) {
    mensagemForca.textContent = "Digite uma senha";
    mensagemForca.style.color = "#555";
  } else if (forca <= 2) {
    mensagemForca.textContent = "Senha fraca";
    mensagemForca.style.color = "red";
  } else if (forca === 3 || forca === 4) {
    mensagemForca.textContent = "Senha média";
    mensagemForca.style.color = "orange";
  } else if (forca === 5) {
    mensagemForca.textContent = "Senha forte";
    mensagemForca.style.color = "green";
  }
});

// Validação personalizada no envio
form.addEventListener("submit", function (e) {
  const senha = senhaInput.value;
  const padrao = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}/;

  if (!padrao.test(senha)) {
    e.preventDefault();
    erroSenha.textContent = "Senha inválida.";
    erroSenha.style.color = "#d62828";
  } else {
    erroSenha.textContent = "";
  }
}); /* ========================================================== */ /*   Exibição Pets.                                           */ /* ========================================================== */

const apiKey = "sqpSErXDTZWxVyY11lPnEQTZOOJbAfFAKAPYEQ09OAdkHj13qh";
const apiSecret = "KfyWu5xbjrLbnr61dx2VdZBVSC6HfgiaNs8khIJW";
let token = "";

async function getToken() {
  const res = await fetch("https://api.petfinder.com/v2/oauth2/token", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `grant_type=client_credentials&client_id=${apiKey}&client_secret=${apiSecret}`,
  });
  const data = await res.json();
  token = data.access_token;
  loadPets();
}

async function loadPets() {
  const species = document.getElementById("speciesFilter").value;
  const age = document.getElementById("ageFilter").value;
  const gender = document.getElementById("genderFilter").value;

  let url = "https://api.petfinder.com/v2/animals?limit=21";
  if (species) url += `&type=${species}`;
  if (age) url += `&age=${age}`;
  if (gender) url += `&gender=${gender}`;

  const res = await fetch(url, {
    headers: { Authorization: `Bearer ${token}` },
  });
  const data = await res.json();
  displayPets(data.animals);
}

function displayPets(pets) {
  const petList = document.getElementById("petList");
  petList.innerHTML = "";

  if (!pets || pets.length === 0) {
    petList.innerHTML = "<p>Nenhum pet encontrado.</p>";
    return;
  }

  pets.forEach((pet) => {
    const card = document.createElement("div");
    card.className = "card";
    /* 🔹 Torna o card clicável para o link do PetFinder */
    card.onclick = () => {
      if (pet.url) {
        window.open(pet.url, "_blank");
      }
    };

    card.innerHTML = `
    <img src="${
      pet.photos[0]?.medium ||
      "https://via.placeholder.com/300x200?text=Sem+foto"
    }" alt="${pet.name}">
    <h3>${pet.name}</h3>
    <p>${
      pet.description
        ? pet.description.substring(0, 100) + "..."
        : "Sem descrição."
    }</p>
    <p><strong>Localização:</strong> ${pet.contact.address.city || ""}</p>
    `;

    petList.appendChild(card);
  });
}

document.getElementById("speciesFilter").addEventListener("change", loadPets);
document.getElementById("ageFilter").addEventListener("change", loadPets);
document.getElementById("genderFilter").addEventListener("change", loadPets);

getToken(); /* ========================================================== */ /*   Home Page.                                               */ /* ========================================================== */

document.addEventListener("DOMContentLoaded", function () {
  const userMenuToggle = document.getElementById("userMenuToggle");
  const userDropdown = document.getElementById("userDropdown");

  if (userMenuToggle && userDropdown) {
    // Toggle dropdown ao clicar no botão
    userMenuToggle.addEventListener("click", function (e) {
      e.stopPropagation();
      userDropdown.classList.toggle("show");
    });

    // Fechar dropdown ao clicar fora
    document.addEventListener("click", function (e) {
      if (
        !userMenuToggle.contains(e.target) &&
        !userDropdown.contains(e.target)
      ) {
        userDropdown.classList.remove("show");
      }
    });

    // Prevenir que cliques dentro do dropdown o fechem
    userDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }
}); /* ========================================================== */ /*   Vacinação Form.                                          */ /* ========================================================== */

document.getElementById("footer-year").textContent = new Date().getFullYear();

// Validação da data
document.querySelector("form").addEventListener("submit", function (e) {
  const dataInput = document.querySelector('input[name="data"]');
  const selectedDate = new Date(dataInput.value);
  const today = new Date();

  if (selectedDate > today) {
    e.preventDefault();
    alert("A data da vacinação não pode ser futura.");
    dataInput.focus();
  }
});

// Auto-complete para vacinas
const vacinaInput = document.querySelector('input[name="id_vacina"]');
const sugestoes = json_encode($sugestoesVacinas);

vacinaInput.addEventListener("input", function () {
  const valor = this.value.toLowerCase();
  if (valor.length > 1) {
    const sugestoesFiltradas = sugestoes.filter((vacina) =>
      vacina.toLowerCase().includes(valor)
    );

    // Se quiser mostrar sugestões em tempo real, pode implementar aqui
    console.log("Sugestões:", sugestoesFiltradas);
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const userMenuToggle = document.getElementById("userMenuToggle");
  const userDropdown = document.getElementById("userDropdown");

  if (userMenuToggle && userDropdown) {
    // Toggle dropdown ao clicar no botão
    userMenuToggle.addEventListener("click", function (e) {
      e.stopPropagation();
      userDropdown.classList.toggle("show");
    });

    // Fechar dropdown ao clicar fora
    document.addEventListener("click", function (e) {
      if (
        !userMenuToggle.contains(e.target) &&
        !userDropdown.contains(e.target)
      ) {
        userDropdown.classList.remove("show");
      }
    });

    // Prevenir que cliques dentro do dropdown o fechem
    userDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }
}); /* ========================================================== */ /*   Vacinação List.                                          */ /* ========================================================== */ /* ========================================================== */ /*   Vacinação Pet.                                          */ /* ========================================================== */

document.getElementById("footer-year").textContent = new Date().getFullYear();
