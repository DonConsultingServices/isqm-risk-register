<h2>Monitoring Activities</h2>

<p>Monitoring Activities are used to track and document monitoring processes for ISQM entries. This guide explains how to manage monitoring activities.</p>

<div class="warning-box">
  <h4>⚠️ Access Required</h4>
  <p>Monitoring Activity management is available only to users with Manager or Admin roles. If you don't have access, contact your administrator.</p>
</div>

<h3>Accessing Monitoring Activities</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Management</h4>
  <p>Click on "Management" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Monitoring Activities"</h4>
  <p>Click on "Monitoring Activities" in the Management dropdown menu (under Lists).</p>
</div>

<h3>Viewing Monitoring Activities</h3>
<div class="step-box">
  <h4>Activity List</h4>
  <p>The Monitoring Activities page displays a list of all monitoring activities in the system, showing:
    <ul>
      <li>Activity name</li>
      <li>Description</li>
      <li>Actions (Edit, Delete)</li>
    </ul>
  </p>
</div>

<h3>Creating a New Monitoring Activity</h3>
<div class="step-box">
  <h4>Step 1: Click "Add"</h4>
  <p>Click the "Add" button at the top right corner of the Monitoring Activities page.</p>
</div>

<div class="step-box">
  <h4>Step 2: Fill in Activity Information</h4>
  <p>Enter the monitoring activity information:
    <ul>
      <li><strong>Name</strong> (Required) - The name of the monitoring activity</li>
      <li><strong>Description</strong> (Optional) - A description of the monitoring activity</li>
    </ul>
  </p>
</div>

<div class="step-box">
  <h4>Step 3: Save the Activity</h4>
  <p>Click the "Save" button to create the monitoring activity. You'll be asked to confirm before saving.</p>
</div>

<h3>Editing a Monitoring Activity</h3>
<div class="step-box">
  <h4>Step 1: Find the Activity</h4>
  <p>Locate the monitoring activity you want to edit in the list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Edit"</h4>
  <p>Click the "Edit" button next to the activity. You'll be asked to confirm before proceeding.</p>
</div>

<div class="step-box">
  <h4>Step 3: Update Information</h4>
  <p>Modify the activity information as needed and click "Save" to update. You'll be asked to confirm before saving.</p>
</div>

<h3>Deleting a Monitoring Activity</h3>
<div class="step-box">
  <h4>Step 1: Find the Activity</h4>
  <p>Locate the monitoring activity you want to delete in the list.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Delete"</h4>
  <p>Click the "Delete" button (red button) next to the activity.</p>
</div>

<div class="step-box">
  <h4>Step 3: Confirm Deletion</h4>
  <p>Confirm the deletion in the popup dialog. You'll be warned that the activity will be removed from all associated ISQM entries.</p>
</div>

<div class="warning-box">
  <h4>⚠️ Delete Warning</h4>
  <p>Deleting a monitoring activity will remove it from all associated ISQM entries. Make sure you want to delete the activity before confirming.</p>
</div>

<h3>Using Monitoring Activities in Entries</h3>
<div class="step-box">
  <h4>Step 1: Create or Edit an Entry</h4>
  <p>When creating or editing an ISQM entry, you can select a monitoring activity from the "Monitoring Activity" dropdown.</p>
</div>

<div class="step-box">
  <h4>Step 2: Select the Activity</h4>
  <p>Select the monitoring activity you want to associate with the entry from the dropdown. If the activity doesn't exist, you'll need to create it first (Manager/Admin only).</p>
</div>

<div class="step-box">
  <h4>Step 3: Save the Entry</h4>
  <p>Save the entry to associate the monitoring activity with it. The activity will now be linked to the entry.</p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Create monitoring activities before associating them with entries</li>
    <li>Use descriptive names for monitoring activities</li>
    <li>Provide clear descriptions to explain what the activity entails</li>
    <li>Update monitoring activities when processes change</li>
    <li>Associate entries with monitoring activities to track monitoring processes</li>
    <li>Document findings and results in the entry's "Findings" field</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After managing monitoring activities, you can:</p>
<ul>
  <li><a href="{{ route('user-guide.show', 'creating-entries') }}">Create entries</a> and associate them with monitoring activities</li>
  <li><a href="{{ route('user-guide.show', 'editing-entries') }}">Edit entries</a> to add monitoring activities</li>
  <li>Use <a href="{{ route('user-guide.show', 'using-filters') }}">filters</a> to find entries by monitoring activity</li>
</ul>

