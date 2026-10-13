<?php include __DIR__ . '/icons.php'; ?>

<div id="preloader">
  <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="M32 12c-6 0-9 3-13 3-4 0-8 3-8 10 0 6 2.5 11 4 17 1.5 5.5 2.5 14 6.5 14 4 0 3.5-9.5 6.5-9.5s2.5 9.5 6.5 9.5c4 0 5-8.5 6.5-14 1.5-6 4-11 4-17 0-7-4-10-8-10-4 0-7-3-13-3Z" fill="#FFDE00"/></svg>
  <div class="load-text">SWISS <b>DENTAL</b></div>
</div>

<div id="scroll-progress"></div>
<div id="cursor-glow"></div>

<header id="site-header">
  <div class="container nav-wrap">
    <a href="index.html" class="brand">
      <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
        <path d="M32 6c-6.5 0-9.5 3.2-13.5 3.2-4.3 0-9 3-9 10.8 0 6.4 2.6 11.7 4.3 18 1.6 5.9 2.7 15 7 15 4.3 0 3.7-10.1 7-10.1s2.7 10.1 7 10.1c4.3 0 5.4-9.1 7-15 1.7-6.3 4.3-11.6 4.3-18 0-7.8-4.7-10.8-9-10.8-4 0-7-3.2-13.5-3.2Z" fill="#FFDE00"/>
        <path d="M20 25l7 7 15-15" stroke="#060606" stroke-width="3.4" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity=".85"/>
        <circle cx="50" cy="12" r="5" fill="#E6273B"/>
      </svg>
      <span class="brand-text">
        <span class="doc">Dr. Vinay Vindas</span>
        <span class="swiss">SWISS</span>
        <span class="dental">DENTAL</span>
      </span>
    </a>

    <nav class="main-nav">
      <a href="index.html">Home</a>
      <div class="nav-dropdown">
        <span class="nav-dd-trigger">Services <svg class="icon nav-caret"><use href="#ic-chevron"/></svg></span>
        <div class="nav-dd-panel">
          <div class="nav-dd-card">
            <div class="nav-dd-grid">
              <a href="#">Orthodontic Treatment</a>
              <a href="#">Dental Implants</a>
              <a href="#">Oral Surgery</a>
              <a href="#">Root Canal Treatment</a>
              <a href="#">Dental Fillings</a>
              <a href="#">Dentures</a>
              <a href="/dental-braces.html">Dental Braces</a>
              <a href="#">Gums Treatment</a>
              <a href="#">Pediatrics Treatment</a>
              <a href="#">Crown and Bridge Treatment</a>
              <a href="#">Teeth Whitening/ Bleacing</a>
            </div>
          </div>
        </div>
      </div>
      <a href="/about.html">About</a>
      <a href="/blog/">Blog</a>
      <a href="/contact.html">Contact</a>
    </nav>

    <div class="header-cta">
      <a href="tel:+919380798985" class="header-call">
        <span class="icon-ring"><svg class="icon"><use href="#ic-phone"/></svg></span>
        <span>Call Now<b>+91 93807 98985</b></span>
      </a>
      <a href="contact.html" class="btn btn-primary">Book Visit</a>
      <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>

<div id="mobile-menu">
  <a href="index.html">Home</a>
  <div class="mm-services">
    <button class="mm-services-toggle" id="mm-services-toggle" type="button">Services <svg class="icon nav-caret"><use href="#ic-chevron"/></svg></button>
    <div class="mm-services-panel" id="mm-services-panel">
              <a href="#">Orthodontic Treatment</a>
              <a href="#">Dental Implants</a>
              <a href="#">Oral Surgery</a>
              <a href="#">Root Canal Treatment</a>
              <a href="#">Crown and Bridge Treatment</a>
              <a href="#">Dentures</a>
              <a href="/dental-braces.html">Dental Braces</a>
              <a href="#">Gums Treatment</a>
              <a href="#">Pediatrics Treatment</a>
              <a href="#">Dental Fillings</a>
              <a href="#">Teeth Whitening/ Bleacing</a>
    </div>
  </div>
  <a href="/about.html">About</a>
  <a href="/blog/">Blog</a>
  <a href="/contact.html">Contact</a>
  <a href="tel:+919380798985" class="btn btn-primary mm-cta">Call +91 93807 98985</a>
</div>
