<xsl:stylesheet
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" exclude-result-prefixes="xalan java" version="1.0"
    xmlns:java="http://xml.apache.org/xalan/java"
    xmlns:me="stylesheet"
    xmlns:node="http://www.upstate.edu/chanw/node"
    xmlns:xalan="http://xml.apache.org/xalan">
    <xsl:include href="site://_common/formats/Upstate/library/node-processing"/>
    <xsl:output encoding="UTF-8" indent="yes" method="html"/>
    <!-- this format is used by pages generated for external site nav -->
    <!-- change href of a elements 
    the names of the non-intra site and intra site must contain a common part like hr and hrintra, 
    the latter having the suffix 'intra'
    -->
    <xsl:template match="a">
        <a>
            <xsl:attribute name="href">
                <xsl:variable name="href">
                    <xsl:value-of select="@href"/>
                </xsl:variable>
                <xsl:variable name="href-modified">
                    <xsl:choose>
                        <xsl:when test="java:toString(java:java.lang.Boolean.new(contains($href,'intra') and (not(contains($href,'/intra')))))='true'">
                            <xsl:value-of select="java:replaceFirst($href,'intra','/intra')"/>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="$href"/>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:variable>
                <xsl:value-of select="$href-modified"/>
            </xsl:attribute>
            <xsl:value-of select="text()"/>
        </a>
    </xsl:template>
    <!-- default -->
    <xsl:template match="@*|node()" priority="-1">
        <xsl:copy>
            <xsl:apply-templates select="@*|node()"/>
        </xsl:copy>
    </xsl:template>
    <!-- remove excessive whitespaces -->
    <xsl:template match="div//text()">
        <xsl:variable name="curtext">
            <xsl:value-of select="."/>
        </xsl:variable>
        <xsl:variable name="nonewline">
            <xsl:value-of select="java:replaceAll($curtext,'(\n){2,}','')"/>
        </xsl:variable>
        <xsl:variable name="notab">
            <xsl:value-of select="java:replaceAll($nonewline,'\t','')"/>
        </xsl:variable>
        <xsl:variable name="noextraspace">
            <xsl:value-of select="java:replaceAll($notab,'(\s){2,}','')"/>
        </xsl:variable>
        <xsl:value-of select="$noextraspace"/>
    </xsl:template>
</xsl:stylesheet>