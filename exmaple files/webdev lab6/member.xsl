<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html> 
<body>
  <h2>House of Representatives</h2>
  <table border="1">
    <tr bgcolor="#CDF119">
      <th style="text-align:left">Name</th>
      <th style="text-align:left">State</th>
    </tr>
    <xsl:for-each select="MemberData/members/member/member-info">
    <tr>
      <td><xsl:value-of select="namelist"/></td>
      <td><xsl:value-of select="state"/></td>
    </tr>
    </xsl:for-each>
  </table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
