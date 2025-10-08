document.addEventListener("DOMContentLoaded", function(){
    const input = document.getElementById('searchInput');
    const results = document.getElementById('results');
    if(!input) return;
    input.addEventListener('keyup', function(){
      const q = input.value.trim();
      if(q.length === 0){ results.innerHTML = ''; return; }
      fetch('search_ajax.php?q=' + encodeURIComponent(q))
        .then(r => r.text()).then(html => results.innerHTML = html);
    });
  });
  