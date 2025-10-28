/* public/js/brand-ajax.js — AJAX brand filter for public pages */
(function(){
  function init(){
    const sidebar = document.querySelector('.brand-grid');
    const results = document.getElementById('results');
    if(!sidebar || !results) return;

    function updateActiveFromURL(){
      try{
        const u = new URL(location.href);
        const brand = u.searchParams.get('brand');
        sidebar.querySelectorAll('a.brand-logo').forEach(a => {
          const id = a.getAttribute('data-brand-id');
          const isActive = brand && id && (String(id) === String(brand));
          a.classList.toggle('is-active', !!isActive);
          a.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
      }catch(_){/* ignore */}
    }

    async function load(url, push){
      try{
        results.classList.add('is-loading');
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const html = await res.text();
        const doc  = new DOMParser().parseFromString(html, 'text/html');
        const next = doc.getElementById('results')
                 || doc.querySelector('main .mobile-grid')
                 || doc.querySelector('main .news-list');
        if (next){
          results.innerHTML = next.innerHTML;
        } else {
          // fallback to hard navigation if structure not found
          location.assign(url); return;
        }
        if (push) history.pushState({}, '', url);
        updateActiveFromURL();
        // polite scroll
        const y = results.getBoundingClientRect().top + window.scrollY - 12;
        window.scrollTo({ top: y, behavior: 'smooth' });
      } catch (e){
        location.assign(url);
      } finally {
        results.classList.remove('is-loading');
      }
    }

    sidebar.addEventListener('click', (e) => {
      const a = e.target.closest('a.brand-logo');
      if(!a) return;
      e.preventDefault();
      load(a.href, true);
    });

    window.addEventListener('popstate', () => load(location.href, false));
    updateActiveFromURL();
  }

  if (document.readyState === 'loading')
    document.addEventListener('DOMContentLoaded', init, { once:true });
  else init();
})();

