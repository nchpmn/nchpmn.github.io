// This script only ever runs on the landing page ("/"), and only ever
// handles the two splash links. Every other link on the site (nav menu,
// swap button) is a plain <a href> - a real page load, nothing fancy.
//
// Flow on splash click:
//   1. fetch the target page (/nathan/ or /tidbits/)
//   2. drop its nav + content + footer into the (currently empty) landing
//      page, so it appears directly underneath the splash
//   3. update the URL with pushState (no reload)
//   4. smooth-scroll down so the new nav lands at the top of the viewport
//   5. once that settles, collapse and remove the splash entirely - from
//      this point on the landing page is gone, same as if you had loaded
//      /nathan/ directly
(function () {
  var splash = document.getElementById('splash');
  if (!splash) return;

  var nav = document.getElementById('sitenav');
  var content = document.getElementById('content');
  var footer = document.getElementById('sitefooter');

  document.querySelectorAll('.splash-half').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      var url = el.getAttribute('href');

      fetch(url)
        .then(function (res) {
          if (!res.ok) throw new Error('Route not found: ' + url);
          return res.text();
        })
        .then(function (html) {
          var doc = new DOMParser().parseFromString(html, 'text/html');

          document.title = doc.title;
          document.body.dataset.theme = doc.body.dataset.theme || '';
          nav.innerHTML = doc.getElementById('sitenav').innerHTML;
          content.innerHTML = doc.getElementById('content').innerHTML;
          footer.innerHTML = doc.getElementById('sitefooter').innerHTML;

          history.pushState({ url: url }, '', url);

          nav.scrollIntoView({ behavior: 'smooth', block: 'start' });

          // Once the smooth scroll has landed (nav flush at the top of the
          // viewport, splash scrolled fully out of view above it), remove
          // the splash and reset scroll to 0 in the same tick. Nav's
          // position in the viewport doesn't change - it's just now at
          // the top of a shorter document instead of scrolled-to within a
          // taller one - so there's no visible jump.
          function finishTransition() {
            splash.remove();
            window.scrollTo(0, 0);
          }
          if ('onscrollend' in window) {
            window.addEventListener('scrollend', finishTransition, { once: true });
          } else {
            setTimeout(finishTransition, 600);
          }
        })
        .catch(function () {
          // Always have a working fallback: a real navigation.
          window.location.href = url;
        });
    });
  });

  // If the user hits the browser back button after transitioning away,
  // just reload - simplest way to guarantee the DOM matches the URL.
  window.addEventListener('popstate', function () {
    window.location.reload();
  });
})();
