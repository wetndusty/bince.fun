<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:ns2="http://пф.рф/СЗИ-ИЛС/2020-11-19" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>resume</title>
            </head>
            <body>
                <table>
                    <xsl:apply-templates/>
                </table>
            </body>
        </html>
    </xsl:template>
    <xsl:template match="ds:Signature|ns2:НПФ|ns2:СлужебнаяИнформация" priority="1"/>
    <xsl:template match="*[*]">
        <tr><th colspan="2">start of <xsl:value-of select="local-name()"/></th></tr>
        <xsl:apply-templates/>
        <tr><th colspan="2">end of <xsl:value-of select="local-name()"/></th></tr>
    </xsl:template>
    <xsl:template match="*[not(*)]">
        <tr>
            <td>
                <xsl:value-of select="local-name()"/>
            </td>
        <td>
            <xsl:value-of select="text()"/>
        </td>
        </tr>
    </xsl:template>
        
</xsl:stylesheet>
