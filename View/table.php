<!DOCTYPE html>
<html>
<head>
    <title>Pagination Example</title>
    <style>
        /* Styles for the pagination links */
        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
        }

        /* Style for the active page link */
        .pagination .active {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <?php
    // Sample data (replace with your actual data retrieval logic)
    $data = range(1, 100); // Array of 100 items

    // Pagination variables
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemsPerPage = 10;
    $totalItems = count($data);
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Calculate the start and end indices for the current page
    $startIndex = ($currentPage - 1) * $itemsPerPage;
    $endIndex = $startIndex + $itemsPerPage - 1;
    if ($endIndex >= $totalItems) {
        $endIndex = $totalItems - 1;
    }

    // Display the items for the current page
    echo "<ul>";
    for ($i = $startIndex; $i <= $endIndex; $i++) {
        echo "<li>" . $data[$i] . "</li>";
    }
    echo "</ul>";
    ?>

    <!-- Pagination links -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo ($currentPage - 1); ?>">Previous</a>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <a href="?page=<?php echo $page; ?>" <?php if ($page == $currentPage) echo 'class="active"'; ?>><?php echo $page; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo ($currentPage + 1); ?>">Next</a>
        <?php endif; ?>
    </div>

    <script>
        // Scroll to top of page when changing pages
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                const href = link.getAttribute('href');
                window.history.pushState({}, '', href);
                loadPage(href);
            });
        });

        // Load page content via AJAX
        function loadPage(url) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(xhr.responseText, 'text/html');
                    const bodyContent = newDoc.querySelector('body').innerHTML;
                    document.body.innerHTML = bodyContent;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
