<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enhancement 2 - Brew & Go</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<header>
  <?php include 'navbar.php'; ?>
</header>

<section class="enhancement-container">
  <h1>Enhancements</h1>

<!-- 1 -->
<div class="enhancement-card">
  <h2>1. User Management Module</h2>
  <p><strong>Goes Beyond Requirements:</strong> Adds administrative control to manage users via a centralized dashboard.</p>
  <p><strong>Implementation Steps:</strong> Created `membership` table for user info, integrated with `user` table for login, and built admin interface for listing, editing, and deleting members.</p>
  <p><strong>Supported Operations (CRUD):</strong><br>
     <strong>Create:</strong> `add_members.php` allows admin to register a new member<br>
     <strong>Read:</strong> `view_membership.php` lists all registered members<br>
     <strong>Update:</strong> `edit_membership.php` lets admin modify member details<br>
     <strong>Delete:</strong> `edit_membership.php` lets admin delete members
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-user.png" alt="User Management Module">
  </div>
</div>

<!-- 2 -->
<div class="enhancement-card">
  <h2>2. Promotion and News Update Module</h2>
  <p><strong>Goes Beyond Requirements:</strong> Enables dynamic control of public-facing news via a database-powered admin activity manager.</p>
  <p><strong>Implementation Steps:</strong> Built an `activities` table with event details and applied PHP logic to separate current, past, and upcoming activities.</p>
  <p><strong>Supported Operations (CRUD):</strong><br>
     <strong>Create:</strong> Admin adds new activity via `add_activities.php`<br>
     <strong>Read:</strong> Activities listed on `admin_view_activities.php`<br>
     <strong>Update:</strong> Admin updates events using `edit_activities.php`<br>
     <strong>Delete:</strong> Admin can delete activities through `edit_activities.php`
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-activities.png" alt="Activity Management">
  </div>
</div>

<!-- 3 -->
<div class="enhancement-card">
  <h2>3. Job Application Module</h2>
  <p><strong>Goes Beyond Requirements:</strong> Converts Join Us form into a full admin-reviewable job application system.</p>
  <p><strong>Implementation Steps:</strong> Added `job_application` table, stored applicant photo and CV, and built admin interface for reviewing applications.</p>
  <p><strong>Supported Operations (CRUD):</strong><br>
     <strong>Create:</strong> Public submission via `joinus.php`<br>
     <strong>Read:</strong> Admin views applicant list in `admin_view_jobs.php`<br>
     <strong>Update:</strong> Admin updates status (Pending / Accepted / Rejected)<br>
     <strong>Delete:</strong> Admin can delete job applications
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-jobs.png" alt="Join Us Module">
  </div>
</div>

<!-- 4 -->
<div class="enhancement-card">
  <h2>4. Member Wallet Top-Up System</h2>
  <p><strong>Goes Beyond Requirements:</strong> Adds wallet top-up logic and history tracking for financial transparency.</p>
  <p><strong>Implementation Steps:</strong> Created `topup_history` table to track transactions. Form allows input of amount, and PHP handles the update of wallet balance.</p>
  <div class="enhancement-image">
    <img src="images/enhancement-topup.png" alt="Top-Up Module">
    <img src="images/enhancement-topup2.png" alt="Top-Up Module">

  </div>
</div>

<!-- 5 -->
<div class="enhancement-card">
  <h2>5. Page Authorization (RBAC)</h2>
  <p><strong>Goes Beyond Requirements:</strong> Enforces fine-grained access control to admin pages using Role-Based Access Control (RBAC). Unauthorized users are redirected to a custom <code>Access Denied</code> page with an explanation and a safe return button.</p>  <p><strong>Implementation Steps:</strong> Created `page_permissions` table, added middleware check in `auth.php`, and auto-seeded permissions by role.</p>
  <p><strong>Supported Operations:</strong><br>
     <strong>Create:</strong> Permissions seeded from setup.php<br>
     <strong>Read:</strong> System checks page/role match dynamically<br>
     <strong>Update:</strong> Admin can modify page-role pairs in `page_permissions` manually or via dashboard<br>
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-rbac.png" alt="RBAC">
    <img src="images/enhancement-rbac2.png" alt="RBAC">
  </div>
</div>

<!-- 6 -->
<div class="enhancement-card">
  <h2>6. Newsletter Subscription and History</h2>
  <p><strong>Goes Beyond Requirements:</strong> Adds newsletter sign-up for public users and message sending with attachment support for admins.</p>
  <p><strong>Implementation Steps:</strong> Built two tables: `newsletter_subscribers` for signups and `newsletter_history` for tracking sends.</p>
  <p><strong>Supported Operations:</strong><br>
     <strong>Create:</strong> Newsletter stored in `newsletter_history`<br>
     <strong>Read:</strong> Admin views history in `admin_view_newsletter.php`<br>
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-newsletter.png" alt="Newsletter">
  </div>
</div>

<!-- 7 -->
<div class="enhancement-card">
  <h2>7. Product Availability and  Search</h2>
  <p><strong>Goes Beyond Requirements:</strong> Users can search products by name or category; admins can toggle availability per product.</p>
  <p><strong>Implementation Steps:</strong> Product search added via GET filters. Product `availability` field determines display on menu pages.</p>
  <p><strong>Supported Operations (CRUD):</strong><br>
     <strong>Create:</strong> Admin adds new product in `add_products.php`<br>
     <strong>Read:</strong> Products shown in `menu1.php ~ menu4.php` with filters<br>
     <strong>Update:</strong> Operator sets availability in `edit_products.php`, Admin updates products using `edit_products.php`<br>
     <strong>Delete:</strong> Admin can remove product record
  </p>
  <div class="enhancement-image">
    <img src="images/enhancement-products.png" alt="Product Search and Availability">
  </div>
</div>

</section>

<?php include 'footer.php'; ?>
<?php include 'backtotop.php'; ?>

</body>
</html>