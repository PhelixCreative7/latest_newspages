<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle ?? 'College News Portal'; ?></title>

  <!-- Fixed CSS path -->
  <link rel="stylesheet" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/css/style.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Primary Navbar */
    .navbar {
      background: #52b3d9;
      color: white;
      padding: 12px 0;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .navbar .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo-section {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: white;
    }

    .college-logo {
      height: 40px;
      width: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }

    .college-name {
      font-size: 1.1rem;
      font-weight: 600;
      white-space: nowrap;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #ffcc00;
    }

    @media (max-width: 768px) {
      .college-name {
        font-size: 0.9rem;
      }

      .nav-links {
        gap: 15px;
      }

      .college-logo {
        height: 35px;
        width: 35px;
      }
    }

    /* Secondary Navbar */
    .secondary-navbar {
      background-color: #52b3d9;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .secondary-navbar .nav-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 10px 20px;
    }

    .menu-toggle {
      display: none;
      font-size: 24px;
      background: none;
      border: none;
      color: white;
      cursor: pointer;
    }

    .nav-items {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      width: 100%;
    }

    .nav-items a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      padding: 8px 12px;
      transition: background-color 0.3s, color 0.3s;
    }


    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }

      .nav-items {
        display: none;
        flex-direction: column;
        align-items: center;
        width: 100%;
        margin-top: 10px;
      }

      .nav-items.show {
        display: flex;
      }

      .nav-items a {
        text-align: center;
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Primary Navbar -->
  <nav class="navbar">
    <div class="container">
      <a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/index.php" class="logo-section">
        <img src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/Assets/sk_college_logo.png" alt="College Logo" class="college-logo">
        <span class="college-name">SK College of Science and Commerce</span>
      </a>
      <ul class="nav-links">
        <li><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/dashboard.php">Dashboard</a></li>
          <li><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/login.php">Admin Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- Secondary Navbar -->
  

  <script>
    function toggleMenu() {
      const nav = document.getElementById('secondaryNav');
      nav.classList.toggle('show');
    }

    // Highlight active link
    const links = document.querySelectorAll('.nav-items a');
    links.forEach(link => {
      link.addEventListener('click', () => {
        links.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
      });
    });
  </script>

</body>
</html>
