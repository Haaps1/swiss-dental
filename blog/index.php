<?php

require_once '../config/database.php';

$result = $conn->query("
    SELECT *
    FROM blogs
    WHERE status = 'published'
    ORDER BY COALESCE(published_date, created_at) DESC
");

$pageTitle = 'Dental Health Blog | Swiss Dental, Bangalore';
$pageDesc  = 'Tips, comparisons and honest answers on dental care from Swiss Dental, Bangalore — implants vs dentures, root canal myths, child dental visits, teeth whitening and more.';
include '../partials/head.php';
?>
<body>

<?php include '../partials/header.php'; ?>

<main>

  <section class="page-hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <div class="container">
      <span class="eyebrow" data-aos="up">Dental Health Blog</span>
      <h1 data-aos="up" data-aos-delay="100">Tips &amp; Answers For A <span class="text-grad">Healthier Smile</span></h1>
      <p class="crumb" data-aos="up" data-aos-delay="180"><a href="index.html">Home</a> / <span>Blog</span></p>
    </div>
  </section>

  <section class="section-pad" style="padding-top:0;">
    <div class="container">
      <div class="blog-grid">

        <?php while ($blog = $result->fetch_assoc()): ?>

<a href="post.php?slug=<?php echo urlencode($blog['slug']); ?>" class="blog-card" data-aos="up">

    <div class="blog-img">
        <?php if (!empty($blog['featured_image'])): ?>
            <img
                src="<?php echo htmlspecialchars($blog['featured_image']); ?>"
                alt="<?php echo htmlspecialchars($blog['title']); ?>"
                loading="lazy"
            >
        <?php endif; ?>
    </div>

    <div class="blog-body">

        <span class="blog-date">
            <?php
            echo date(
                'M j, Y',
                strtotime($blog['published_date'] ?: $blog['created_at'])
            );
            ?>
        </span>

        <h3><?php echo htmlspecialchars($blog['title']); ?></h3>

        <p>
            <?php
            $excerpt = strip_tags($blog['content']);
            echo htmlspecialchars(mb_substr($excerpt, 0, 150)) . '...';
            ?>
        </p>

        <span class="blog-read">
            Read More
            <svg class="icon" style="width:14px;height:14px;">
                <use href="#ic-chevron"/>
            </svg>
        </span>

    </div>

</a>

<?php endwhile; ?>

      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section-pad" style="padding-top:0;">
    <div class="container">
      <div class="cta-banner" data-aos="zoom">
        <h2>Have A Question We <span class="text-grad">Didn't Cover</span>?</h2>
        <p>Book a free consultation with Swiss Dental, Bangalore — we're happy to help.</p>
        <div class="btn-row">
          <a href="tel:+919380798985" class="btn btn-primary"><svg class="icon"><use href="#ic-phone"/></svg> Call +91 93807 98985</a>
          <a href="https://wa.me/919380798985?text=Hi%20Swiss%20Dental%2C%20I%20have%20a%20question" target="_blank" rel="noopener" class="btn btn-red"><svg class="icon"><use href="#ic-whatsapp"/></svg> WhatsApp Us</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include '../partials/footer.php'; ?>
