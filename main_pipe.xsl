<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml"/>
    <xsl:template match="*">
        <xsl:copy>
            <xsl:apply-templates select="@*"/>
            <xsl:apply-templates/>
        </xsl:copy>
    </xsl:template>
    <xsl:template match="action">
        <button onclick="alert('Хаюшки')">
            <xsl:value-of select="@title"/>
        </button>
    </xsl:template>
    <xsl:template match="@*">
        <xsl:copy/>
    </xsl:template>
</xsl:stylesheet>