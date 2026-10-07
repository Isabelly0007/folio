// Envio do formulário "Fale Conosco" do rodapé sem sair da página
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contatoForm");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const botao = form.querySelector("button[type=submit]");
    if (botao) botao.disabled = true;

    try {
      const resposta = await fetch(form.getAttribute("action"), {
        method: "POST",
        body: new FormData(form),
      });
      const texto = (await resposta.text()).trim();

      if (texto === "success") {
        alert("✅ Mensagem enviada com sucesso!");
        form.reset();
      } else {
        alert("❌ Ocorreu um erro ao enviar. Tente novamente.");
      }
    } catch (err) {
      console.error(err);
      alert("❌ Erro de conexão. Tente novamente.");
    } finally {
      if (botao) botao.disabled = false;
    }
  });
});
