<h2>Compliance Now</h2>

<p>The Compliance Now page shows all ISQM entries that require immediate attention for compliance purposes. This guide explains how to use this feature effectively.</p>

<h3>What is Compliance Now?</h3>
<p>Compliance Now is a focused view that displays only entries that are relevant for compliance. It shows entries where:</p>
<ul>
  <li><strong>Risk Applicable</strong> is set to "Yes" (true), or</li>
  <li><strong>Risk Applicable</strong> is not yet determined (NULL)</li>
</ul>

<div class="info-box">
  <h4>💡 Why This Matters</h4>
  <p>Entries where "Risk Applicable" is set to "No" are filtered out because they are not relevant for compliance purposes. The Compliance Now page helps you focus on entries that need attention.</p>
</div>

<h3>Accessing Compliance Now</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Register</h4>
  <p>Click on "Register" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Compliance Now"</h4>
  <p>Click the "Compliance Now" button in the top right corner of the Filters section.</p>
</div>

<div class="step-box">
  <h4>Alternative: Direct Access</h4>
  <p>You can also access Compliance Now directly from the navigation menu if it's available, or by visiting the URL: <code>/isqm/compliance-now</code></p>
</div>

<h3>Understanding the Compliance Now Page</h3>

<h4>Page Layout</h4>
<p>The Compliance Now page displays entries grouped by ISQM area/module:</p>
<ul>
  <li>Each area is displayed as a card</li>
  <li>Within each area, entries are displayed as risk cards</li>
  <li>Each risk card shows key information about the entry</li>
</ul>

<h4>Entry Information Displayed</h4>
<p>For each entry, the following information is displayed:</p>
<ul>
  <li><strong>Quality Objective</strong> - The quality objective for the area</li>
  <li><strong>Quality Risk</strong> - The quality risk associated with the objective</li>
  <li><strong>Why this matters</strong> - Assessment of risk</li>
  <li><strong>Required Response</strong> - Response to quality risk</li>
  <li><strong>Firm Implementation</strong> - How the firm implements the response</li>
  <li><strong>Test of Controls</strong> - Test of controls performed</li>
  <li><strong>Remedial Actions</strong> - Remedial actions taken</li>
  <li><strong>Monitoring Notes</strong> - Findings, deficiency type, and root cause</li>
</ul>

<h4>Risk Flags</h4>
<p>Entries may have risk flags displayed as chips:</p>
<ul>
  <li><strong>Severe</strong> - Indicates a severe risk (red chip)</li>
  <li><strong>Pervasive</strong> - Indicates a pervasive risk (purple chip)</li>
  <li><strong>Monitoring Activity</strong> - Shows the monitoring activity name (green chip)</li>
</ul>

<h3>Downloading Compliance Data</h3>
<div class="step-box">
  <h4>Export to CSV</h4>
  <p>You can download the compliance data as a CSV file:
    <ol>
      <li>Click the "Download CSV" button at the top of the page</li>
      <li>The CSV file will be downloaded to your computer</li>
      <li>Open the file in Excel or another spreadsheet application</li>
    </ol>
  </p>
</div>

<div class="tip-box">
  <h4>💡 Export Tips</h4>
  <ul>
    <li>The CSV file includes all entries shown on the Compliance Now page</li>
    <li>You can use this file for reporting and documentation purposes</li>
    <li>The file is named with the current date for easy identification</li>
  </ul>
</div>

<h3>Using Compliance Now Effectively</h3>

<h4>Regular Reviews</h4>
<div class="step-box">
  <h4>Weekly Reviews</h4>
  <p>Review the Compliance Now page weekly to ensure all applicable risks are being addressed. This helps maintain compliance and identify areas that need attention.</p>
</div>

<h4>Updating Risk Applicability</h4>
<div class="step-box">
  <h4>Setting Risk Applicable</h4>
  <p>For each entry, you should determine if the risk is applicable to your organization:
    <ul>
      <li>If the risk is applicable, set "Risk Applicable" to "Yes" - the entry will appear in Compliance Now</li>
      <li>If the risk is not applicable, set "Risk Applicable" to "No" - the entry will be filtered out of Compliance Now</li>
      <li>If you're not sure, leave it as "Not Set" - the entry will appear in Compliance Now until you make a determination</li>
    </ul>
  </p>
</div>

<h4>Taking Action</h4>
<div class="step-box">
  <h4>Addressing Entries</h4>
  <p>When you see an entry on the Compliance Now page:
    <ol>
      <li>Review the entry details</li>
      <li>Determine if action is needed</li>
      <li>Update the entry with findings, remedial actions, or status changes</li>
      <li>Set appropriate dates (due date, review date)</li>
      <li>Assign an owner if not already assigned</li>
    </ol>
  </p>
</div>

<h3>Empty State</h3>
<p>If the Compliance Now page is empty, it means:</p>
<ul>
  <li>All entries have "Risk Applicable" set to "No", or</li>
  <li>There are no entries in the system yet</li>
</ul>

<div class="info-box">
  <h4>💡 Empty State Note</h4>
  <p>An empty Compliance Now page is not necessarily a problem. It may indicate that all applicable risks have been addressed, or that risks have been determined to be not applicable to your organization.</p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Review Compliance Now regularly (weekly or monthly)</li>
    <li>Ensure all entries have "Risk Applicable" set appropriately</li>
    <li>Update entries with findings and remedial actions as they become available</li>
    <li>Use the export feature to generate compliance reports</li>
    <li>Document your compliance review process</li>
    <li>Keep entries up to date to maintain accurate compliance status</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After reviewing Compliance Now, you can:</p>
<ul>
  <li><a href="<?php echo e(route('user-guide.show', 'editing-entries')); ?>">Edit entries</a> to update information</li>
  <li>Use <a href="<?php echo e(route('user-guide.show', 'reports-exports')); ?>">reports and exports</a> to generate compliance documentation</li>
  <li>Review <a href="<?php echo e(route('user-guide.show', 'isqm-areas')); ?>">ISQM areas</a> to understand the compliance requirements</li>
</ul>

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/user-guide/topics/compliance-now.blade.php ENDPATH**/ ?>