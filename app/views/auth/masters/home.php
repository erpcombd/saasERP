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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<?php 
 $allCss = find_all_field('project_info','','1');
?>

<style>
    /* Modern Modules Grid Styles */
    .modules-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 40px;
      margin-bottom: 60px;
    }
    
    .module-card {
      background: var(--card-bg);
      border-radius: var(--border-radius-lg);
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      display: flex;
      flex-direction: column;
      height: 100%;
      position: relative;
      text-decoration: none;
      color: inherit;
      border: 1px solid rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    
    .module-card:hover {
      transform: translateY(-12px);
      box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15);
    }
    
    .module-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
      z-index: 1;
      opacity: 0;
      transition: opacity 0.4s;
      border-radius: var(--border-radius-lg);
    }
    
    .module-card:hover::before {
      opacity: 1;
    }
    
    .module-header {
      padding: 25px;
      display: flex;
      align-items: center;
      border-bottom: 1px solid rgba(0, 0, 0, 0.03);
      position: relative;
      overflow: hidden;
      background: white;
      transition: all 0.4s;
    }
    
    .module-card:hover .module-header {
      background: var(--gradient-primary);
    }
    
    .module-header::before {
      content: '';
      position: absolute;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 50%);
      top: -50%;
      left: -50%;
      transition: all 0.8s;
      opacity: 0;
      z-index: 0;
    }
    
    .module-card:hover .module-header::before {
      opacity: 1;
      transform: scale(1.2);
    }
    
    .module-icon {
      width: 64px;
      height: 64px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: white;
      border-radius: 16px;
      margin-right: 18px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
      padding: 12px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      z-index: 2;
    }
    
    .module-card:hover .module-icon {
      transform: scale(1.15) rotate(5deg);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    
    .module-icon img {
      max-width: 100%;
      max-height: 100%;
      transition: transform 0.4s;
      filter: brightness(1);
    }
    
    .module-card:hover .module-icon img {
      transform: scale(1.1);
      filter: brightness(1.05);
    }
    
    .module-title {
      font-weight: 600;
      font-size: 1.25rem;
      color: var(--dark-color);
      transition: color 0.4s;
      position: relative;
      z-index: 2;
    }
    
    .module-card:hover .module-title {
      color: white;
    }
    
    .module-body {
      padding: 20px 25px;
      flex-grow: 1;
      background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
      display: flex;
      flex-direction: column;
    }
    
    .module-description {
      color: #555;
      font-size: 0.95rem;
      line-height: 1.7;
      margin-bottom: 20px;
      flex-grow: 1;
    }
    
    .module-footer {
      padding: 20px 25px;
      text-align: right;
      border-top: 1px solid rgba(0, 0, 0, 0.03);
      background: rgba(255, 255, 255, 0.8);
      transition: all 0.4s;
    }
    
    .module-card:hover .module-footer {
      background: rgba(255, 255, 255, 0.95);
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 10px 24px;
      border-radius: 30px;
      background: var(--primary-color);
      color: white;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: none;
      cursor: pointer;
      box-shadow: 0 6px 15px rgba(67, 97, 238, 0.2);
      position: relative;
      overflow: hidden;
    }
    
    .btn::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: -100%;
      background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
      transition: all 0.6s;
    }
    
    .module-card:hover .btn::after {
      left: 100%;
    }
    
    .btn:hover {
      background: var(--primary-dark);
      box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
      transform: translateY(-3px) scale(1.05);
    }
    
    .btn-icon {
      margin-right: 8px;
      font-size: 1rem;
      transition: transform 0.4s;
    }
    
    .btn:hover .btn-icon {
      transform: translateX(3px);
    }
    
    .badge {
      position: absolute;
      top: 15px;
      right: 15px;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      color: white;
      box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
      z-index: 3;
      backdrop-filter: blur(5px);
      transition: all 0.4s;
    }
    
    .module-card:hover .badge {
      transform: translateY(-3px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .badge-beta {
      background: var(--gradient-warning);
    }
    
    .badge-new {
      background: var(--gradient-success);
    }
    
    .badge-upcoming {
      background: var(--gradient-secondary);
    }
    
    /* Category tags */
    .module-category {
      position: absolute;
      bottom: 15px;
      left: 25px;
      font-size: 0.8rem;
      color: #777;
      display: flex;
      align-items: center;
    }
    
    .module-category i {
      margin-right: 5px;
      color: var(--primary-color);
    }
    
    /* Module card variants */
    .module-card:nth-child(4n+1) .module-icon {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    
    .module-card:nth-child(4n+2) .module-icon {
      background: linear-gradient(135deg, #f8f9fa, #e9f7ef);
    }
    
    .module-card:nth-child(4n+3) .module-icon {
      background: linear-gradient(135deg, #f8f9fa, #edf6ff);
    }
    
    .module-card:nth-child(4n+4) .module-icon {
      background: linear-gradient(135deg, #f8f9fa, #fdf5e6);
    }
    
    .module-card:nth-child(4n+1):hover .module-header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    }
    
    .module-card:nth-child(4n+2):hover .module-header {
      background: linear-gradient(135deg, #2ec4b6, var(--success-color));
    }
    
    .module-card:nth-child(4n+3):hover .module-header {
      background: linear-gradient(135deg, #4361ee, #4cc9f0);
    }
    
    .module-card:nth-child(4n+4):hover .module-header {
      background: linear-gradient(135deg, #ff9e00, #ff4d00);
    }
    
    /* Animation for modules */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .module-card {
      animation: fadeInUp 0.6s ease-out forwards;
      opacity: 0;
    }
    
    .module-card:nth-child(1) { animation-delay: 0.1s; }
    .module-card:nth-child(2) { animation-delay: 0.2s; }
    .module-card:nth-child(3) { animation-delay: 0.3s; }
    .module-card:nth-child(4) { animation-delay: 0.4s; }
    .module-card:nth-child(5) { animation-delay: 0.5s; }
    .module-card:nth-child(6) { animation-delay: 0.6s; }
    .module-card:nth-child(7) { animation-delay: 0.7s; }
    .module-card:nth-child(8) { animation-delay: 0.8s; }
    
    /* Module counter for feature display */
    .module-counter {
      position: absolute;
      top: 25px;
      left: 25px;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: rgba(67, 97, 238, 0.1);
      color: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 700;
      transition: all 0.4s;
      opacity: 0.7;
    }
    
    .module-card:hover .module-counter {
      background: white;
      opacity: 1;
      transform: scale(1.1);
    }
    
    /* Page title enhancement */
    .page-title {
      text-align: center;
      margin-bottom: 60px;
      position: relative;
      animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .page-title h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--dark-color);
      position: relative;
      display: inline-block;
      padding: 0 20px;
    }
    
    .page-title h1::before {
      content: '';
      position: absolute;
      width: 60%;
      height: 5px;
      background: var(--gradient-primary);
      bottom: -15px;
      left: 20%;
      border-radius: 10px;
    }
    
    .page-title::after {
      content: '';
      position: absolute;
      width: 100px;
      height: 100px;
      background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0) 70%);
      border-radius: 50%;
      top: -20px;
      left: calc(50% - 50px);
      z-index: -1;
    }
    
    .page-subtitle {
      text-align: center;
      max-width: 700px;
      margin: -30px auto 50px;
      color: #666;
      font-size: 1.1rem;
      line-height: 1.6;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 1200px) {
      .modules-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 992px) {
      .modules-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .page-title h1 {
        font-size: 2.2rem;
      }
      
      .page-subtitle {
        font-size: 1rem;
      }
    }
    
    @media (max-width: 768px) {
      .modules-grid {
        gap: 20px;
      }
      
      .module-header {
        padding: 20px;
      }
      
      .module-icon {
        width: 54px;
        height: 54px;
      }
      
      .module-title {
        font-size: 1.15rem;
      }
      
      .module-body,
      .module-footer {
        padding: 15px 20px;
      }
      
      .page-title h1 {
        font-size: 1.8rem;
      }
    }
    
    @media (max-width: 576px) {
      .modules-grid {
        grid-template-columns: 1fr;
      }
      
      .page-title h1 {
        font-size: 1.6rem;
      }
      
      .page-subtitle {
        font-size: 0.9rem;
        margin-bottom: 30px;
      }
    }
</style>

<style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3f37c9;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --success-color: #0cce6b;
            --warning-color: #ff9e00;
            --danger-color: #e5383b;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --background: #f0f2f5;
            --card-bg: rgba(255, 255, 255, 0.8);
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            --transition-fast: 0.2s;
            --transition-normal: 0.3s;
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 20px;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            --gradient-secondary: linear-gradient(135deg, var(--secondary-color), #f72585);
            --gradient-success: linear-gradient(135deg, #2ec4b6, var(--success-color));
            --gradient-warning: linear-gradient(135deg, #ff9e00, #ff4d00);
            --gradient-accent: linear-gradient(135deg, #4cc9f0, #06d6a0);
            --gradient-bg: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: var(--background);
            color: var(--dark-color);
            line-height: 1.6;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
/*         background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%234361ee" opacity="0.03" width="50" height="50" x="0" y="0"/><rect fill="%234361ee" opacity="0.03" width="50" height="50" x="50" y="50"/></svg>');*/
			background: url('<?=SERVER_ASSET?>/images/login/bg_image.svg');
			background-repeat: repeat;
            z-index: -1;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius-md);
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .logo img {
            max-height: 60px;
            transition: transform var(--transition-normal);
        }
        
        .logo img:hover {
            transform: scale(1.05);
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 100px;
            height: 40px;
           /* border-radius: 50%;*/
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: transform var(--transition-fast);
        }

        .user-avatar:hover {
            transform: scale(1.1);
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }
        
        .page-title h1 {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
            padding: 0 15px;
        }
        
        .page-title h1::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
            bottom: -10px;
            left: 0;
            border-radius: 10px;
        }

        .search-container {
            max-width: 500px;
            margin: 0 auto 40px;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 15px 20px;
            padding-left: 45px;
            border-radius: 30px;
            border: none;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            font-size: 1rem;
            transition: all var(--transition-normal);
        }

        .search-box:focus {
            box-shadow: 0 5px 25px rgba(67, 97, 238, 0.2);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .module-card {
            background: var(--card-bg);
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all var(--transition-normal);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            text-decoration: none;
            color: inherit;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        
        .module-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .module-card:hover .module-header {
            background: var(--gradient-primary);
        }

        .module-card:hover .module-icon {
            background: white;
            transform: scale(1.1) rotate(5deg);
        }

        .module-card:hover .module-title {
            color: white;
        }
        
        .module-header {
            padding: 10px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all var(--transition-normal);
        }
        
        .module-icon {
            width: 54px;
            height: 54px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.7);
            border-radius: var(--border-radius-sm);
            margin-right: 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            padding: 10px;
            transition: all var(--transition-normal);
        }
        
        .module-icon img {
            max-width: 100%;
            max-height: 100%;
            transition: transform var(--transition-normal);
        }
        
        .module-title {
            font-weight: 600;
            font-size: 1.15rem;
            color: var(--dark-color);
            transition: color var(--transition-normal);
        }
        
        .module-body {
            padding: 15px 20px;
            flex-grow: 1;
        }
        
        .module-description {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .module-footer {
            padding: 15px 20px;
            text-align: right;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .btn {
            display: inline-block;
            padding: 9px 22px;
            border-radius: 30px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all var(--transition-normal);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }
        
        .btn:hover {
            background: var(--primary-dark);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            transform: translateY(-2px);
        }

        .btn-icon {
            margin-right: 5px;
        }
        
        .badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
            z-index: 1;
        }
        
        .badge-beta {
            background: var(--gradient-warning);
        }
        
        .badge-new {
            background: var(--gradient-success);
        }
        
        .badge-upcoming {
            background: var(--gradient-secondary);
        }
        
        .section-title {
            margin: 60px 0 30px;
            font-size: 1.8rem;
            color: var(--dark-color);
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: '';
            flex: 0 0 5px;
            height: 30px;
            background: var(--gradient-primary);
            border-radius: 3px;
            margin-right: 15px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0, 0, 0, 0.1);
            margin-left: 15px;
        }
        
        .download-section {
            background: var(--gradient-bg);
            border-radius: var(--border-radius-lg);
            padding: 40px;
            margin-top: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .download-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
/*            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><circle fill="%234361ee" opacity="0.05" cx="25" cy="25" r="10"/></svg>');*/
			background: url('<?=SERVER_ASSET?>/images/login/bg_image.svg');
			 background-repeat: repeat;
            z-index: 0;
        }
        
        .download-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            position: relative;
            z-index: 1;
        }
        
        .download-card {
            background: white;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all var(--transition-normal);
            position: relative;
        }
        
        .download-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }
        
        .download-header {
            padding: 25px 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.7);
            position: relative;
            z-index: 1;
        }

        .download-card:nth-child(1) .download-header {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(73, 149, 239, 0.1));
        }

        .download-card:nth-child(2) .download-header {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(12, 206, 107, 0.1));
        }

        .download-card:nth-child(3) .download-header {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.9), rgba(255, 77, 0, 0.1));
        }
        
        .download-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 2px;
            background: white;
            position: relative;
        }

        .download-icon::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity var(--transition-normal);
            z-index: -1;
        }

        .download-card:hover .download-icon::after {
            opacity: 0.1;
        }
        
        .download-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: calc(var(--border-radius-md) - 2px);
        }
        
        .download-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark-color);
            font-size: 1.1rem;
        }
        
        .download-description {
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }
        
        .download-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: var(--success-color);
            color: white;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .download-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s;
            z-index: -1;
        }
        
        .download-btn:hover::before {
            left: 100%;
        }
        
        .download-btn:hover {
            background: #0ab35e;
        }

        .download-btn i {
            margin-right: 8px;
        }
        
        .footer {
            margin-top: 70px;
            text-align: center;
            padding: 25px 0;
            color: #666;
            font-size: 0.9rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .footer-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .footer-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Stats & Quick Access */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius-md);
            padding: 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            transition: all var(--transition-normal);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: white;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: var(--gradient-primary);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: var(--gradient-secondary);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: var(--gradient-success);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: var(--gradient-warning);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            line-height: 1.2;
        }

        .stat-label {
            color: #777;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Quick Links */
        .quick-links {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .quick-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background: white;
            border-radius: 30px;
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-normal);
        }

        .quick-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            color: var(--primary-color);
        }

        .quick-link i {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 1200px) {
            .modules-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .modules-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .download-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .modules-grid, 
            .download-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .page-title h1 {
                font-size: 1.8rem;
            }
            
            header {
                flex-direction: column;
                text-align: center;
                padding: 15px;
                margin-bottom: 30px;
            }
            
            .logo {
                margin-bottom: 15px;
            }
            
            .section-title {
                font-size: 1.5rem;
                margin: 40px 0 25px;
            }
            
            .module-card, 
            .download-card {
                margin-bottom: 5px;
            }
            
            .module-header {
                padding: 18px;
            }
            
            .module-icon {
                width: 45px;
                height: 45px;
            }
            
            .module-title {
                font-size: 1rem;
            }
            
            .module-body, 
            .module-footer {
                padding: 12px 18px;
            }
            
            .download-section {
                padding: 25px;
                margin-top: 35px;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .quick-links {
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .page-title h1 {
                font-size: 1.5rem;
            }
            
            .module-icon {
                width: 40px;
                height: 40px;
            }
            
            .btn {
                padding: 8px 18px;
                font-size: 0.85rem;
            }
            
            .download-btn {
                padding: 10px;
                font-size: 0.85rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.3rem;
            }

            .stat-value {
                font-size: 1.3rem;
            }
        }
    </style>
	
	 <style>
        /* Modern Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
           /* background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);*/
		   background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #dee2e6;
            position: relative;
            height: 80px;
        }
        
        /* Logo Styles */
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo-new-cid-class {
            max-height: 50px;
            transition: transform 0.3s ease;
        }
        
        .logo-new-cid-class:hover {
            transform: scale(1.05);
        }
        
        /* Header Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        /* User Block Styling */
        .userblock {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 50px;
            padding: 0.5rem 1rem 0.5rem 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .userblock:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
			background-color: #902cff;
        }
        
		 .userblock:hover .username{
			color: white; 
		 }
		 .userblock:hover .company_name{
		 	color: white; 
		 }
        /* Circle Avatar */
        .circle {
            border-radius: 50%;
            overflow: hidden;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #e9ecef;
            background-color: #f8f9fa;
            margin-right: 12px;
        }
        
        .userimg {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* User Details */
        .userdetail {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .username {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .company_name {
            font-size: 12px;
            color: #6c757d;
        }
        
        /* Sign Out Button */
        .sing-out {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: #dc3545;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sing-out:hover {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            transform: rotate(10deg);
        }
    </style>
</head>
<body style="zoom: 95% !important">
    <div class="container">
        <header class="header">
        <div class="logo">
            <?php
            $cloud_logo = SERVER_ASSET."images/logo/clouderplogo.png";
            $project_logo = SERVER_UPLOAD."logo/".$cid.".png";
            if(is_file($project_logo)) {
                $show_logo = $project_logo;
            } else {
                $show_logo = $cloud_logo;
            }
            ?>
            <img src="<?=$show_logo?>" alt="Company Logo" class="logo-new-cid-class">
        </div>
        
        <div class="header-right">
            <div class="userblock">
                <div class="circle">
                    <?php 
                    $find = find_a_field('user_activity_management','user_pic','user_id="'.$_SESSION['user']['id'].'"');
                    
                    if($find != "") { ?>
                        <img src="../../../../public/assets/images/user.png" class="userimg" alt="User"/>
                    <?php } else { ?>
                        <img src="../../../../public/assets/images/user.png" class="userimg" alt="User"/>
                    <?php } ?>
                </div>
                
                <div class="userdetail">
                    <p class="username">
                        <?php
                        $user_info = find_all_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);
                        echo $user_info->fname;
                        ?>
                    </p>
                    <p class="company_name">
                        <?=$user_info->designation;?>
                    </p>
                </div>
            </div>
            
            <a href="../../../views/auth/masters/logout.php" class="sing-out" data-toggle="tooltip" data-placement="bottom" data-original-title="Signout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
</header>

<div class="modules-grid">
    <?php
    $u_id=$_SESSION['user']['id'];
    $sql22="select a.module_name,a.module_link,a.module_icon_img,a.module_description,a.id,a.dev_status,b.user_id,b.module_id,b.status from user_module_manage a,user_module_define b where b.module_id=a.id and a.status='Yes' and b.user_id='".$u_id."' and b.status='enable' ";
    $query22=db_query($sql22);
    $counter = 1;
    while($data22=mysqli_fetch_object($query22)){
    ?>
    <a href="<?=SERVER_VIEW?><?=$data22->module_link?>?mod_id=<?=$data22->id?>" class="module-card">
        <?php if($data22->dev_status == "BETA"){ ?>
            <span class="badge badge-beta"><?=$data22->dev_status;?></span>
        <?php } elseif($data22->dev_status == "UPCOMING"){ ?>
            <span class="badge badge-upcoming">GAMA </span>
        <?php } ?>
        <div class="module-counter"><?=sprintf("%02d", $counter++)?></div>
        
        <div class="module-header">
            <div class="module-icon">
                <img src="<?=SERVER_ASSET?>home/<?=$data22->module_icon_img?>" alt="<?=$data22->module_name?>">
            </div>
            <div class="module-title"><?=$data22->module_name?></div>
			
        </div>
        
        <?php /*?><div class="module-body">
            <div class="module-description"><?=$data22->module_description?></div>
        </div><?php */?>
        
        <?php /*?><div class="module-footer">
            <div class="module-category">
                <i class="fas fa-folder"></i> Department
            </div>
            <span class="btn"><i class="fas fa-arrow-right btn-icon"></i> Open</span>
        </div><?php */?>
    </a>
    <?php } ?>
</div>
        
        <?php if($cid == 'robi' || $cid == 'dev'){ ?>
        <div class="section-title">Download Our Apps</div>
        <div class="download-section">
            <div class="download-grid">
                <div class="download-card">
                    <div class="download-header">
                        <div class="download-icon">
                            <img src="<?=SERVER_ASSET?>home/SecondarySales.png" alt="Secondary Sales App">
                        </div>
                        <div class="download-title">Secondary Sales App</div>
                        <div class="download-description">Track and manage your secondary sales data anytime, anywhere with our powerful mobile app.</div>
                    </div>
                    <a href="<?=SERVER_ASSET?>all_module_apk/SecondarySales.apk">
                        <button class="download-btn">
                            <i class="fas fa-download"></i> Download APK
                        </button>
                    </a>
                </div>
                
                <div class="download-card">
                    <div class="download-header">
                        <div class="download-icon">
                            <img src="<?=SERVER_ASSET?>home/user_portal.png" alt="Employee Portal App">
                        </div>
                        <div class="download-title">Employee Portal App</div>
                        <div class="download-description">Access your employee information, requests, and company resources on the go.</div>
                    </div>
                    <a href="<?=SERVER_ASSET?>all_module_apk/EmployeePortal.apk">
                        <button class="download-btn">
                            <i class="fas fa-download"></i> Download APK
                        </button>
                    </a>
                </div>
                
                <div class="download-card">
                    <div class="download-header">
                        <div class="download-icon">
                            <img src="<?=SERVER_ASSET?>home/vehicle.png" alt="Vehicle Module App">
                        </div>
                        <div class="download-title">Vehicle Module App</div>
                        <div class="download-description">Manage your fleet logistics, maintenance schedules, and track vehicle status efficiently.</div>
                    </div>
                    <a href="<?=SERVER_ASSET?>all_module_apk/EmployeePortal.apk">
                        <button class="download-btn">
                            <i class="fas fa-download"></i> Download APK
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
        
       <?php /*?> <div class="footer">
            &copy; <?php echo date('Y'); ?> <a href="https://erp.com.bd/" target="_blank" style="text-decoration:none;">CloudERP</a>. All rights reserved.
        </div><?php */?>
    </div>

</body>

</html>