<?php
include __DIR__ . "/admin/layouts/config.php"; // Database connection

// Fetch all blog entries
$sql = "SELECT id, main_image, title FROM blog ORDER BY id DESC";
$result = $link->query($sql);

if (!$result) {
  die("<div class='alert alert-danger'>Query failed: " . $link->error . "</div>");
}
?>

<?php include "header.php"; ?>

<style>
  /* Blog Card Styling */
  .blog-boxarea {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .blog-boxarea:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
  }

  .blog-boxarea .img1 {
    position: relative;
    overflow: hidden;
    height: 20rem; /* Fixed height */
  }

  .blog-boxarea img {
    width: 100%;
    height: 100%; /* Fill the container */
    object-fit: cover; /* Prevents distortion */
    transition: transform 0.3s ease-in-out;
  }

  .blog-boxarea:hover img {
    transform: scale(1.05);
  }

  .content-area {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .blog-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    word-wrap: break-word; /* Ensures long words wrap */
  }

  .readmore {
    display: inline-block;
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
    font-size: 1rem;
    margin-top: auto;
    transition: color 0.3s ease-in-out;
  }

  .readmore:hover {
    color: #0056b3;
    text-decoration: underline;
  }

  /* Responsive Fixes */
  @media (max-width: 768px) {
    .blog-title {
      font-size: 1.1rem;
    }
    .readmore {
      font-size: 0.95rem;
    }
  }
</style>

<div class="blog-inner-section-area sp6" style="margin-top: 80px;">
  <div class="container">
    <div class="row">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col-lg-4 col-md-6 mb-4 d-flex">
          <div class="blog-boxarea d-flex flex-column">
            <div class="img1">
              <?php
              $imagePath = trim($row['main_image']); // Ensure no extra spaces
              $fullImagePath = !empty($imagePath) ? "admin/" . $imagePath : "assets/img/default-image.jpg";
              ?>
              <img src="<?php echo htmlspecialchars($fullImagePath); ?>" alt="Blog Image">
            </div>

            <div class="content-area text-center">
              <h5 class="blog-title"><?php echo htmlspecialchars($row['title']); ?></h5>
              <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="readmore">
                Read More <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>

