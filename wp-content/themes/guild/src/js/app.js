import Collapse from "bootstrap/js/dist/collapse";
import Dropdown from "bootstrap/js/dist/dropdown";

document.addEventListener("DOMContentLoaded", () => {
  // Mobile navigation.
  const menuElement = document.getElementById("navbarNav");
  const togglerButton = document.getElementById("navbarToggle");

  if (menuElement && togglerButton) {
    Collapse.getOrCreateInstance(menuElement, {
      toggle: false,
    });
  }

  // Roster controls.
  const industryFilter = document.getElementById("industry-filter");
  const locationFilter = document.getElementById("location-filter");
  const searchInput = document.getElementById("expert-search");
  const expertList = document.getElementById("expert-list");

  // Other pages don't have a roster.
  if (!industryFilter || !locationFilter || !searchInput || !expertList) {
    return;
  }

  // Custom roster dropdowns.
  document.querySelectorAll(".roster-dropdown").forEach((dropdown) => {
    const toggle = dropdown.querySelector(".roster-filter-toggle");
    const label = dropdown.querySelector(".filter-label");
    const input = dropdown.querySelector('input[type="hidden"]');
    const options = dropdown.querySelectorAll(".dropdown-item");
    const instance = Dropdown.getOrCreateInstance(toggle);

    options.forEach((option) => {
      option.addEventListener("click", () => {
        input.value = option.dataset.value;
        label.textContent = option.textContent.trim();

        options.forEach((item) => {
          item.setAttribute("aria-pressed", String(item === option));
        });

        input.dispatchEvent(new Event("change", { bubbles: true }));

        instance.hide();
        toggle.focus();
      });
    });
  });

  const cards = expertList.querySelectorAll(".expert-card");

  if (cards.length === 0) {
    return;
  }

  const resultsMessage = document.createElement("p");
  resultsMessage.setAttribute("role", "status");
  resultsMessage.setAttribute("aria-live", "polite");
  expertList.after(resultsMessage);

  function filterExperts() {
    const selectedIndustry = industryFilter.value;
    const selectedLocation = locationFilter.value;
    const searchTerm = searchInput.value.trim().toLowerCase();

    let visibleCount = 0;

    cards.forEach((card) => {
      const name = (card.dataset.name || "").toLowerCase();
      const locationId = card.dataset.location || "";
      const industryIds = (card.dataset.industries || "")
        .split(",")
        .filter(Boolean);

      const matchesName = name.includes(searchTerm);
      const matchesLocation =
        selectedLocation === "" || locationId === selectedLocation;
      const matchesIndustry =
        selectedIndustry === "" || industryIds.includes(selectedIndustry);

      const matches = matchesName && matchesLocation && matchesIndustry;

      card.classList.toggle("d-none", !matches);

      if (matches) {
        visibleCount++;
      }
    });

    resultsMessage.textContent = visibleCount === 0 ? "No Expert Found." : "";
  }

  industryFilter.addEventListener("change", filterExperts);
  locationFilter.addEventListener("change", filterExperts);
  searchInput.addEventListener("input", filterExperts);

  filterExperts();
});
