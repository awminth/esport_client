<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HITUPMM</title>
    <link rel="apple-touch-icon" href="<?php echo roothtml.'lib/imb/app-logo2.png'?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo roothtml.'lib/img/app-logo2.png'?>">
    <link rel="stylesheet" href="<?php echo roothtml.'lib/css/all.min.css'?>">
    <!-- Include Owl Carousel CSS & JS (CDN) -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/css/owl.carousel.min.css'?>" />
    <link rel="stylesheet" href="<?php echo roothtml.'lib/css/owl.theme.default.min.css'?>" />
    <!-- Toast -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/toast/toast.css'?>">
    <script src="<?php echo roothtml.'lib/toast/toast.js'?>"></script>
    <!-- custom modal -->
    <link href="<?= roothtml.'lib/modal/my-modal.css' ?>" rel="stylesheet" />
    <script src="<?= roothtml.'lib/modal/my-modal.js' ?>"></script>

    <style>
    /* Poppins Regular (400) */
    @font-face {
        font-family: 'Poppins';
        src: url('../lib/fonts/Poppins-Regular.ttf') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    /* Poppins Bold (600) */
    @font-face {
        font-family: 'Poppins';
        src: url('../lib/fonts/Poppins-Bold.ttf') format('truetype');
        font-weight: 600;
        font-style: normal;
    }

    :root {
        --primary-font: 'Poppins', sans-serif;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--primary-font);
        background-color: rgb(27, 50, 74);
    }

    .my-i {
        padding: 5px 8px;
        width: 100%;
        height: 300px;
    }

    .my-h {
        color: white;
        line-height: 1.5;
        padding: 10px 8px;
    }

    .my-p {
        color: white;
        line-height: 1.5;
        padding: 10px 8px;
        justify-content: space-between;
    }

    nav {
        background-color: #1e1e2f;
        color: #fff;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    /* ============= nav bar style ============== */
    nav-logo {
        height: 30px;
    }

    .nav-logo-img {
        height: 100%;
        width: auto;
        max-width: 150px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .nav-logo-img:hover {
        transform: scale(1.05);
    }

    .mobile-header-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .reload-icon {
        color: white;
        font-size: 1.6rem;
        cursor: pointer;
        transition: transform 0.3s ease;
        display: none;
    }

    .reload-icon:hover {
        color: #00d4ff;
        transform: rotate(180deg);
    }

    .menu-toggle {
        width: 30px;
        height: 24px;
        display: none;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        z-index: 300;
    }

    .menu-toggle span {
        height: 3px;
        width: 100%;
        background-color: white;
        border-radius: 2px;
        transition: 0.4s;
    }

    .menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    /* ============= nav bar logo style ============== */

    /* ============= start nav link style ============== */
    .nav-links {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .nav-links>li {
        list-style: none;
        position: relative;
    }

    .nav-links a {
        padding: 10px 16px;
        position: relative;
        color: white;
        text-decoration: none;
        font-weight: 500;
        /* padding: 5px 0; */
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .nav-links a::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 2px solid transparent;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .nav-links a:hover::before {
        border-color: #00d4ff;
        box-shadow: 0 0 10px #00d4ff;
    }

    .nav-links a:hover i {
        color: #00d4ff;
        transform: scale(1.1);
    }

    .nav-links li.desk-profile {
        margin-left: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.2rem;
        padding: 0.3rem 0;
    }

    .nav-links li.desk-profile .desk-username {
        color: red;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .nav-links li.desk-profile .desk-useramount {
        color: #00ffcc;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.1rem 0.2rem;
    }

    .nav-links li.desk-profile .desk-useramount i {
        font-size: 0.8rem;
    }

    /* ============= end nav link style ============== */

    /* ============= start nav link active style ============== */
    .nav-links li.active>a {
        color: #00d4ff;
        font-weight: 600;
        position: relative;
        padding-left: 12px;
        animation: glow-pulse 2s infinite;
    }

    .nav-links li.active>a::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -5px;
        right: -5px;
        bottom: -3px;
        border: 2px solid #00d4ff;
        border-radius: 4px;
        animation: glow 1.5s ease-in-out infinite alternate;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-links li.active>a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 2px;
        background: #00d4ff;
        box-shadow: 0 0 5px #00d4ff, 0 0 10px #00d4ff;
        transition: all 0.3s ease;
    }

    /* Glow Animation */
    @keyframes glow {
        from {
            opacity: 0.4;
            box-shadow: 0 0 5px #00d4ff, 0 0 10px #00d4ff;
        }

        to {
            opacity: 1;
            box-shadow: 0 0 10px #00d4ff, 0 0 20px #00d4ff;
        }
    }

    /* Pulse Animation for Text */
    @keyframes glow-pulse {
        0% {
            text-shadow: 0 0 5px rgba(0, 212, 255, 0.3);
        }

        50% {
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        100% {
            text-shadow: 0 0 5px rgba(0, 212, 255, 0.3);
        }
    }

    .nav-links a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 2px;
        background: #00d4ff;
        transition: 0.3s ease;
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    /* ============= end nav link active style ============== */

    /* ============= nav bar sub dropdown style ============== */
    .dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #2b2b45;
        min-width: 200px;
        display: none;
        flex-direction: column;
        border-radius: 4px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: 0.3s ease;
    }

    .nav-links>li:hover .dropdown {
        display: flex;
    }

    .dropdown a {
        padding: 0.8rem 1rem;
        color: white;
        font-size: 0.95rem;
    }

    .dropdown a:hover {
        background-color: #3d3d5c;
        color: #00d4ff;
        padding-left: 1.5rem;
    }

    .dropdown a i {
        min-width: 20px;
    }

    /* ============= end nav bar sub dropdown style ============== */

    /* ============= start mobile side style ============== */
    .side-nav {
        position: fixed;
        top: 0;
        left: -260px;
        width: 260px;
        height: 100%;
        background-color: #1e1e2f;
        padding-top: 60px;
        transition: all 0.3s ease;
        z-index: 200;
        overflow-y: auto;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
    }

    .side-nav .user-profile {
        background-color: transparent;
        padding: 1rem 2rem;
        margin-bottom: 20px;
        border-bottom: 1px solid red;
    }

    .side-nav .user-name {
        color: rgba(240, 146, 6, 0.94);
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
    }

    .side-nav .user-balance {
        color: rgba(6, 228, 240, 0.94);
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .side-nav .user-amount {
        color: white;
        font-weight: bold;
        font-size: 1.0rem;
        padding-left: 8px;
    }

    .side-nav ul {
        list-style: none;
        padding: 0;
    }

    .side-nav a {
        padding: 1rem 2rem;
        text-decoration: none;
        color: white;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        position: relative;
        border-left: 3px solid transparent;
    }

    /* Active State with Glow Effect */
    .side-nav li.active>a {
        color: #00d4ff;
        background-color: #292948;
        font-weight: 600;
        padding-left: 2.5rem;
        border-left: 3px solid #00d4ff;
        box-shadow: inset 4px 0 10px rgba(0, 212, 255, 0.3);
    }

    .side-nav li.active>a::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 3px;
        height: 100%;
        background: #00d4ff;
        box-shadow: 0 0 10px #00d4ff;
    }

    /* Hover Effect */
    .side-nav a:hover {
        background-color: #292948;
        padding-left: 2.5rem;
        color: #00d4ff;
        transform: translateX(5px);
    }

    /* Submenu Styles */
    .side-nav .submenu {
        display: none;
        flex-direction: column;
        padding-left: 1.5rem;
        background-color: rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .side-nav .submenu a {
        padding: 0.7rem 2rem;
        font-size: 1rem;
        color: #b8b8d2;
    }

    .side-nav .submenu a:hover {
        color: #00d4ff;
        background-color: rgba(41, 41, 72, 0.7);
    }

    /* Submenu Indicator */
    .side-nav .has-sub>a::after {
        content: "▾";
        margin-left: auto;
        transition: transform 0.3s;
        color: #b8b8d2;
    }

    .side-nav .has-sub.open>a::after {
        transform: rotate(180deg);
        color: #00d4ff;
    }

    .side-nav .has-sub.open .submenu {
        display: flex;
        animation: slideDown 0.3s ease-out;
    }

    /* Animations */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Toggle Button Effect */
    .menu-toggle {
        transition: transform 0.3s ease;
    }

    .menu-toggle.active {
        transform: rotate(90deg);
    }

    .overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 150;
    }

    /* ============= end mobile side style ============== */

    /* Carousel Styles */
    .carousel-container {
        padding: 10px 0;
        /* max-width: 1200px; */
        margin: 0 auto;
    }

    .carousel-title {
        font-family: var(--primary-font);
        text-align: center;
        margin-bottom: 10px;
        color: rgb(234, 182, 9);
    }

    .owl-carousel .item {
        background: rgb(27, 50, 74);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
        margin: 10px;
        /* text-align: center; */
        transition: transform 0.3s ease;
        height: 370px;
    }

    .owl-carousel .item:hover {
        transform: translateY(-5px);
    }

    .carousel-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .carousel-item-title {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: rgb(242, 242, 247);
    }

    .carousel-item-desc {
        color: rgb(204, 204, 209);
        font-size: 0.9rem;
    }

    .carousel-item-desc a {
        color: rgb(234, 176, 30);
        font-size: 0.9rem;
        text-decoration: none;
        padding-left: 5px;
    }

    .carousel-item-span {
        color: rgb(244, 241, 93);
        font-size: 0.9rem;
        padding-top: 15px;
    }

    /* .owl-nav {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .owl-nav button {
        background: #1e1e2f !important;
        color: #fff !important;
        width: 40px;
        height: 40px;
        border-radius: 50% !important;
        margin: 0 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem !important;
    }

    .owl-nav button:hover {
        background: #00d4ff !important;
    } */

    /* .owl-dots {
        text-align: center;
        margin-top: 20px;
    }

    .owl-dots button.owl-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ccc !important;
        margin: 0 5px;
    }

    .owl-dots button.owl-dot.active {
        background: #00d4ff !important;
    } */
    /* =========== start Scrolling Text ============= */
    .scrolling-text-container {
        width: 100%;
        height: 40px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 3px solid #00d4ff;
        background: linear-gradient(135deg, rgb(48, 73, 101) 0%, rgb(149, 159, 173) 100%);
    }

    .scrolling-text {
        position: absolute;
        white-space: nowrap;
        animation: scrollText 10s linear infinite;
        margin: 0;
        font-size: 18px;
        color: rgb(22, 1, 92);
    }

    @keyframes scrollText {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* =========== end Scrolling Text ============= */

    /* ======== start Page Header ======== */
    .page-header {
        position: relative;
        text-align: center;
        padding: 8px 15px 8px;
        /* background-color: rgb(27, 50, 74); */
        background: linear-gradient(135deg, rgb(45, 70, 98) 0%, rgb(127, 146, 172) 100%);
    }

    .page-header h2 {
        margin: 0;
        font-size: 1.8rem;
        color: white;
    }

    .back-icon {
        position: absolute;
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .back-icon:hover {
        color: rgba(0, 213, 255, 0.64);
        transform: translateY(-50%) scale(1.1);
    }

    /* ======== end Page Header ======== */

    /* ========== login container style ============ */
    .login-container {
        font-family: var(--primary-font);
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        background: linear-gradient(135deg, rgb(48, 73, 101) 0%, rgb(149, 159, 173) 100%);
        padding: 20px;
    }

    /* Login Card */
    .login-card {
        background-color: rgb(27, 50, 74);
        border-radius: 20px;
        padding: 40px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 15px 35px rgba(50, 45, 1, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        font-family: var(--primary-font);
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(50, 45, 1, 0.2);
    }

    /* Logo Container */
    .logo-container {
        margin-bottom: 30px;
        text-align: center;
    }

    /* login profile style */
    .profile-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: rgb(36, 82, 131);
        display: inline-flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid rgb(128, 62, 214);
    }

    .profile-circle img {
        width: 90%;
        height: auto;
        object-fit: contain;
    }

    /* Form Elements */
    .login-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        .login-card {
            padding: 20px 12px;
        }

        .profile-circle {
            width: 100px;
            height: 100px;
        }
    }

    .form-controlone {
        border-radius: 20px;
    }

    .form-iconone {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #0f3e53;
    }

    /* login footer style */
    .login-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.9rem;
        color: white;
    }

    .login-footer a {
        color: red;
        text-decoration: none;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* ============= end login container ============= */

    /* ============= start glow button style ================= */
    .btn-glow {
        padding: 12px 24px;
        border: none;
        border-radius: 30px;
        background: linear-gradient(135deg, #00d4ff 0%, #0077ff 100%);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
    }

    .btn-glow:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.6);
    }

    .btn-glow:active {
        transform: translateY(1px);
    }

    .btn-glow::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0077ff 0%, #00d4ff 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .btn-glow:hover::before {
        opacity: 1;
    }

    /* =========== end button style =========== */

    /* ========== start liquid button ============ */
    .btn-liquid {
        width: 100%;
        margin-top: 10px;
        padding: 12px 24px;
        border: 2px solid rgba(0, 213, 255, 0.64);
        background: transparent;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: color 0.3s ease;
        z-index: 1;
        border-radius: 10px;
        box-shadow: 0 5px 10px rgba(0, 212, 255, 0.5);
    }

    .btn-liquid i {
        padding-right: 10px;
    }

    .btn-liquid::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 0;
        background: rgba(4, 203, 243, 0.38);
        z-index: -1;
        transition: height 0.3s ease;
    }

    .btn-liquid:hover {
        color: white;
    }

    .btn-liquid:hover::before {
        height: 100%;
    }

    /* ========== end liquid button ============= */

    /* ========= start border animate button ========== */
    .btn-border-animate {
        width: 100%;
        margin-top: 10px;
        padding: 12px 24px;
        background: transparent;
        color: #00d4ff;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        position: relative;
        border: 2px solid transparent;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-border-animate::before,
    .btn-border-animate::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background: #00d4ff;
        transition: all 0.3s ease;
    }

    .btn-border-animate::before {
        top: 0;
        left: 0;
    }

    .btn-border-animate::after {
        bottom: 0;
        right: 0;
    }

    .btn-border-animate:hover {
        color: white;
        background: rgba(0, 212, 255, 0.1);
    }

    .btn-border-animate:hover::before,
    .btn-border-animate:hover::after {
        width: 100%;
    }

    /* ======== end border animate button ======== */

    /* ============= start input type Styles ============== */
    .form-group {
        position: relative;
        margin-bottom: 0;
    }

    .form-group input {
        width: 100%;
        padding: 12px 50px;
        border: 2px solid rgba(0, 213, 255, 0.64);
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        background-color: transparent;
        color: white;
        margin-bottom: 10px;
    }

    .form-group input:focus {
        border-color: rgba(0, 213, 255, 0.64);
        box-shadow: 0 0 0 2px rgba(0, 213, 255, 0.64);
        outline: none;
        background-color: transparent;
    }

    .form-group i {
        position: absolute;
        left: 15px;
        top: 40px;
        color: white;
        font-size: 18px;
        z-index: 2;
    }

    .form-group label {
        display: flex;
        margin-bottom: 5px;
        font-weight: 600;
        color: white;
        font-size: 14px;
        padding-left: 5px;
        position: relative;
    }

    .form-group label span {
        color: rgba(0, 213, 255, 0.64);
        font-size: 16px;
        margin-left: 5px;
    }

    /* ============= end input type Styles ============== */

    /* ========== start form dropdown style =============== */
    .modern-form-group {
        margin-bottom: 20px;
    }

    .modern-form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-weight: 600;
        color: white;
        font-size: 14px;
        padding-left: 6px;
    }

    .modern-form-group label i {
        color: white;
        font-size: 16px;
    }

    .modern-form-group select {
        width: 100%;
        padding: 14px 15px 14px 14px;
        border: 2px solid rgba(0, 213, 255, 0.64);
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s;
        background-color: transparent;
        color: rgb(242, 214, 74);
    }

    .modern-form-group select:focus {
        border-color: rgba(0, 213, 255, 0.64);
        box-shadow: 0 0 0 2px rgba(0, 213, 255, 0.64);
        outline: none;
        background-color: transparent;
    }

    /* ========= end form dropdown style ========== */

    /* ====== start topup img design ===== */
    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background: transparent;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.51);
        font-family: var(--primary-font);
    }

    .gallery-item {
        width: 130px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
    }

    .gallery-circle {
        width: 80%;
        height: 105px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
        margin: 0 auto;
    }

    .gallery-circle:hover {
        border-color: #777;
        transform: scale(1.05);
    }

    .gallery-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-caption {
        margin-top: 12px;
        font-size: 18px;
        color: white;
        background-color: transparent;
    }

    /* ====== end topup img design ===== */

    /* ========= start elegant box ======== */
    .elegant-box {
        width: 320px;
        min-height: 120px;
        padding: 25px;
        border: 2px solid #4e8cff;
        border-radius: 16px;
        background: transparent;
        box-shadow: 0 8px 20px rgba(78, 140, 255, 0.15);
        color: #2c3e50;
        font-family: var(--primary-font);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        margin: 20px auto;
    }

    .elegant-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(32, 32, 33, 0.41);
        background: linear-gradient(135deg, rgb(59, 74, 95), rgb(61, 93, 97));
    }

    .elegant-box span {
        font-size: 1.5rem;
        font-weight: 600;
        color: rgb(154, 117, 241);
        margin-bottom: 12px;
        display: inline-block;
    }

    .elegant-box p {
        font-size: 0.95rem;
        line-height: 1.5;
        color: rgb(249, 249, 249);
        margin: 0;
        padding: 0 10px;
    }

    /* ============ end elegant box ============ */

    /* =========== start main and game wallet =================== */
    .modern-wallet-card-container {
        background: linear-gradient(135deg, #1a1a4bff 0%, #21405fff 100%);
        border-radius: 18px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        padding: 10px 20px;
        margin-bottom: 20px;
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #e0e0e0;
        position: relative;
        overflow: hidden;
    }

    .wallet-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
        gap: 10px;
    }

    .wallet-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
        flex-basis: 0;
        min-width: 180px;
    }

    .wallet-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
    }

    .wallet-icon i {
        font-size: 24px;
        color: #f4b400;
    }

    .main-wallet-section .wallet-icon i {
        color: #f4b400;
    }

    .game-wallet-section .wallet-icon i {
        color: #007bff;
    }

    .wallet-details {
        text-align: left;
        flex-grow: 1;
    }

    .wallet-name {
        font-size: 18px;
        font-weight: 600;
        color: #e0e0e0;
        margin-bottom: 5px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wallet-balance-display {
        display: flex;
        align-items: baseline;
        white-space: nowrap;
    }

    .wallet-currency {
        font-size: 20px;
        font-weight: 700;
        color: #fce205;
        margin-right: 5px;
    }

    .wallet-amount {
        font-size: 24px;
        font-weight: 800;
        color: #fce205;
        letter-spacing: 0.5px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .balance-toggle {
        margin-left: 10px;
        cursor: pointer;
        font-size: 18px;
        color: rgba(255, 255, 255, 0.5);
        transition: color 0.2s ease;
        flex-shrink: 0;
    }

    .balance-toggle:hover {
        color: rgba(255, 255, 255, 0.8);
    }

    .wallet-action-btn {
        padding: 10px 15px;
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
        max-width: 120px;
        min-width: 100px;
        justify-content: center;
    }

    .wallet-action-btn.primary-btn {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
    }

    .wallet-action-btn.primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(10, 10, 10, 1);
    }

    .wallet-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.15), transparent);
        margin: 20px 0;
    }

    @media (max-width: 550px) {
        .modern-wallet-card-container {
            margin-bottom: 20px;
            padding: 20px 10px;
        }

        .wallet-section {
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .wallet-info {
            flex-grow: 1;
            flex-basis: auto;
            min-width: unset;
        }

        .wallet-details {
            flex-grow: 1;
            min-width: 0;
        }

        .wallet-name {
            font-size: 16px;
        }

        .wallet-amount {
            font-size: 20px;
        }

        .wallet-action-btn {
            width: auto;
            padding: 8px 12px;
            font-size: 14px;
            gap: 5px;
            min-width: unset;
            max-width: 100px;
        }
    }

    /* =========== end main and game wallet =================== */

    /* ======= start wallet transfer ================ */
    .modern-transfer-card-container {
        background: linear-gradient(135deg, #1a1a4bff 0%, #21405fff 100%);
        border-radius: 18px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        padding: 20px;
        margin-bottom: 20px;
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #e0e0e0;
        position: relative;
        overflow: hidden;
    }

    .transfer-direction-selector {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    .radio-card {
        display: block;
        background-color: rgba(255, 255, 255, 0.08);
        padding: 18px 20px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .radio-card:hover {
        background-color: rgba(255, 255, 255, 0.12);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .radio-card.selected-card {
        border-color: #fce205;
        background-color: rgba(252, 226, 5, 0.08);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4), 0 0 0 3px rgba(252, 226, 5, 0.2);
    }

    .radio-card input[type="radio"] {
        display: none;
    }

    .radio-card input[type="radio"]+.radio-content::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
        margin-right: 25px;
        vertical-align: middle;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .radio-card input[type="radio"]:checked+.radio-content::before {
        background-color: #fce205;
        border-color: #fce205;
        box-shadow: 0 0 0 4px rgba(252, 226, 5, 0.3);
    }

    .radio-content {
        display: flex;
        align-items: center;
        color: #e0e0e0;
    }

    .radio-label {
        font-size: 16px;
        font-weight: 600;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .wallet-display-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .wallet-icon-sm {
        font-size: 20px;
        flex-shrink: 0;
    }

    .wallet-icon-sm.from-icon {
        color: #f4b400;
    }

    .wallet-icon-sm.to-icon {
        color: #0880dcff;
    }

    .wallet-text {
        font-size: 16px;
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .transfer-arrow {
        font-size: 16px;
        color: rgba(255, 255, 255, 1);
        margin: 0 5px;
        flex-shrink: 0;
    }

    .amount-input-group {
        margin-bottom: 30px;
    }

    .input-label {
        display: block;
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 10px;
        text-align: left;
    }

    .input-wrapper {
        position: relative;
        border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        padding-bottom: 5px;
    }

    .styled-input {
        width: 100%;
        background: transparent;
        border: none;
        outline: none;
        font-size: 20px;
        font-weight: 700;
        color: #fce205;
        padding: 0;
        text-align: left;
    }

    .styled-input::placeholder {
        color: rgba(252, 226, 5, 0.4);
    }

    .styled-input:focus {
        border-color: #fce205;
    }

    @media (max-width: 550px) {
        .modern-transfer-card-container {
            margin-bottom: 20px;
            padding: 20px 10px;
        }

        .radio-card {
            padding: 18px 10px;
        }

        .radio-label {
            font-size: 14px;
            margin-right: 10px;
        }

        .radio-card input[type="radio"]+.radio-content::before {
            width: 12px;
            height: 12px;
            margin-right: 15px;
        }

        .wallet-text {
            font-size: 14px;
        }

        .transfer-arrow {
            font-size: 14px;
        }
    }

    /* ======= end wallet transfer ================ */

    /* ============= start wallet card style =============== */
    .balance-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        text-align: center;
    }

    .balance-label {
        font-size: 18px;
        color: rgb(8, 34, 162);
        margin-bottom: 5px;
    }

    .balance-label i {
        padding-left: 10px;
        cursor: pointer;
    }

    .balance-amount {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .action-btn {
        background: rgb(71, 112, 148);
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 500;
        color: #2c3e50;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
    }

    .action-btn i {
        font-size: 1.5rem;
        margin-bottom: 8px;
        color: white;
    }

    .action-btn span {
        font-size: 18px;
        color: white;
    }

    /* Make the last button full width */
    .action-btn:last-child {
        grid-column: 1 / -1;
    }

    .guide-section {
        margin-top: 30px;
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .guide-section h3 {
        color: #2c3e50;
        font-size: 1.2rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4e8cff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .guide-section h3::before {
        content: "📚";
        font-size: 1.4rem;
    }

    .guide-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .guide-link {
        display: flex;
        align-items: center;
        color: #4a5568;
        text-decoration: none;
        padding: 12px 15px;
        border-radius: 8px;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .guide-link:hover {
        background: #4e8cff;
        color: white;
        transform: translateX(5px);
    }

    .guide-link::before {
        content: "→";
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .guide-link:hover::before {
        transform: translateX(3px);
        color: white;
    }

    /* ========== end wallet card style ============= */

    /* ========== start pay container ========== */
    .pay-container {
        border-radius: 20px;
        max-width: 450px;
        width: 100%;
        margin: 0;
        padding: 30px;
        background: rgb(27, 50, 74);
        box-shadow: 0 15px 35px rgba(50, 45, 1, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        font-family: var(--primary-font);
    }

    .pay-item {
        text-align: center;
        margin-bottom: 25px;
    }

    .pay-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 15px;
        border: 2px solid var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
    }

    .pay-circle img {
        width: 70%;
        height: auto;
        object-fit: contain;
    }

    /* ========== end pay container ========= */

    /* =========== receive pay account ============= */
    .receive-box {
        width: 350px;
        min-height: 120px;
        padding: 25px;
        border: 2px solid #4e8cff;
        border-radius: 16px;
        background: transparent;
        box-shadow: 0 8px 20px rgba(78, 140, 255, 0.15);
        color: #2c3e50;
        font-family: var(--primary-font);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        margin: 20px auto;
    }

    .receive-box span {
        font-size: 16px;
        color: rgb(206, 37, 37);
        margin-bottom: 12px;
        display: inline-block;
    }

    .receive-box p {
        font-size: 0.95rem;
        line-height: 1.5;
        color: white;
        margin: 0;
        padding: 0 10px;
    }

    .receive-box p span {
        color: rgb(248, 203, 58);
        font-weight: bold;
        cursor: pointer;
        padding-left: 10px;
        font-size: 1.3rem;
    }

    .copy-container {
        position: relative;
        display: inline-block;
        margin-left: 8px;
    }

    .copy-icon {
        cursor: pointer;
        color: #3498db;
        transition: all 0.2s;
    }

    .copy-icon:hover {
        color: #2980b9;
    }

    .copy-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s;
        white-space: nowrap;
        margin-bottom: 5px;
    }

    .copy-tooltip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #333 transparent transparent transparent;
    }

    /* ========== end receive pay account =========== */

    /* ========= start floating note group ========== */
    .note-group {
        background: rgba(7, 7, 7, 0.49);
        border-left: 5px solid rgb(237, 121, 113);
        border-radius: 0 8px 8px 0;
        padding: 10px 15px;
        margin: 7px 0;
        box-shadow: 2px 2px 2px 0 #00d4ff;
    }

    .note-label {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        color: rgb(237, 121, 113);
        font-size: 12px;
        line-height: 1.5;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .note-icon {
        font-size: 16px;
        animation: ntgroup 2s infinite alternate;
    }

    .note-text {
        flex: 1 1 100%;
        color: rgb(2, 90, 197);
        font-size: 10px;
    }

    /* ========= amount container ============ */
    .amount-container {
        max-width: 500px;
        margin: 20px auto;
        padding: 0 15px;
    }

    .amount-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .amount-btn {
        position: relative;
        border: 2px solid rgb(248, 203, 58);
        background-color: transparent;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 35px;
        min-height: 35px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.5);
    }

    .amount-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(117, 126, 57, 0.5);
        background-color: rgb(65, 65, 61);
    }

    .amount-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(0, 166, 81, 0.2);
    }

    .amount {
        font-size: 12px;
        font-weight: 700;
        color: white;
        margin-bottom: 3px;
    }

    /* ========= end amount container ========= */

    /* Animation for the sparkle icon */
    @keyframes ntgroup {
        from {
            opacity: 0.7;
            transform: scale(1);
        }

        to {
            opacity: 1;
            transform: scale(1.1);
            text-shadow: 0 0 5px rgb(237, 121, 113);
        }
    }

    /* ======== end floating note group ======= */

    /* ====== start tab container ============ */
    .modern-tab-container {
        background-color: rgb(27, 50, 74);
        border-radius: 10px;
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 15px 35px rgba(50, 45, 1, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        font-family: var(--primary-font);
    }

    /* Modern Tab Header */
    .modern-tab-header {
        display: flex;
        background: rgba(5, 27, 107, 0.1);
        padding: 5px;
    }

    .modern-tab-btn {
        flex: 1;
        padding: 15px 10px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        border-radius: 10px;
        position: relative;
        background: transparent;
    }

    .modern-tab-btn i {
        font-size: 18px;
        transition: all 0.3s;
    }

    .modern-tab-btn.active {
        color: rgb(234, 188, 3);
        background: rgb(33, 46, 59);
        box-shadow: 0 3px 10px rgba(4, 95, 122, 0.1);
    }

    .modern-tab-btn.active i {
        color: rgb(234, 188, 3);
    }

    /* Modern Tab Content */
    .modern-tab-content {
        padding: 15px 10px;
    }

    .modern-tab-pane {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .modern-tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ======== end tab container ============= */

    /* ======= start colaspe container ======== */
    .collapse-container {
        max-width: 600px;
        margin: 0 auto;
        font-family: var(--primary-font);
    }

    /* Collapse Item */
    .collapse-item {
        background: rgb(3, 34, 55);
        /* border-left: 4px solid rgb(234, 188, 3); */
        border-radius: 0 8px 8px 0;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Collapse Header */
    .collapse-header {
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        color: white;
        font-weight: 500;
        transition: background 0.3s;
    }

    .collapse-header:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .collapse-header i:first-child {
        /* color: rgb(234, 188, 3); */
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .toggle-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Collapse Content */
    .collapse-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: rgba(0, 0, 0, 0.1);
    }

    .collapse-content p {
        color: white;
        font-size: 14px;
        margin: 0;
        padding: 12px 15px 12px 51px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .collapse-content p i {
        color: rgb(254, 254, 254);
        font-size: 14px;
        position: absolute;
        left: 27px;
    }

    /* Active State */
    .collapse-item.active .collapse-content {
        max-height: 500px;
        /* Adjust based on content */
    }

    .collapse-item.active .toggle-icon {
        transform: rotate(180deg);
    }

    .collapse-edit-btn {
        flex: 1;
        padding: 10px 12px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        gap: 5px;
        transition: all 0.3s;
        background-color: rgb(89, 65, 5);
        color: white;
    }

    .collapse-edit-btn:hover {
        background-color: rgb(5, 93, 193);
        transform: translateY(-2px);
    }

    /* ======= end collaspe container =========== */

    /* ========= start quiz container ================== */
    .quiz-container {
        /* font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; */
        min-height: 100vh;
        background: linear-gradient(135deg, rgb(48, 73, 101) 0%, rgb(149, 159, 173) 100%);
        padding: 20px;
    }

    /* Login Card */
    .quiz-card {
        background-color: rgb(27, 50, 74);
        border-radius: 20px;
        padding: 15px;
        margin: auto;
        max-width: 1000px;
        box-shadow: 0 15px 35px rgba(50, 45, 1, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
    }

    .question {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: white;
    }

    .question span {
        font-size: 1.0rem;
        /* margin-bottom: 10px; */
        color: red;
    }

    .options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        color: white;
    }

    .option {
        flex: 1 1 calc(25% - 15px);
        /* 4 items per row */
        min-width: 150px;
    }

    .option label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        height: 100%;
        box-sizing: border-box;
    }

    .option input[type="radio"] {
        accent-color: #007bff;
        transform: scale(1.2);
    }

    .question-block {
        padding-bottom: 20px;
        margin-bottom: 14px;
        border-bottom: 1px solid #555;
    }

    /* နောက်ဆုံး block မှာ border မထည့် */
    .question-block:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* =========== end quiz container ========= */

    /* ======== start point box ========= */
    .point-box {
        position: relative;
        margin: 0 auto;
        padding: 20px;
        background: transparent;
        border-radius: 12px;
        font-family: var(--primary-font);
    }

    .point-box p {
        margin: 0;
        position: absolute;
        bottom: 0;
        right: 0;
        padding: 20px;
        font-weight: bold;
        color: white;
        cursor: pointer;
    }

    .point-box p i {
        padding-right: 15px;
        color: red;
    }

    .point-group {
        background: rgba(7, 7, 7, 0.49);
        border-left: 5px solid rgb(238, 31, 16);
        border-radius: 0 8px 8px 0;
        padding: 10px 12px;
        margin: 7px 0;

        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .point-group label {
        gap: 8px;
        color: rgb(237, 121, 113);
        font-size: 15px;
        line-height: 1.5;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .point-group a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
        font-size: 18px;
        padding-top: 15px;
    }

    .point-group a i {
        padding-right: 10px;
    }

    .point-noti {
        background: rgba(7, 7, 7, 0.34);
        border-bottom: 2px solid rgb(16, 64, 238);
        border-radius: 8px;
        padding: 10px;
        margin: 10px 0;
        color: white;
    }

    /* ======== end point box ========= */

    /* ========= start point detail ============ */
    .point-detail {
        background: rgb(4, 78, 128);
        border: 2px solid rgb(13, 3, 90);
        border-radius: 10px;
        margin-bottom: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.49);
        text-decoration: none;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .point-detail a:hover {
        background: rgb(2, 39, 63);
    }

    /* ========= end point detail =========== */

    /* ========= start card container ======= */
    .card-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px 10px;
        margin: 0 auto;
    }

    .card {
        width: 500px;
        background: rgb(27, 50, 74);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.53);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: scale(1.03);
    }

    .card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .card-label {
        padding: 15px;
        font-size: 20px;
        font-weight: bold;
        color: white;
        text-align: center;
    }

    /* ========= end card container ======== */

    /* =========== start benefit box container ======= */
    .benefit-card {
        width: 100%;
        max-width: 1000px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.64);
        padding: 30px 25px;
        text-align: center;
        transition: transform 0.3s ease;
        margin: 15px auto;
    }

    .benefit-card i {
        font-size: 48px;
        color: rgb(34, 86, 141);
        margin-bottom: 20px;
    }

    .benefit-card h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #333;
    }

    .benefit-card p {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
    }

    /* =========== end benefit box container ======== */

    /* ======== start notification =============== */
    .notification-list {
        width: 800px;
        margin: 0 auto;
        background: rgb(27, 50, 74);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .notification-item {
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .notification-title {
        padding: 15px 20px;
        font-weight: bold;
        color: white;
        position: relative;
    }

    .notification-title::after {
        content: "+";
        position: absolute;
        right: 20px;
        font-size: 18px;
        transition: transform 0.3s;
    }

    .notification-item.active .notification-title::after {
        content: "-";
    }

    .notification-description {
        display: none;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background: rgb(40, 58, 76);
        border-top: 1px solid #eee;
    }

    .notification-description span {
        font-size: 12px;
        color: rgb(248, 152, 63);
    }

    .notification-item.active .notification-description {
        display: block;
    }

    /* ======== end notification ============== */

    /* ========= for responsive ============ */
    @media (max-width: 768px) {
        .nav-logo {
            height: 30px;
        }

        .nav-logo-img {
            max-width: 120px;
        }

        .nav-links {
            display: none;
        }

        .menu-toggle {
            display: flex;
            margin-right: 0;
        }

        .nav-links li {
            border-bottom: 1px solid #00d4ff;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .carousel-container {
            padding: 20px 15px;
        }

        .owl-carousel .item {
            height: 390px;
        }

        .reload-icon {
            display: block;
            /* Mobile မှာသာ ပြပါ */
        }

        /* .page-header {
            padding: 60px 20px 10px;
        } */
        .gallery-item {
            width: 125px;
        }

        .gallery-circle {
            height: 100px;
        }

        .elegant-box {
            width: 300px;
        }

        .receive-box {
            width: 300px;
        }

        .note-group {
            padding: 10px 12px;
        }

        .note-label {
            font-size: 13px;
        }

        .option {
            flex: 1 1 100%;
            /* 1 per row for small devices */
        }

        .question {
            font-size: 1.1rem;
        }

        .card-container {
            padding: 20px 15px;
            margin: 0 10px;
        }

        .benefit-card {
            padding: 25px 15px;
            max-width: 90%;
        }
    }

    /* ============ start custom bg colors ================= */
    .bg-color-black {
        background-color: rgba(0, 0, 0, 0.22);
    }

    .bg-color-white {
        background-color: #fff;
    }

    .bg-color-blue {
        background-color: rgb(3, 34, 55);
    }

    /* ============= start rating stars ================= */

    .rating-row {
        display: flex;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .rating-label {
        width: 280px;
        font-weight: 600;
        color: rgb(0, 17, 255);
        margin-right: 12px;
    }

    .stars {
        direction: rtl;
        display: flex;
        gap: 8px;
    }

    .stars input {
        display: none;
    }

    .stars label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .stars input:checked~label {
        color: #ffc107;
    }

    .stars label:hover,
    .stars label:hover~label {
        color: #ffca2c;
        transform: scale(1.1);
    }

    @media screen and (max-width: 767px) {
        .rating-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .rating-label {
            width: 100%;
            text-align: left;
            margin-bottom: 6px;
        }

        .stars {
            justify-content: flex-start;
        }
    }
    </style>
</head>

<body>
    <div class="toast-container" id="toastContainer"></div>

    <div class="overlay" id="overlay" onclick="closeNav()"></div>
    <nav>
        <div class="nav-logo">
            <a href="<?=roothtml.'index.php'?>">
                <img src="<?php echo roothtml.'lib/img/app-logo3.png'?>" alt="Sport Template" class="nav-logo-img">
            </a>
        </div>
        <div class="mobile-header-controls">
            <?php if (isset($_SESSION["esportclient_username"])) { ?>
            <div class="menu-toggle" id="menuToggle" onclick="toggleNav()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?php } else{  ?>
            <div class="reload-icon" id="btn_signin">
                <i class="fas fa-sign-in"></i>
            </div>
            <?php }  ?>
            <div class="reload-icon" id="reloadButton" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
            </div>
        </div>

        <ul class="nav-links">
            <li class="<?=(curlink == 'index.php')?'active':''?>">
                <a href="<?=roothtml.'index.php'?>"><i class="fas fa-house"></i> Home</a>
            </li>
            <?php if (isset($_SESSION["esportclient_username"])) { ?>
            <li class="<?=(curlink == 'wallet.php' || curlink == 'topup.php' || 
                curlink == 'withdraw.php' || curlink == 'topupkpay.php' || 
                curlink == 'topupwave.php' || curlink == 'withdrawkpay.php' || 
                curlink == 'withdrawwave.php' || curlink == 'history.php')?'active':''?>">
                <a href="<?=roothtml.'wallet/wallet.php'?>"><i class="fas fa-wallet"></i> Wallet</a>
            </li>
            <li class="<?=(curlink == 'change_password.php' || 
                curlink == 'mypoints.php' || curlink == 'quiz.php' || 
                curlink == 'notification.php')?'active':''?>">
                <a href="#"><i class="fas fa-house-user"></i> Profile</a>
                <div class="dropdown">
                    <a href="<?=roothtml.'profile/change_password.php'?>">
                        <i class="fas fa-key"></i> Change Password</a>
                    <a href="<?=roothtml.'profile/notification.php'?>">
                        <i class="fas fa-bell"></i> Notification</a>
                    <a href="<?=roothtml.'profile/mypoints.php'?>">
                        <i class="fas fa-crown"></i> My Points</a>
                    <a href="#" id="btn_logout">
                        <i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </li>
            <?php } ?>
            <li class="<?=(curlink == 'service.php')?'active':''?>">
                <a href="<?=roothtml.'service/service.php'?>">
                    <i class="fas fa-headphones-alt"></i> Service</a>
            </li>
            <?php if(!isset($_SESSION["esportclient_username"])){ ?>
            <li><a href="<?=roothtml.'login/login.php'?>"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <?php }else{ 
                $deskamt = GetInt("SELECT Balance FROM tblplayer WHERE AID = ?", [$_SESSION["esportclient_userid"]]);
            ?>
            <li class="desk-profile">
                <div class="desk-username"><?=$_SESSION["esportclient_username"]?></div>
            </li>
            <?php } ?>
        </ul>
    </nav>

    <div class="side-nav" id="sideNav">
        <?php 
        if (isset($_SESSION["esportclient_username"])) { 
            $useramt = GetInt("SELECT Balance FROM tblplayer WHERE AID = ?", [$_SESSION["esportclient_userid"]]);
        ?>
        <div class="user-profile">
            <h3 class="user-name"><?=$_SESSION["esportclient_username"]?></h3>
        </div>
        <?php } ?>
        <ul>
            <li class="<?=(curlink == 'index.php')?'active':''?>">
                <a href="<?=roothtml.'index.php'?>"><i class="fas fa-house"></i> Home</a>
            </li>
            <?php if (isset($_SESSION["esportclient_username"])) { ?>
            <li class="<?=(curlink == 'wallet.php' || curlink == 'topup.php' || 
                curlink == 'withdraw.php' || curlink == 'topupkpay.php' || 
                curlink == 'topupwave.php' || curlink == 'withdrawkpay.php' || 
                curlink == 'withdrawwave.php' || curlink == 'history.php')?'active':''?>">
                <a href="<?=roothtml.'wallet/wallet.php'?>"><i class="fas fa-wallet"></i> Wallet</a>
            </li>
            <li class="has-sub <?=(curlink == 'change_password.php' || 
                curlink == 'mypoints.php' || curlink == 'quiz.php' || 
                curlink == 'notification.php')?'active':''?>">
                <a href="#"><i class="fas fa-house-user"></i> Profile</a>
                <div class="submenu">
                    <a href="<?=roothtml.'profile/change_password.php'?>">
                        <i class="fas fa-key"></i> Change Password</a>
                    <a href="<?=roothtml.'profile/notification.php'?>">
                        <i class="fas fa-bell"></i> Notification</a>
                    <a href="<?=roothtml.'profile/mypoints.php'?>">
                        <i class="fas fa-crown"></i> My Points</a>
                    <a href="#" id="btn_logout">
                        <i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </li>
            <?php } ?>
            <li class="<?=(curlink == 'service.php')?'active':''?>">
                <a href="<?php echo roothtml.'service/service.php'?>">
                    <i class="fas fa-headphones-alt"></i> Service</a>
            </li>
            <?php if (!isset($_SESSION["esportclient_username"])) { ?>
            <li><a href="<?=roothtml.'login/login.php'?>">
                    <i class="fas fa-sign-in-alt"></i> Login</a></li>
            <?php }  ?>
        </ul>
    </div>