function showSection(section) {
  const sections = ["health", "clients", "enroll"];
  sections.forEach((sec) => {
    document.getElementById(sec).classList.add("hidden");
  });
  if (sections.includes(section)) {
    document.getElementById(section).classList.remove("hidden");
  } else {
    document.getElementById("default-message").classList.remove("hidden");
  }
}

function searchClient() {
  const input = document.getElementById("searchInput").value.trim();
  const defaultMessage = document.getElementById("default-message");

  //HIDE ALL SECTIONS
  const container = document.getElementById("content-container");
  container
    .querySelectorAll("section")
    .forEach((s) => s.classList.add("hidden"));

  defaultMessage.classList.remove("hidden");

  const searchMessage = input
    ? `Search results for "${input}": (Display search results here)`
    : "Please enter a search term!";

  defaultMessage.textContent = searchMessage;
}
