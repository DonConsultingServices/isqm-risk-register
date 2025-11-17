<h2>Importing Data</h2>

<p>The Import feature allows you to import ISQM entries from Excel files. This guide explains how to import data effectively.</p>

<h3>Accessing the Import Page</h3>
<div class="step-box">
  <h4>Step 1: Navigate to Register</h4>
  <p>Click on "Register" in the main navigation sidebar.</p>
</div>

<div class="step-box">
  <h4>Step 2: Click "Import Excel"</h4>
  <p>Click the "Import Excel" button at the top right corner of the Register page.</p>
</div>

<h3>Preparing Your Excel File</h3>

<h4>Excel File Format</h4>
<p>Your Excel file should contain the following columns (in any order):
  <ul>
    <li><strong>Quality Objective</strong> - The quality objective</li>
    <li><strong>Quality Risk</strong> - The quality risk</li>
    <li><strong>Assessment of Risk</strong> - Assessment of risk</li>
    <li><strong>Likelihood</strong> - Likelihood (Yes/No or 1/0)</li>
    <li><strong>Adverse Effect</strong> - Adverse effect (Yes/No or 1/0)</li>
    <li><strong>Risk Applicable</strong> - Risk applicable (Yes/No or 1/0)</li>
    <li><strong>Response</strong> - Response to quality risk</li>
    <li><strong>Firm Implementation</strong> - Firm implementation</li>
    <li><strong>TOC</strong> - Test of control</li>
    <li><strong>Monitoring Activities</strong> - Monitoring activity name</li>
    <li><strong>Findings</strong> - Findings</li>
    <li><strong>Type of Deficiency</strong> - Deficiency type name</li>
    <li><strong>Root Cause</strong> - Root cause</li>
    <li><strong>Severe</strong> - Severe flag (Yes/No or 1/0)</li>
    <li><strong>Pervasive</strong> - Pervasive flag (Yes/No or 1/0)</li>
    <li><strong>Remedial Actions</strong> - Remedial actions</li>
    <li><strong>Area</strong> - ISQM area (Governance and leadership, Ethical requirements, etc.)</li>
    <li><strong>Status</strong> - Entry status (Open, Monitoring, Closed)</li>
  </ul>
</p>

<div class="info-box">
  <h4>💡 Excel Format Note</h4>
  <p>The system will try to match column names automatically. Make sure your column names match the expected format as closely as possible.</p>
</div>

<h3>Importing Data</h3>

<h4>Step 1: Select Excel File</h4>
<div class="step-box">
  <h4>Choose File</h4>
  <p>Click the "Choose File" button and select the Excel file you want to import. The file should be in .xlsx or .xls format.</p>
</div>

<h4>Step 2: Review Import Options</h4>
<div class="step-box">
  <h4>Import Options</h4>
  <p>Review the import options:
    <ul>
      <li><strong>Skip Header Row</strong> - Check this if your Excel file has a header row</li>
      <li><strong>Update Existing Entries</strong> - Check this if you want to update existing entries based on a matching field (if available)</li>
    </ul>
  </p>
</div>

<h4>Step 3: Upload and Import</h4>
<div class="step-box">
  <h4>Import File</h4>
  <p>Click the "Import" button to start the import process. The system will process the file and import the entries.</p>
</div>

<h4>Step 4: Review Import Results</h4>
<div class="step-box">
  <h4>Import Summary</h4>
  <p>After the import is complete, you'll see a summary showing:
    <ul>
      <li>Number of entries imported</li>
      <li>Number of entries that failed to import</li>
      <li>Any errors or warnings</li>
    </ul>
  </p>
</div>

<h3>Handling Import Errors</h3>

<h4>Common Errors</h4>
<p>Common import errors include:
  <ul>
    <li><strong>Invalid Area</strong> - The area value doesn't match an expected ISQM area</li>
    <li><strong>Invalid Status</strong> - The status value doesn't match an expected status</li>
    <li><strong>Missing Required Fields</strong> - Required fields are missing</li>
    <li><strong>Invalid Date Format</strong> - Date fields are in an incorrect format</li>
    <li><strong>Invalid Boolean Value</strong> - Boolean fields have invalid values</li>
  </ul>
</p>

<h4>Fixing Errors</h4>
<div class="step-box">
  <h4>Step 1: Review Error Messages</h4>
  <p>Review the error messages to identify what went wrong.</p>
</div>

<div class="step-box">
  <h4>Step 2: Fix Excel File</h4>
  <p>Fix the issues in your Excel file:
    <ul>
      <li>Correct invalid area or status values</li>
      <li>Fill in missing required fields</li>
      <li>Format dates correctly (YYYY-MM-DD or MM/DD/YYYY)</li>
      <li>Use Yes/No or 1/0 for boolean fields</li>
    </ul>
  </p>
</div>

<div class="step-box">
  <h4>Step 3: Re-import</h4>
  <p>Re-import the corrected Excel file.</p>
</div>

<h3>Best Practices</h3>
<div class="tip-box">
  <h4>💡 Best Practices</h4>
  <ul>
    <li>Use the provided Excel template if available</li>
    <li>Validate your data before importing</li>
    <li>Check column names match the expected format</li>
    <li>Test with a small file first</li>
    <li>Back up your data before importing</li>
    <li>Review import results carefully</li>
    <li>Fix errors and re-import if necessary</li>
  </ul>
</div>

<h3>Next Steps</h3>
<p>After importing data, you can:</p>
<ul>
  <li>Review the imported entries in the Register</li>
  <li>Use <a href="{{ route('user-guide.show', 'using-filters') }}">filters</a> to find imported entries</li>
  <li><a href="{{ route('user-guide.show', 'editing-entries') }}">Edit entries</a> to add additional information</li>
  <li>Check the <a href="{{ route('user-guide.show', 'compliance-now') }}">Compliance Now</a> page to see imported entries</li>
</ul>

