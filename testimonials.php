<?php
// testimonials.php
// Starter: array-based testimonials now, easy to swap to DB later.

$testimonials = [
  [
    "name" => "Naledi M.",
    "role" => "Project Coordinator",
    "company" => "BrightPath",
    "message" => "Reliable, fast, and communicative. Our site went from idea to clean launch without the usual chaos.",
    "rating" => 5,
    "date" => "2026-02-10"
  ],
  [
    "name" => "Thabo K.",
    "role" => "Small Business Owner",
    "company" => "Kasi Mart",
    "message" => "The attention to detail was top-tier. They explained things clearly and delivered exactly what we needed.",
    "rating" => 5,
    "date" => "2026-01-28"
  ],
  [
    "name" => "Ayesha D.",
    "role" => "Operations Lead",
    "company" => "Northwind Ops",
    "message" => "Great structure and a professional finish. The handover notes made maintenance easy.",
    "rating" => 4,
    "date" => "2026-01-12"
  ],
  [
    "name" => "Sibusiso N.",
    "role" => "Student Founder",
    "company" => "UniLaunch",
    "message" => "Super helpful and patient. Turnaround time was quick and the result looks modern.",
    "rating" => 4,
    "date" => "2025-12-05"
  ],
];

// --- Filtering & sorting (server-side via GET) ---
$selectedRating = isset($_GET["rating"]) ? (int)$_GET["rating"] : 0; // 0 = All
$sort = isset($_GET["sort"]) ? $_GET["sort"] : "newest";

$filtered = array_filter($testimonials, function ($t) use ($selectedRating) {
  if ($selectedRating === 0) return true;
  return (int)$t["rating"] === $selectedRating;
});

usort($filtered, function ($a, $b) use ($sort) {
  $da = strtotime($a["date"]);
  $db = strtotime($b["date"]);
  if ($sort === "oldest") return $da <=> $db;
  return $db <=> $da; // newest first
});

function e($value) {
  return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function renderStars($rating) {
  $rating = max(1, min(5, (int)$rating));
  $out = "";
  for ($i = 1; $i <= 5; $i++) {
    $out .= ($i <= $rating) ? "★" : "☆";
  }
  return $out;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Testimonials</title>
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>

  <!-- Navbar -->
  <header class="site-header">
    <nav class="nav container">
      <a class="brand" href="index.php">YourBrand</a>
      <div class="nav-links">
        <a href="index.php#home">Home</a>
        <a href="index.php#about">About</a>
        <a href="index.php#services">Services</a>
        <a class="active" href="testimonials.php">Testimonials</a>
        <a href="index.php#contact">Contact</a>
      </div>
    </nav>
  </header>

  <main class="container page">
    <!-- Page heading -->
    <section class="page-hero">
      <h1>Testimonials</h1>
      <p class="muted">
        What clients and collaborators say. (For now, these are placeholders you can replace anytime.)
      </p>
    </section>

    <!-- Filter bar -->
    <section class="filter-bar" aria-label="Testimonials filters">
      <form method="get" class="filter-form">
        <div class="field">
          <label for="rating">Rating</label>
          <select name="rating" id="rating">
            <option value="0" <?php if ($selectedRating === 0) echo "selected"; ?>>All</option>
            <option value="5" <?php if ($selectedRating === 5) echo "selected"; ?>>5 stars</option>
            <option value="4" <?php if ($selectedRating === 4) echo "selected"; ?>>4 stars</option>
            <option value="3" <?php if ($selectedRating === 3) echo "selected"; ?>>3 stars</option>
          </select>
        </div>

        <div class="field">
          <label for="sort">Sort</label>
          <select name="sort" id="sort">
            <option value="newest" <?php if ($sort === "newest") echo "selected"; ?>>Newest</option>
            <option value="oldest" <?php if ($sort === "oldest") echo "selected"; ?>>Oldest</option>
          </select>
        </div>

        <button type="submit" class="btn">Apply</button>
        <a class="btn btn-ghost" href="testimonials.php">Reset</a>
      </form>

      <p class="muted small">
        Showing <strong><?php echo count($filtered); ?></strong> testimonial(s)
      </p>
    </section>

    <!-- Testimonials grid -->
    <section class="grid" aria-label="Testimonials list">
      <?php if (count($filtered) === 0): ?>
        <div class="empty">
          <h2>No testimonials found</h2>
          <p class="muted">Try changing the rating filter.</p>
        </div>
      <?php endif; ?>

      <?php foreach ($filtered as $t): ?>
        <article class="card">
          <div class="card-top">
            <div class="stars" aria-label="Rating: <?php echo e($t["rating"]); ?> out of 5">
              <?php echo e(renderStars($t["rating"])); ?>
            </div>
            <time class="date" datetime="<?php echo e($t["date"]); ?>">
              <?php echo e(date("d M Y", strtotime($t["date"]))); ?>
            </time>
          </div>

          <p class="message">“<?php echo e($t["message"]); ?>”</p>

          <div class="person">
            <div class="avatar" aria-hidden="true"><?php echo e(mb_substr($t["name"], 0, 1)); ?></div>
            <div class="who">
              <div class="name"><?php echo e($t["name"]); ?></div>
              <div class="role muted">
                <?php echo e($t["role"]); ?>
                <?php if (!empty($t["company"])): ?>
                  <span class="dot">•</span> <?php echo e($t["company"]); ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-inner">
      <div>
        <strong>YourBrand</strong>
        <p class="muted small">Professional web solutions with clean delivery and clear communication.</p>
      </div>
      <div class="footer-links">
        <a href="index.php#home">Home</a>
        <a href="index.php#services">Services</a>
        <a href="index.php#contact">Contact</a>
      </div>
      <div class="muted small">© <?php echo date("Y"); ?> YourBrand. All rights reserved.</div>
    </div>
  </footer>

</body>
</html>
