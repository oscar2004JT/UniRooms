document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
    
    const searchInput = document.getElementById("search-input");
    const zoneSelect = document.getElementById("zone-select");
    const typeSelect = document.getElementById("type-select");
    const priceMin = document.getElementById("price-min");
    const priceMax = document.getElementById("price-max");

    const cards = document.querySelectorAll("#rooms-container > div");

    function filtrar() {
        const text = searchInput?.value.toLowerCase() || "";
        const zone = zoneSelect?.value || "all";
        const tipo = typeSelect?.value || "all";
        const pMin = Number(priceMin?.value || 0);
        const pMax = Number(priceMax?.value || 999999);

        cards.forEach(card => {
            const name = card.querySelector("h3").textContent.toLowerCase();
            const zona = card.dataset.zona || "";
            const tipoHab = card.dataset.tipo || "";
            const precio = Number(card.dataset.precio || 0);

            const visible = 
                name.includes(text) &&
                (zone === "all" || zona === zone) &&
                (tipo === "all" || tipoHab === tipo) &&
                precio >= pMin &&
                precio <= pMax;

            card.style.display = visible ? "block" : "none";
        });
    }

    searchInput && searchInput.addEventListener("input", filtrar);
    zoneSelect && zoneSelect.addEventListener("change", filtrar);
    typeSelect && typeSelect.addEventListener("change", filtrar);
    priceMin && priceMin.addEventListener("input", filtrar);
    priceMax && priceMax.addEventListener("input", filtrar);
});
