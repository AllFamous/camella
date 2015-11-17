$(function() {
    var availableTags = [
"Aklan",
"Albay",
"Angeles / Porac",
"Antipolo City",
"Apalit",
"Bacolod",
"Bacoor",
"Balanga",
"Baliwag",
"Bantay / Vigan",
"Bataan",
"Batangas",
"Batangas City",
"Binangonan",
"Bohol",
"Bulacan",
"Bulakan",
"Cabanatuan",
"Cagayan",
"Cagayan de Oro",
"Caloocan / Valenzuela",
"Camarines Sur",
"Camella Aklan",
"Camella Alta Silang",
"Camella Altea",
"Camella Azienda",
"Camella Bacolod",
"Camella Baliwag",
"Camella Bantay",
"Camella Bataan",
"Camella Batangas City",
"Camella Bohol",
"Camella Bulakan",
"Camella Cagayan",
"Camella CamSur",
"Camella Candon",
"Camella Capiz",
"Camella Carcar",
"Camella Cauayan",
"Camella Cerritos",
"Camella Cerritos CDO",
"Camella Cerritos East",
"Camella Crestwood",
"Camella Dasma at The Islands",
"Camella Del Rio",
"Camella Dos Rios",
"Camella Dumaguete",
"Camella Elisande",
"Camella Fiorenza",
"Camella Frontiera",
"Camella Gapan",
"Camella Glenmont",
"Camella Gran Europa",
"Camella Heights",
"Camella La Brisa",
"Camella La Montagna",
"Camella Laoag",
"Camella Legazpi",
"Camella Lessandra Bacoor",
"Camella Lessandra Bucandala",
"Camella Leyte",
"Camella Lipa",
"Camella Naga",
"Camella Nueva Ecija",
"Camella Orani",
"Camella Ozamiz",
"Camella Pagadian",
"Camella Palo",
"Camella Pampanga",
"Camella Pasadena",
"Camella Provence",
"Camella Puerto Princesa",
"Camella Quezon",
"Camella Riverfront",
"Camella Rizal",
"Camella San Jose Del Monte",
"Camella San Pablo",
"Camella Santiago",
"Camella Savannah City",
"Camella Sierra Metro East",
"Camella Solamente",
"Camella Sorrento",
"Camella Sto. Tomas",
"Camella Taal",
"Camella Tagum",
"Camella Tanza",
"Camella Tierra Nevada (Vita @ Tierra Nevada)",
"Camella Trece",
"Camella Tuguegarao",
"Camella Verra Metro North",
"Candon",
"Capiz",
"Carcar",
"Cauayan",
"Cavite",
"Cebu",
"Cebu City",
"Dasmariņas",
"Davao del",
"Davao del Norte",
"Dumaguete",
"Gapan",
"General Trias",
"Ilocos Norte",
"Ilocos Sur",
"Iloilo",
"Imus",
"Isabela",
"Laguna",
"Laoag",
"Lapu-Lapu City (Mactan)",
"Las Pinas",
"Legazpi",
"Leyte",
"Lipa City",
"Luzon",
"Malolos",
"Mexico / San Fernando",
"Mindanao",
"Misamis Occidental",
"Misamis Oriental",
"Naga",
"Negros Occidental",
"Negros Oriental",
"Nueva Ecija",
"Numancia",
"Orani",
"Ormoc",
"Ozamis City",
"Pagadian City",
"Palawan",
"Palo",
"Pampanga",
"Pangasinan",
"Pasig",
"Pavia-Oton-San Miguel",
"Pili",
"Plantacion Meridienne",
"Puerto Prinsesa",
"Quezon",
"Quezon City",
"Riverdale",
"Rizal",
"Roxas City",
"San Jose Del Monte",
"San Pablo",
"Santiago",
"Silang",
"Sta. Barbara / Urdaneta",
"Sta. Rosa / Cabuyao",
"Sto. Tomas",
"Taal",
"Tagbilaran City",
"Taguig - Fort",
"Tagum",
"Talisay",
"Tanauan",
"Tanza",
"Tayabas / Lucena",
"Teresa",
"Trece Martirez",
"Tuguegarao",
"Visayas",
"Zamboanga del Sur" 
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });