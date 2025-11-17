<h2>User Management</h2>

<p>User Management allows administrators to manage users, roles, and permissions in the system. This guide explains how to manage users effectively.</p>

<div class="warning-box">
  <h4>⚠️ Admin Access Required</h4>
  <p>User Management is available only to users with Admin role. If you don't have access, contact your administrator.</p>
</div>

<h3>Accessing User Management</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Management</h4>
  <p>Click on "Management" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Users"</h4>
  <p>Click on "Users" in the Management dropdown menu.</p>
</div>

<h3>Viewing Users</h3>
<div class="step-box">
  <h4>User List</h4>
  <p>The Users page displays a list of all users in the system, showing:
    <ul>
      <li>User name</li>
      <li>Email address</li>
      <li>Role (Staff, Manager, Admin)</li>
      <li>Created date</li>
      <li>Actions (Edit, Delete)</li>
    </ul>
  </p>
</div>

<h3>Creating a New User</h3>
<div class="step-box">
  <h4>Step 1: Click "Add User"</h4>
  <p>Click the "Add User" button at the top right corner of the Users page.</p>
</div>

<div class="step-box">
  <h4>Step 2: Fill in User Information</h4>
  <p>Enter the user information:
    <ul>
      <li><strong>Full Name</strong> (Required) - The user's full name</li>
      <li><strong>Email Address</strong> (Required) - The user's email address (used for login)</li>
      <li><strong>Password</strong> (Required) - The user's password (minimum 8 characters)</li>
      <li><strong>Confirm Password</strong> (Required) - Confirm the password</li>
      <li><strong>Role</strong> (Required) - Select the user's role (Staff, Manager, Admin)</li>
    </ul>
  </p>
</div>

<div class="step-box">
  <h4>Step 3: Save the User</h4>
  <p>Click the "Create User" button to create the user. You'll be asked to confirm before creating.</p>
</div>

<h3>User Roles</h3>
<p>The system has three user roles with different access levels:</p>

<h4>Staff</h4>
<ul>
  <li>Can view and create ISQM entries</li>
  <li>Can edit their own entries</li>
  <li>Can view the Dashboard</li>
  <li>Can view Compliance Now</li>
  <li>Can view Reports</li>
  <li>Cannot manage clients, users, or settings</li>
</ul>

<h4>Manager</h4>
<ul>
  <li>All Staff permissions, plus:</li>
  <li>Can manage clients</li>
  <li>Can manage monitoring activities</li>
  <li>Can manage deficiency types</li>
  <li>Can view activity logs</li>
  <li>Cannot manage users or settings</li>
</ul>

<h4>Admin</h4>
<ul>
  <li>All Manager permissions, plus:</li>
  <li>Can manage users</li>
  <li>Can manage system settings</li>
  <li>Full access to all features</li>
</ul>

<h3>Editing a User</h3>
<div class="step-box">
  <h4>Step 1: Find the User</h4>
  <p>Locate the user you want to edit in the Users list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Edit"</h4>
  <p>Click the "Edit" button next to the user. You'll be asked to confirm before proceeding.</p>
</div>

<div class="step-box">
  <h4>Step 3: Update Information</h4>
  <p>Modify the user information as needed:
    <ul>
      <li>Update the user's name</li>
      <li>Update the user's email address</li>
      <li>Change the user's password (leave blank to keep current password)</li>
      <li>Change the user's role</li>
    </ul>
    Click "Update User" to save. You'll be asked to confirm before saving.
  </p>
</div>

<div class="warning-box">
  <h4>⚠️ Role Change Warning</h4>
  <p>Changing a user's role may affect their access to features. Make sure the user understands the implications of the role change.</p>
</div>

<h3>Deleting a User</h3>
<div class="step-box">
  <h4>Step 1: Find the User</h4>
  <p>Locate the user you want to delete in the Users list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Delete"</h4>
  <p>Click the "Delete" button (red button) next to the user. Note: You cannot delete yourself.</p>
</div>

<div class="step-box">
  <h4>Step 3: Confirm Deletion</h4>
  <p>Confirm the deletion in the popup dialog. You'll be warned that all user data and associated records will be permanently removed.</p>
</div>

<div class="warning-box">
  <h4>⚠️ Delete Warning</h4>
  <p>Deleting a user is permanent and cannot be undone. All user data and associated records will be permanently removed. Make sure you want to delete the user before confirming.</p>
</div>

<div class="info-box">
  <h4>💡 Self-Deletion Protection</h4>
  <p>You cannot delete yourself. This prevents accidental account deletion. If you need to delete your own account, ask another administrator to do it.</p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Create users with appropriate roles based on their responsibilities</li>
    <li>Use strong passwords for user accounts</li>
    <li>Regularly review user accounts and remove inactive users</li>
    <li>Update user roles when their responsibilities change</li>
    <li>Keep user information up to date</li>
    <li>Document user access and permissions</li>
    <li>Monitor user activity through activity logs</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After managing users, you can:</p>
<ul>
  <li>Review <a href="{{ route('user-guide.show', 'settings') }}">system settings</a> to configure the system</li>
  <li>Check <a href="{{ route('user-guide.show', 'notifications') }}">notifications</a> to see user activity</li>
  <li>View activity logs to monitor user actions</li>
</ul>

