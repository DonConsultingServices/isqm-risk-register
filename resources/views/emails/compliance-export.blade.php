<!DOCTYPE html>
<html>
  <body style="font-family: Arial, sans-serif; color:#1f2937;">
    <h2 style="margin-bottom:16px;">ISQM Compliance Checklist</h2>
    <p>Attached is the latest compliance register for all applicable risks and responses.</p>
    <ul>
      <li><strong>Total items:</strong> {{ $summary['total'] }}</li>
      <li><strong>Marked severe:</strong> {{ $summary['severe'] }}</li>
      <li><strong>Pervasive:</strong> {{ $summary['pervasive'] }}</li>
    </ul>
    <p>You can also review the live dashboard at <a href="{{ url('/isqm/compliance-now') }}">ISQM &rarr; Compliance Now</a>.</p>
    <p style="margin-top:24px;">Regards,<br>ISQM System</p>
  </body>
</html>
