<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Details</title>
<link rel="stylesheet" href="styles.css">
<script src="script.js" defer></script> 
</head>
<body>
<div class="container">
    <header>
        <h1>Discover Projects</h1>
    </header>
    <main>
        <section class="project-info">
            <h2>Project Details</h2>
            <p id="project-description">Loading project details...</p>
        </section>
        <section class="actions">
            <button id="view-more-btn">View More</button>
            <button id="contact-btn">Contact Project Owner</button>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Discover Projects</p>
    </footer>
</div>      
<script src="../APIs/CurrentProjectsApi.js"></script>
</body>
</html>
