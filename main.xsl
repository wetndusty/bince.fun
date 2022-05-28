<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : main.xsl
    Created on : 27 марта 2022 г., 13:01
    Author     : sla
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="xml" omit-xml-declaration="yes" />
    <xsl:template match="page">
        <html lang="ru">
            <xsl:if test="not(head)"><xsl:call-template name="nohead"/></xsl:if>
            <xsl:apply-templates select="head"/>
            <xsl:apply-templates select="body"/>
            <xsl:if test="not(body)"><xsl:call-template name="nobody"/></xsl:if>
        </html>
    </xsl:template>
    <xsl:template match="table">
        <h2>Таблица</h2>
        <table>
            <thead style="position:sticky;top:0px">
                <xsl:apply-templates select="row[1]/@*" mode="thead"/>
            </thead>
            <xsl:apply-templates/>
        </table>
    </xsl:template>
    <xsl:template match="head" name="nohead">
        <head>
            <title>
                <xsl:value-of select="ancestor-or-self::page/@title"/>
            </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <link rel="stylesheet" href="simple.css"/>
            <style>
                footer {
                bottom: 0;
                left: 0;
                position: fixed;
                right: 0;
                }</style>
        </head>
    </xsl:template>
    <xsl:template match="body" name="nobody">
        <body>
            <header>
                <h1>
                    <xsl:value-of select="ancestor::page/@title"/>
                </h1>
            </header>
            <main>
                <xsl:apply-templates/>
            </main>
            <p></p>
            <p></p>
            <p></p>
            <footer>
                <a href="/">home</a>(с) 2022</footer>
        </body>
    </xsl:template>
    <xsl:template match="row">
        <tr>
            <xsl:apply-templates select="@*"/>
            <xsl:apply-templates select="*" mode="tr"/>
        </tr>
    </xsl:template>
    <xsl:template match="json" mode="tr">
        <td><table>
            <xsl:apply-templates mode="json-table"/>
        </table>
        </td>
    </xsl:template>
        <xsl:template match="*[not(@value)]" mode="json-table">
        <tr><th colspan="2">start of <xsl:value-of select="local-name()"/></th>
        </tr>
        <xsl:apply-templates mode="json-table"/>
        <tr><th colspan="2">end of <xsl:value-of select="local-name()"/></th>
        </tr>
    </xsl:template>
    <xsl:template match="*" mode="json-table">
        <tr><td><xsl:value-of select="local-name()"/></td>
        <td><xsl:value-of select="@value"/></td>
        </tr>
        <xsl:apply-templates mode="json-table"/>
    </xsl:template>
    <xsl:template match="@*" mode="thead">
        <th>
            <xsl:value-of select="local-name()"/>
        </th>
    </xsl:template>
    <xsl:template match="@*">
        <td>
            <xsl:value-of select="."/>
        </td>
    </xsl:template>
        <xsl:template match="row/@id">
        <td>
            <a href="task.php?id={.}"><xsl:value-of select="."/></a>
        </td>
    </xsl:template>
    <xsl:template match="*">
        <xsl:element name="{local-name()}"><xsl:apply-templates select="@*" mode="copy"/>
            <xsl:apply-templates/>
        </xsl:element>
    </xsl:template>
    <xsl:template match="link">
        <a href="{@href}">
            <xsl:value-of select="@title"/>
        </a>
    </xsl:template>
    <xsl:template match="@*" mode="copy"><xsl:attribute name="{local-name()}">
            <xsl:value-of select="."/>
        </xsl:attribute>
    </xsl:template>
    <xsl:template match="root">
        <xsl:apply-templates/>
    </xsl:template>
</xsl:stylesheet>
