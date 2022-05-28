<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:output method="xml" indent="yes"/>
 <xsl:template match="/">
 <html>
  <xsl:apply-templates/>
  </html>
 </xsl:template>
 <xsl:template match="*">
 <xsl:copy>
 <xsl:copy-of select="@*"/>
 <xsl:apply-templates/>
 </xsl:copy>
 </xsl:template>
 <xsl:template match="root">
 <xsl:apply-templates/>
 </xsl:template>
</xsl:stylesheet>