// HTML 
<table>
  <thead><tr><td>
    <div class="header-space">&nbsp;</div>
  </td></tr></thead>
  <tbody><tr><td>
    <div class="content">...</div>
  </td></tr></tbody>
  <tfoot><tr><td>
    <div class="footer-space">&nbsp;</div>
  </td></tr></tfoot>
</table>
<div class="header">...</div>
<div class="footer">...</div>
// CSS
.header, .header-space,
.footer, .footer-space {
  height: 100px;
}
.header {
  position: fixed;
  top: 0;
}
.footer {
  position: fixed;
  bottom: 0;
}