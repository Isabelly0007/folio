let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};
window.onscroll = () => {
  menu.classList.remove("bx-x");
  navbar.classList.remove("active");
};

document
  .getElementById("contatoForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault(); // evita recarregar a página

    const formData = new FormData(this);

    try {
      const response = await fetch("../enviar_email.php", {
        method: "POST",
        body: formData,
      });
      const texto = (await response.text()).trim();

      if (texto === "success") {
        alert("✅ Mensagem enviada com sucesso!");
        this.reset(); // limpa o formulário
      } else {
        alert("❌ Ocorreu um erro ao enviar. Tente novamente.");
      }
    } catch (err) {
      alert("❌ Erro de conexão. Tente novamente.");
      console.error(err);
    }
  });
