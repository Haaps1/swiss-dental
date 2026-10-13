<?php

require_once '../config/database.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    http_response_code(404);
    die('Blog not found');
}

$stmt = $conn->prepare("
    SELECT *
    FROM blogs
    WHERE slug = ?
      AND status = 'published'
    LIMIT 1
");

$stmt->bind_param("s", $slug);
$stmt->execute();

$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    http_response_code(404);
    die('Blog not found');
}

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = !empty($blog['meta_title'])
    ? $blog['meta_title']
    : $blog['title'] . ' | Swiss Dental';

$pageDesc = !empty($blog['meta_description'])
    ? $blog['meta_description']
    : mb_substr(strip_tags($blog['content']), 0, 155);

include '../partials/head.php';

?>

<body>

<?php include '../partials/header.php'; ?>

<main>

  <!-- HERO -->

  <section class="page-hero">

    <div class="hero-bg"></div>
    <div class="hero-grid"></div>

    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>

    <div class="container">

      <span class="eyebrow" data-aos="up">
        <?php echo htmlspecialchars($blog['focus_keyword'] ?: 'Dental Care'); ?>
      </span>

      <h1 data-aos="up" data-aos-delay="100">
        <?php echo htmlspecialchars($blog['title']); ?>
      </h1>

      <p class="crumb" data-aos="up" data-aos-delay="180">
        <a href="/">Home</a>
        /
        <a href="/blog/">Blog</a>
        /
        <span><?php echo htmlspecialchars($blog['title']); ?></span>
      </p>

    </div>

  </section>


  <!-- ARTICLE -->

  <section class="section-pad" style="padding-top:0;">

    <div class="container article-wrap">

      <a href="/blog/" class="article-back" data-aos="up">

        <svg class="icon" style="transform:rotate(180deg);">
          <use href="#ic-chevron"/>
        </svg>

        Back to Blog

      </a>


      <!-- FEATURED IMAGE -->

      <?php if (!empty($blog['featured_image'])): ?>

      <div class="article-cover" data-aos="up">

        <img
          src="<?php echo htmlspecialchars($blog['featured_image']); ?>"
          alt="<?php echo htmlspecialchars($blog['title']); ?>"
          loading="lazy"
        >

      </div>

      <?php endif; ?>


      <!-- META -->

      <div class="article-meta" data-aos="up">

        <span>
          <?php echo htmlspecialchars($blog['author'] ?: 'Swiss Dental'); ?>
        </span>

        <span class="dot"></span>

        <span>
          <?php
          echo date(
              'M j, Y',
              strtotime($blog['published_date'] ?: $blog['created_at'])
          );
          ?>
        </span>

      </div>


      <!-- ARTICLE CONTENT -->

      <div class="article-body">

        <?php echo $blog['content']; ?>


        <!-- CTA -->

        <div class="article-cta-box">

          <p>
            <strong style="color:var(--white);">
              Not sure what treatment is right for you?
            </strong>

            Book a consultation at Swiss Dental and get personalised guidance for your dental needs.
          </p>

          <a href="/contact.html" class="btn btn-primary">
            Book Your Consultation →
          </a>

          <p class="contact-line">
            📞 +91 93807 98985
            &nbsp;|&nbsp;
            📍 Sarjapura Road, Kodathi Gate, Bangalore
          </p>

        </div>

      </div>

    </div>

  </section>

</main>

<?php include '../partials/footer.php'; ?>
