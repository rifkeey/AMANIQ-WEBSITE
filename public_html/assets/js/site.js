/*
 * AMANIQ — site interactions (vanilla JavaScript, no dependencies).
 * Everything here is progressive enhancement: the site works without it.
 */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var header = document.querySelector('[data-header]');

  /* Header: compact solid state once the page scrolls ------------------------ */
  var toTop = document.querySelector('[data-to-top]');
  var progress = document.querySelector('[data-to-top-progress]');
  var ticking = false;
  function onScroll() {
    var y = window.scrollY;
    if (header) header.classList.toggle('is-scrolled', y > 8);
    if (toTop) {
      toTop.classList.toggle('is-visible', y > 600);
      var max = document.documentElement.scrollHeight - window.innerHeight;
      if (progress && max > 0) progress.style.setProperty('--progress', String(1 - Math.min(y / max, 1)));
    }
    ticking = false;
  }
  window.addEventListener('scroll', function () {
    if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
  }, { passive: true });
  onScroll();

  if (toTop) {
    toTop.addEventListener('click', function (event) {
      event.preventDefault();
      window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
      var main = document.getElementById('main');
      if (main) main.focus({ preventScroll: true });
    });
  }

  /* Desktop dropdowns: hover with intent delay, click/keyboard via toggles ---- */
  var dropdowns = Array.prototype.slice.call(document.querySelectorAll('[data-dropdown]'));
  function setOpen(item, open) {
    item.classList.toggle('is-open', open);
    var toggle = item.querySelector('[data-dropdown-toggle]');
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  function closeAll(except) {
    dropdowns.forEach(function (item) { if (item !== except) setOpen(item, false); });
  }
  var canHover = window.matchMedia('(hover: hover)').matches;
  dropdowns.forEach(function (item) {
    var toggle = item.querySelector('[data-dropdown-toggle]');
    var timer;
    toggle.addEventListener('click', function () {
      var open = !item.classList.contains('is-open');
      closeAll(item);
      setOpen(item, open);
      if (open) {
        var first = item.querySelector('.subnav a');
        if (first && toggle.matches(':focus-visible')) first.focus();
      }
    });
    if (canHover) {
      item.addEventListener('mouseenter', function () { clearTimeout(timer); closeAll(item); setOpen(item, true); });
      item.addEventListener('mouseleave', function () { timer = setTimeout(function () { setOpen(item, false); }, 180); });
    }
    item.addEventListener('focusout', function (event) {
      if (!item.contains(event.relatedTarget)) setOpen(item, false);
    });
  });
  document.addEventListener('click', function (event) {
    if (!event.target.closest('[data-dropdown]')) closeAll();
  });

  /* Mobile menu: focus trap, Escape to close, scroll lock ---------------------- */
  var menuToggle = document.querySelector('[data-menu-toggle]');
  var mobileNav = document.querySelector('[data-mobile-nav]');
  var label = menuToggle && menuToggle.querySelector('.menu-toggle-label');
  function focusables() {
    return Array.prototype.slice.call(mobileNav.querySelectorAll('a[href], summary, button'))
      .filter(function (el) { return el.offsetParent !== null; });
  }
  function openMenu() {
    var rect = header.getBoundingClientRect();
    mobileNav.style.setProperty('--mobile-top', Math.max(rect.bottom, 0) + 'px');
    mobileNav.hidden = false;
    void mobileNav.offsetWidth; // apply the closed state first so the fade-in runs
    mobileNav.classList.add('is-open');
    menuToggle.setAttribute('aria-expanded', 'true');
    if (label) label.textContent = 'Close';
    document.body.classList.add('menu-open');
    var items = focusables();
    if (items.length) items[0].focus();
  }
  function closeMenu(returnFocus) {
    mobileNav.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');
    if (label) label.textContent = 'Menu';
    document.body.classList.remove('menu-open');
    setTimeout(function () { if (menuToggle.getAttribute('aria-expanded') === 'false') mobileNav.hidden = true; }, reduceMotion ? 0 : 300);
    if (returnFocus) menuToggle.focus();
  }
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', function () {
      menuToggle.getAttribute('aria-expanded') === 'true' ? closeMenu(false) : openMenu();
    });
    mobileNav.addEventListener('click', function (event) {
      if (event.target.closest('a[href]')) closeMenu(false);
    });
    document.addEventListener('keydown', function (event) {
      if (menuToggle.getAttribute('aria-expanded') !== 'true') return;
      if (event.key === 'Tab') {
        var items = focusables().concat([menuToggle]);
        var first = items[0], last = items[items.length - 1];
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
      }
    });
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1100 && menuToggle.getAttribute('aria-expanded') === 'true') closeMenu(false);
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    var open = dropdowns.filter(function (d) { return d.classList.contains('is-open'); })[0];
    if (open) { setOpen(open, false); open.querySelector('[data-dropdown-toggle]').focus(); }
    if (menuToggle && menuToggle.getAttribute('aria-expanded') === 'true') closeMenu(true);
  });

  /* Scroll reveals ----------------------------------------------------------- */
  var revealEls = document.querySelectorAll('[data-reveal]');
  var counters = document.querySelectorAll('[data-count]');
  if (!('IntersectionObserver' in window) || reduceMotion) {
    Array.prototype.forEach.call(revealEls, function (el) { el.classList.add('is-visible'); });
  } else {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    Array.prototype.forEach.call(revealEls, function (el) { revealObserver.observe(el); });

    /* Gentle count-up for verified figures only (number of divisions, practice areas). */
    var countObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        countObserver.unobserve(entry.target);
        var el = entry.target, target = parseInt(el.getAttribute('data-count'), 10), start = null;
        function step(ts) {
          if (!start) start = ts;
          var t = Math.min((ts - start) / 900, 1);
          el.textContent = String(Math.max(1, Math.round(target * (1 - Math.pow(1 - t, 3)))));
          if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      });
    }, { threshold: 0.6 });
    Array.prototype.forEach.call(counters, function (el) { countObserver.observe(el); });
  }

  /* FAQ accordion: animate <details> height (works natively without JS) ------- */
  if (!reduceMotion) {
    Array.prototype.forEach.call(document.querySelectorAll('.faq-item'), function (details) {
      var summary = details.querySelector('summary');
      var answer = details.querySelector('.faq-answer');
      summary.addEventListener('click', function (event) {
        event.preventDefault();
        if (details.dataset.animating) return;
        details.dataset.animating = '1';
        var opening = !details.open;
        if (opening) details.open = true;
        var full = answer.scrollHeight;
        var anim = answer.animate(
          [{ height: (opening ? 0 : full) + 'px', opacity: opening ? 0 : 1 }, { height: (opening ? full : 0) + 'px', opacity: opening ? 1 : 0 }],
          { duration: 380, easing: 'cubic-bezier(0.2, 0.7, 0.2, 1)' }
        );
        anim.onfinish = function () {
          if (!opening) details.open = false;
          delete details.dataset.animating;
        };
      });
    });
  }

  /* Enquiry form: friendly client-side validation (the server re-validates) --- */
  var form = document.querySelector('[data-enquiry-form]');
  if (form) {
    var messages = {
      name: 'Please enter your full name.',
      email: 'Please enter a valid email address, for example name@company.com.',
      phone: 'Please enter a valid telephone number, or leave this blank.',
      enquiry_type: 'Please choose the type of enquiry.',
      subject: 'Please add a short subject.',
      message: 'Please tell us a little more about your enquiry (at least 20 characters).',
      consent: 'Please confirm you have read the privacy notice.'
    };
    function showError(field, text) {
      var wrapper = field.closest('.field');
      var id = field.id + '-error';
      var existing = document.getElementById(id);
      if (!text) {
        if (existing) existing.remove();
        wrapper.classList.remove('has-error');
        field.removeAttribute('aria-invalid');
        field.removeAttribute('aria-describedby');
        return;
      }
      if (!existing) {
        existing = document.createElement('p');
        existing.className = 'field-error';
        existing.id = id;
        wrapper.appendChild(existing);
      }
      existing.textContent = text;
      wrapper.classList.add('has-error');
      field.setAttribute('aria-invalid', 'true');
      field.setAttribute('aria-describedby', id);
    }
    function check(field) {
      if (field.name === 'message' && field.value.trim().length < 20) return messages.message;
      if (field.name === 'name' && field.value.trim().length < 2) return messages.name;
      if (field.name === 'subject' && field.value.trim().length < 3) return messages.subject;
      return field.checkValidity() ? '' : (messages[field.name] || field.validationMessage);
    }
    var fields = form.querySelectorAll('input:not([type=hidden]):not([name=website]), select, textarea');
    Array.prototype.forEach.call(fields, function (field) {
      field.addEventListener('blur', function () { if (field.value !== '' || field.type === 'checkbox') showError(field, check(field)); });
      field.addEventListener('input', function () { if (field.closest('.has-error')) showError(field, check(field)); });
      field.addEventListener('change', function () { if (field.closest('.has-error')) showError(field, check(field)); });
    });
    form.addEventListener('submit', function (event) {
      var firstInvalid = null;
      Array.prototype.forEach.call(fields, function (field) {
        var error = check(field);
        showError(field, error);
        if (error && !firstInvalid) firstInvalid = field;
      });
      if (firstInvalid) {
        event.preventDefault();
        firstInvalid.focus();
        return;
      }
      var button = form.querySelector('[data-submit]');
      var buttonLabel = form.querySelector('[data-submit-label]');
      if (button) {
        if (button.classList.contains('is-loading')) { event.preventDefault(); return; }
        button.classList.add('is-loading');
        button.setAttribute('aria-disabled', 'true');
        if (buttonLabel) buttonLabel.textContent = 'Sending…';
      }
    });
    var alertBox = form.querySelector('[data-form-alert]');
    if (alertBox) alertBox.focus();
  }
})();
