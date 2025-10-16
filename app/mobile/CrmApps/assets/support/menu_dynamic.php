<?php
// Get the current page filename
$currentFile = basename($_SERVER['PHP_SELF']);

// Define an array of menu items and their respective URLs
$menuItems = array(
    'Home' => 'index.php',
    'About' => 'about.php',
    'Services' => 'services.php',
    'Contact' => 'contact.php'
);
?>

<!-- HTML markup for the menu bar -->
<ul class="menu">
    <?php foreach ($menuItems as $menuItem => $url) { ?>
        <li class="<?php echo ($url == $currentFile) ? 'active' : ''; ?>">
            <a href="<?php echo $url; ?>"><?php echo $menuItem; ?></a>
        </li>
    <?php } ?>
</ul>
