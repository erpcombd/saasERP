<?




 session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once(SERVER_CORE.'core/init.php');

$cid = $_SESSION['proj_id'];

?>
<!DOCTYPE html>

<html lang="en" xml:lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Clouderp Demo Concern||ERP Software</title>
<link rel="icon" type="image/x-icon" href=<?=SERVER_ASSET?>"assets/images/login/erp_favicon-32x32.png"> 

        <script src=<?=SERVER_ASSET?>"home/files/jquery-1.js"></script>

        <link href="<?=SERVER_ASSET?>home/files/stylesheet.css" rel="stylesheet" type="text/css">
        <link href="<?=SERVER_ASSET?>home/files/css.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/normalize.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/common.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/website.css">
        <link rel="stylesheet" href="<?=SERVER_ASSET?>home/files/font-awesome.css">
		
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<?php 
 $allCss = find_all_field('project_info','','1');
?>

  <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #f3f4f6;
            --success-color: #22c55e;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s;
        }

        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu a {
            padding: 0.75rem 1.5rem;
            color: #4b5563;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }

        /* Main Content Styles */
        #content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }

        #content.expanded {
            margin-left: 0;
        }

        /* Header Styles */
        .main-header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        /* Module Card Styles */
        .module-card {
            height: 100%;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: white;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .module-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #ebf5ff;
            margin: 0 auto 1rem;
            transition: all 0.3s;
        }

        .module-card:hover .module-icon {
            background-color: #dbeafe;
        }

        .module-title {
            font-weight: 600;
            color: #1f2937;
            transition: all 0.3s;
        }

        .module-card:hover .module-title {
            color: var(--primary-color);
        }

        .module-description {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .status-badge {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            color: white;
        }

        .status-beta {
            background-color: var(--warning-color);
        }

        .status-upcoming {
            background-color: #8b5cf6;
        }

        /* App Card Styles */
        .app-card {
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: white;
        }

        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--success-color);
        }

        .app-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #ecfdf5;
            margin: 0 auto 1rem;
            transition: all 0.3s;
        }

        .app-card:hover .app-icon {
            background-color: #d1fae5;
        }

        .app-title {
            font-weight: 600;
            color: #1f2937;
            transition: all 0.3s;
        }

        .app-card:hover .app-title {
            color: var(--success-color);
        }

        .download-btn {
            background-color: var(--success-color);
            border-color: var(--success-color);
            width: 100%;
            font-weight: 500;
        }

        .download-btn:hover {
            background-color: #16a34a;
            border-color: #16a34a;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            #content.dimmed::after {
                content: "";
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 999;
            }
        }

        /* Search Box Styles */
        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
        }

        .search-box i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        /* Section Styles */
        .section-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }
    </style>
</head>
<body>
      <div class="wrapper d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex align-items-center">
                <img src="https://via.placeholder.com/120x40" alt="Clouderp Logo" class="img-fluid">
            </div>
            <div class="sidebar-menu">
                <a href="#" class="d-flex align-items-center">
                    <i class="bi bi-house-door me-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="d-flex align-items-center">
                    <i class="bi bi-grid me-3"></i>
                    <span>Modules</span>
                </a>
                <a href="#" class="d-flex align-items-center">
                    <i class="bi bi-phone me-3"></i>
                    <span>Apps</span>
                </a>
                <a href="#" class="d-flex align-items-center">
                    <i class="bi bi-gear me-3"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="d-flex align-items-center">
                    <i class="bi bi-question-circle me-3"></i>
                    <span>Help</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="content">
            <!-- Header -->
            <header class="main-header d-flex align-items-center justify-content-between">
                <button type="button" id="sidebarCollapse" class="btn btn-light d-lg-none">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-flex align-items-center ms-auto">
                    <div class="search-box me-3">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light rounded-circle me-2">
                            <i class="bi bi-bell"></i>
                        </button>
                        <button class="btn btn-light rounded-circle">
                            <i class="bi bi-person"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="container-fluid py-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Welcome to Clouderp</h1>
                    <p class="text-muted">Your complete business management solution</p>
                </div>

                <!-- Modules Section -->
                <section class="mb-5">
                    <h2 class="section-title">Choose Your Department</h2>
                    <div class="row g-4">
                        <!-- Accounts Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="module-icon">
                                        <i class="bi bi-wallet2 fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Accounts Module</h3>
                                    <p class="module-description mb-0">Accurate Financial Reporting, Better Business Control</p>
                                </div>
                            </a>
                        </div>

                        <!-- Purchase Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="module-icon">
                                        <i class="bi bi-cart fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Purchase Module</h3>
                                    <p class="module-description mb-0">Efficient Purchasing Management, Streamlined Supply Chain</p>
                                </div>
                            </a>
                        </div>

                        <!-- Sales Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="module-icon">
                                        <i class="bi bi-graph-up-arrow fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Sales Module</h3>
                                    <p class="module-description mb-0">Powerful Sales Management, Increased Revenue Growth</p>
                                </div>
                            </a>
                        </div>

                        <!-- Warehouse Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-building fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Warehouse Module</h3>
                                    <p class="module-description mb-0">Optimize Your Inventory, Streamline Your Warehouse Operations</p>
                                </div>
                            </a>
                        </div>

                        <!-- MIS Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-bar-chart fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">MIS Module</h3>
                                    <p class="module-description mb-0">Empowering Decision-Making With Real-Time Data Insights</p>
                                </div>
                            </a>
                        </div>

                        <!-- Production Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="module-icon">
                                        <i class="bi bi-gear fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Production Module</h3>
                                    <p class="module-description mb-0">Optimizing Production for Enhanced Quality and Performance</p>
                                </div>
                            </a>
                        </div>

                        <!-- Damage Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-exclamation-triangle fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Damage Module</h3>
                                    <p class="module-description mb-0">Optimize your inventory, streamline your warehouse operations</p>
                                </div>
                            </a>
                        </div>

                        <!-- Customer Portal -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-people fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Customer Portal</h3>
                                    <p class="module-description mb-0">Powerful sales management, increased revenue growth</p>
                                </div>
                            </a>
                        </div>

                        <!-- Vendor Portal -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-shop fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Vendor Portal</h3>
                                    <p class="module-description mb-0">Empowering Decision-Making With Real-Time Data Insights</p>
                                </div>
                            </a>
                        </div>

                        <!-- Fixed Asset -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-building fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Fixed Asset</h3>
                                    <p class="module-description mb-0">Manage and Track Your Fixed Assets, Optimize Their Value</p>
                                </div>
                            </a>
                        </div>

                        <!-- POS Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="status-badge status-beta">BETA</div>
                                    <div class="module-icon">
                                        <i class="bi bi-credit-card fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">POS Module</h3>
                                    <p class="module-description mb-0">Efficient Point-of-Sale Transactions, Seamless Customer Experience</p>
                                </div>
                            </a>
                        </div>

                        <!-- Export L/C Module -->
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="#" class="text-decoration-none">
                                <div class="module-card position-relative p-4 text-center">
                                    <div class="module-icon">
                                        <i class="bi bi-box-arrow-right fs-4 text-primary"></i>
                                    </div>
                                    <h3 class="module-title h5 mb-2">Export L/C Module</h3>
                                    <p class="module-description mb-0">Streamline Your Commercial Operations, Maximize Profitability</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Apps Section -->
                <section>
                    <h2 class="section-title">Download Our Apps</h2>
                    <div class="row g-4">
                        <!-- Secondary Sales Apps -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="app-card p-4 text-center">
                                <div class="app-icon">
                                    <i class="bi bi-phone fs-4 text-success"></i>
                                </div>
                                <h3 class="app-title h5 mb-3">Secondary Sales Apps</h3>
                                <button class="btn btn-success download-btn">Download</button>
                            </div>
                        </div>

                        <!-- Employee Portal Apps -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="app-card p-4 text-center">
                                <div class="app-icon">
                                    <i class="bi bi-person-badge fs-4 text-success"></i>
                                </div>
                                <h3 class="app-title h5 mb-3">Employee Portal Apps</h3>
                                <button class="btn btn-success download-btn">Download</button>
                            </div>
                        </div>

                        <!-- Vehicle Module Apps -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="app-card p-4 text-center">
                                <div class="app-icon">
                                    <i class="bi bi-truck fs-4 text-success"></i>
                                </div>
                                <h3 class="app-title h5 mb-3">Vehicle Module Apps</h3>
                                <button class="btn btn-success download-btn">Download</button>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="py-3 text-center border-top">
                <p class="text-muted mb-0">&copy; 2025 Clouderp. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('dimmed');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const windowWidth = window.innerWidth;
                if (windowWidth < 992 && 
                    !sidebar.contains(event.target) && 
                    !sidebarCollapse.contains(event.target) &&
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    content.classList.remove('dimmed');
                }
            });

            // Adjust layout on window resize
            window.addEventListener('resize', function() {
                const windowWidth = window.innerWidth;
                if (windowWidth >= 992) {
                    sidebar.classList.remove('active');
                    content.classList.remove('dimmed');
                }
            });
        });
    </script>
</body>
</html>