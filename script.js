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


function confirmDelete(type, id) {
  const deleteUrls = {
    client: "delete-client.php",
    program: "delete-program.php"
  };

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${deleteUrls[type]}?id=${id}`;
    }
  });
}