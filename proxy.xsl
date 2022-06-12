<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:param name="domain"/>
 <xsl:output method="xml" indent="yes"/>
 <xsl:template match="*">
 <xsl:copy>
 <xsl:apply-templates select="@*"/>
 <xsl:apply-templates/>
 </xsl:copy>
</xsl:template>
<xsl:template match="title[not(normalize-space())]">
<title>no title</title>
</xsl:template>
<xsl:template match="head">
<xsl:copy>
<xsl:apply-templates select="@*"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css"/>
<xsl:apply-templates/>
</xsl:copy>
</xsl:template>
<xsl:template match="script|link|meta|img|form|style|object|svg|input|noscript|iframe|button"/>
<xsl:template match="div[not(node())]"/>
<xsl:template match="div[ancestor::div]">
<xsl:apply-templates/>
</xsl:template>
<xsl:template match="ul[li[a and not(*[2])]]">
<nav><xsl:apply-templates/></nav>
</xsl:template>
<xsl:template match="li[a and not(*[2])]">
<xsl:apply-templates/>
</xsl:template>
<xsl:template match="li[normalize-space(.) = '|']"/>
<xsl:template match="@*[starts-with(local-name(), 'data-') or starts-with(local-name(), 'aria-')]"/>
<xsl:template match="@*">
<xsl:copy/>
</xsl:template>
<xsl:template match="ul[not(li)]|ol[not(li)]"/>
<xsl:template match="body">
<xsl:copy><main><xsl:apply-templates/></main></xsl:copy>
</xsl:template>
<xsl:template match="@href">
<xsl:attribute name="href">
<xsl:value-of select="concat('https://bince.fun/tidy.php?url=', .)"/>
</xsl:attribute>
</xsl:template>
<xsl:template match="@href[starts-with(., 'https://')]">
<xsl:attribute name="href">
<xsl:value-of select="concat('https://bince.fun/tidy.php?url=', 'http://', substring(., 9))"/>
</xsl:attribute>
</xsl:template>
<xsl:template match="li[ancestor::div[@role = 'navigation']]|ol[ancestor::div[@role = 'navigation']]|ul[ancestor::div[@role = 'navigation']]">
<xsl:apply-templates/>
</xsl:template>
<xsl:template match="@href[starts-with(., '/')]">
<xsl:attribute name="href">
<xsl:value-of select="concat('https://bince.fun/tidy.php?url=http://', $domain, .)"/>
</xsl:attribute>
</xsl:template>
<xsl:template match="a/@*[not(local-name() = 'href') or starts-with(@href, '#')]"/>
<xsl:template match="a[starts-with(@href, '#')]"/>
<xsl:template match="@id|@class|@aria-label|@target"/>
</xsl:stylesheet>