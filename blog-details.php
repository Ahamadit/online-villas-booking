<?php
include __DIR__ . "/admin/layouts/config.php"; // Database connection
include "header.php";

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div class='alert alert-danger text-center mt-5'>Invalid Blog ID</div>");
}

$blog_id = intval($_GET['id']); // Sanitize input

// Fetch blog post details
$sql = "SELECT id, main_image, title, written_by, content, main_content FROM blog WHERE id = ?";
$stmt = $link->prepare($sql);
if (!$stmt) {
    die("Query preparation failed: " . $link->error);
}

$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<div class='alert alert-danger text-center mt-5'>Blog post not found</div>");
}

$blog = $result->fetch_assoc();

// Function to format text with headings
function formatContent($text)
{
    // Convert "1. Something" into "<h2>1. Something</h2>"
    $text = preg_replace('/(\d+)\.\s*(.+)/', '<h2 class="blog-heading">$1. $2</h2>', $text);
    return nl2br($text);
}
?>

<div class="inner-main-hero-area">
    <div class="img1"><img src="assets/img/all-images/hero/hero-img1.png" alt=""></div>
    <div class="img2"><img src="assets/img/all-images/hero/hero-img2.png" alt=""></div>
</div>

<!-- Blog Content -->
<div class="container my-5">
    <div class="text-center mb-4">
        <img src="<?php echo htmlspecialchars("admin/" . $blog['main_image']); ?>"
            alt="Blog Image"
            class="img-fluid rounded"
            style="width: 100%; height: 30rem; object-fit: cover; border-radius: 12px;">
    </div>


    <!-- Blog Title -->
    <h1 class="blog-title text-center  fw-bold"> <?php echo htmlspecialchars($blog['title']); ?> </h1>

    <!-- Blog Author -->
    <?php if (!empty($blog['written_by'])) { ?>
        <h5 class="blog-author text-center text-muted">Written by: <?php echo htmlspecialchars($blog['written_by']); ?></h5>
    <?php } ?>

    <hr class="my-4">

    <!-- Blog Content -->
    <div class="blog-content lead lh-lg">
        <?php echo formatContent(htmlspecialchars($blog['content'])); ?>
    </div>

    <!-- Main Content -->
    <?php if (!empty($blog['main_content'])) { ?>
        <div class="blog-main-content mt-1 p-1 border rounded bg-light">
            <p class="text-dark"> <?php echo formatContent(htmlspecialchars($blog['main_content'])); ?> </p>
        </div>
    <?php } ?>
</div>
</div>

<style>
    .blog-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 15px;
        /* Reduced space below the title */
    }

    .blog-author {
        font-style: italic;
        margin-bottom: 10px;
        /* Reduce space below author */
    }

    .blog-content,
    .blog-main-content {
        font-size: 1.1rem;
        line-height: 1.6;
        /* Reduce line height */
        margin-bottom: 10px;
        /* Reduce spacing between paragraphs */
    }

    .blog-heading {
        font-size: 1.6rem;
        font-weight: 600;
        color: #4E5352;
        margin-top: 15px;
        /* Reduce space above heading */
        margin-bottom: 5px;
        /* Reduce space below heading */
    }

    .blog-main-content p {
        margin-bottom: 8px;
        /* Reduce space between paragraphs inside main content */
    }

    .blog-content {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 5px;
        /* Reduce space below blog content */
    }

    .blog-main-content {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-top: 0px;
        /* Remove extra space at the start */
        padding: 8px;
        /* Reduce padding inside main content */
    }
</style>

<?php include "footer.php"; ?>