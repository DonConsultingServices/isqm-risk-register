<h2>Managing Clients</h2>

<p>Clients can be associated with ISQM entries to track quality requirements at the client level. This guide explains how to manage clients in the system.</p>

<div class="warning-box">
  <h4>⚠️ Access Required</h4>
  <p>Client management is available only to users with Manager or Admin roles. If you don't have access, contact your administrator.</p>
</div>

<h3>Accessing Client Management</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Management</h4>
  <p>Click on "Management" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Clients"</h4>
  <p>Click on "Clients" in the Management dropdown menu.</p>
</div>

<h3>Viewing Clients</h3>
<div class="step-box">
  <h4>Client List</h4>
  <p>The Clients page displays a list of all clients in the system, showing:
    <ul>
      <li>Client name</li>
      <li>Industry</li>
      <li>Email address</li>
      <li>Phone number</li>
      <li>Actions (Edit, Delete)</li>
    </ul>
  </p>
</div>

<h3>Creating a New Client</h3>
<div class="step-box">
  <h4>Step 1: Click "Add Client"</h4>
  <p>Click the "Add Client" button at the top right corner of the Clients page.</p>
</div>

<div class="step-box">
  <h4>Step 2: Fill in Client Information</h4>
  <p>Enter the client information:
    <ul>
      <li><strong>Name</strong> (Required) - The client's name</li>
      <li><strong>Industry</strong> (Optional) - The client's industry</li>
      <li><strong>Email</strong> (Optional) - The client's email address</li>
      <li><strong>Phone</strong> (Optional) - The client's phone number</li>
    </ul>
  </p>
</div>

<div class="step-box">
  <h4>Step 3: Save the Client</h4>
  <p>Click the "Save" button to create the client. You'll be asked to confirm before saving.</p>
</div>

<h3>Editing a Client</h3>
<div class="step-box">
  <h4>Step 1: Find the Client</h4>
  <p>Locate the client you want to edit in the Clients list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Edit"</h4>
  <p>Click the "Edit" button next to the client. You'll be asked to confirm before proceeding.</p>
</div>

<div class="step-box">
  <h4>Step 3: Update Information</h4>
  <p>Modify the client information as needed and click "Save" to update. You'll be asked to confirm before saving.</p>
</div>

<h3>Deleting a Client</h3>
<div class="step-box">
  <h4>Step 1: Find the Client</h4>
  <p>Locate the client you want to delete in the Clients list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Delete"</h4>
  <p>Click the "Delete" button (red button) next to the client.</p>
</div>

<div class="step-box">
  <h4>Step 3: Confirm Deletion</h4>
  <p>Confirm the deletion in the popup dialog. You'll be warned that all client data and associated ISQM entries will be permanently removed.</p>
</div>

<div class="warning-box">
  <h4>⚠️ Delete Warning</h4>
  <p>Deleting a client is permanent and cannot be undone. All client data and associated ISQM entries will be permanently removed. Make sure you want to delete the client before confirming.</p>
</div>

<h3>Associating Clients with Entries</h3>
<div class="step-box">
  <h4>Step 1: Create or Edit an Entry</h4>
  <p>When creating or editing an ISQM entry, you can select a client from the "Client" dropdown.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select the Client</h4>
  <p>Select the client you want to associate with the entry from the dropdown. If the client doesn't exist, you'll need to create it first (Manager/Admin only).</p>
</div>

<div class="step-box">
  <h4>Step 3: Save the Entry</h4>
  <p>Save the entry to associate the client with it. The entry will now be linked to the client.</p>
</div>

<h3>Filtering Entries by Client</h3>
<div class="step-box">
  <h4>Using Client Filter</h4>
  <p>You can filter ISQM entries by client:
    <ol>
      <li>Navigate to the Register page</li>
      <li>Use the "Client" filter dropdown</li>
      <li>Select a client from the list</li>
      <li>Click "Filter" to see only entries associated with that client</li>
    </ol>
  </p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Create clients before associating them with entries</li>
    <li>Use consistent naming conventions for clients</li>
    <li>Fill in as much client information as possible</li>
    <li>Update client information when it changes</li>
    <li>Associate entries with clients to track client-specific quality requirements</li>
    <li>Use client filters to view all entries for a specific client</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After managing clients, you can:</p>
<ul>
  <li><a href="{{ route('user-guide.show', 'creating-entries') }}">Create entries</a> and associate them with clients</li>
  <li>Use <a href="{{ route('user-guide.show', 'using-filters') }}">filters</a> to find entries by client</li>
  <li>Generate <a href="{{ route('user-guide.show', 'reports-exports') }}">reports</a> filtered by client</li>
</ul>

