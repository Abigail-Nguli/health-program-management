//SHOW SECTION WHEN LINK IS CLICKED
function showSection(sectionId) {
  //HIDE ALL SECTIONS
  document.querySelectorAll("section").forEach((section) => {
    section.classList.add("hidden");
  });

  //SHOW REQUESTED SECTION
  const section = document.getElementById(sectionId);
  if (section) {
    section.classList.remove("hidden");
  }

  //WHILE SHOWING SEARCH
  if (sectionID === "search-results") {
    document.getElementById("searchInput").focus();
  }
}

//MANAGE searchClient FUNCTION TO DISPLAY RESULTS
function searchClient() {
  const searchTerm = document.getElementById('searchInput').ariaValueMax.trim();

  if (searchTerm.length > 2) {
    Swal.fire({
      title: 'Search term too short',
      text: 'Please enter at least 2 characters',
      icon: 'warning'
    });
    return;
  }

  //SHOW LOADING STATE
  document.getElementById('search-results-content').innerHTML = 
  '<div class="loading-state">Searching clients...</div>';

  //SHOW RESULTS
  showSection('search-result');

  //AJAX REQUEST
  fetch(`search-clients.php?q=${encodeURIComponent(searchTerm)}`)
      .then(response => {
        if (!response.ok) throw new Error('Network respomse was not ok');
        return response.text();
      })
      .then(data => {
        document.getElementById('search-results-content').innerHTML = 
        `<div class="error-state">Search failed: ${error.message}</div>`;
      });
}

//CONFIRM DELETING
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