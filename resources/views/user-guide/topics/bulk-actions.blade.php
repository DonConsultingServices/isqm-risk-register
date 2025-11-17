<h2>Bulk Actions</h2>

<p>Bulk Actions allow you to perform actions on multiple ISQM entries at once. This guide explains how to use bulk actions effectively.</p>

<h3>Accessing Bulk Actions</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Register</h4>
  <p>Click on "Register" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select Entries</h4>
  <p>Use the checkboxes in the first column to select entries you want to perform actions on. You can select individual entries or use the "Select All" checkbox to select all entries on the current page.</p>
</div>

<h3>Selecting Entries</h3>

<h4>Selecting Individual Entries</h4>
<div class="step-box">
  <h4>Step 1: Click Checkbox</h4>
  <p>Click the checkbox next to an entry to select it. The entry will be highlighted, and the bulk actions panel will appear.</p>
</div>

<h4>Selecting All Entries</h4>
<div class="step-box">
  <h4>Step 1: Click "Select All"</h4>
  <p>Click the checkbox in the table header to select all entries on the current page.</p>
</div>

<div class="info-box">
  <h4>💡 Selection Note</h4>
  <p>Only entries on the current page will be selected. If you want to select entries across multiple pages, you'll need to select them on each page separately.</p>
</div>

<h3>Available Bulk Actions</h3>

<h4>Change Status</h4>
<div class="step-box">
  <h4>Step 1: Select Entries</h4>
  <p>Select the entries you want to change the status for.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select Action</h4>
  <p>In the bulk actions panel, select "Change Status" from the action dropdown.</p>
</div>

<div class="step-box">
  <h4>Step 3: Select New Status</h4>
  <p>Select the new status from the status dropdown:
    <ul>
      <li><strong>Open</strong> - Set entries to "Open" status</li>
      <li><strong>Monitoring</strong> - Set entries to "Monitoring" status</li>
      <li><strong>Closed</strong> - Set entries to "Closed" status</li>
    </ul>
  </p>
</div>

<div class="step-box">
  <h4>Step 4: Apply Action</h4>
  <p>Click the "Apply" button to change the status of all selected entries. You'll be asked to confirm before applying.</p>
</div>

<h4>Delete Selected</h4>
<div class="step-box">
  <h4>Step 1: Select Entries</h4>
  <p>Select the entries you want to delete.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select Action</h4>
  <p>In the bulk actions panel, select "Delete Selected" from the action dropdown.</p>
</div>

<div class="step-box">
  <h4>Step 3: Confirm Deletion</h4>
  <p>Click the "Apply" button and confirm the deletion in the popup dialog. You'll be warned that all selected entries and their associated data will be permanently removed.</p>
</div>

<div class="warning-box">
  <h4>⚠️ Delete Warning</h4>
  <p>Deleting entries is permanent and cannot be undone. All selected entries and their associated data will be permanently removed. Make sure you want to delete the entries before confirming.</p>
</div>

<h3>Using Bulk Actions with Filters</h3>
<div class="step-box">
  <h4>Step 1: Apply Filters</h4>
  <p>Use filters to narrow down the entries you want to perform actions on. For example, filter by area, status, or client.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select Filtered Entries</h4>
  <p>Select the entries from the filtered results. You can select all filtered entries using the "Select All" checkbox.</p>
</div>

<div class="step-box">
  <h4>Step 3: Perform Action</h4>
  <p>Perform the desired bulk action on the selected entries.</p>
</div>

<div class="tip-box">
  <h4>💡 Filtering Tips</h4>
  <ul>
    <li>Filter by area to update all entries for a specific ISQM area</li>
    <li>Filter by status to change status for all entries with a specific status</li>
    <li>Filter by client to update all entries for a specific client</li>
    <li>Use date filters to update entries within a specific date range</li>
  </ul>
</div>

<h3>Clearing Selection</h3>
<div class="step-box">
  <h4>Cancel Selection</h4>
  <p>Click the "Cancel" button in the bulk actions panel to clear the selection and hide the bulk actions panel.</p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Use filters to narrow down entries before selecting</li>
    <li>Review selected entries before performing actions</li>
    <li>Use bulk actions to update multiple entries efficiently</li>
    <li>Be careful when deleting entries - double-check your selection</li>
    <li>Use bulk status changes to update entries in batches</li>
    <li>Clear selection after completing actions</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After performing bulk actions, you can:</p>
<ul>
  <li>Verify the changes by viewing the updated entries</li>
  <li>Use <a href="{{ route('user-guide.show', 'using-filters') }}">filters</a> to find other entries that need updating</li>
  <li>Check the <a href="{{ route('user-guide.show', 'compliance-now') }}">Compliance Now</a> page to see updated entries</li>
</ul>

