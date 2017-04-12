<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" exclude-result-prefixes="xalan java" version="1.0" xmlns:java="http://xml.apache.org/xalan/java" xmlns:me="stylesheet" xmlns:node="http://www.upstate.edu/chanw/node" xmlns:xalan="http://xml.apache.org/xalan">
    <xsl:include href="site://_common/formats/Upstate/library/node-processing"/>
    <xsl:output encoding="UTF-8" indent="yes" method="html"/>
    <!-- add elements to be hidden and shown here -->
    <xsl:variable name="hide-elements">
        <!-- these are for displaying code in wysiwyg -->
        <element id="code1" name="div"/>
        <element id="code2" name="div"/>
        <element id="code3" name="div"/>
        <element id="code4" name="div"/>
        <element id="code5" name="div"/>
        <element id="code6" name="div"/>
        <element id="code7" name="div"/>
        <element id="code8" name="div"/>
        <element id="code9" name="div"/>
        <element id="code10" name="div"/>
        <!-- this element shows up in head, before page-level-override -->
        <element id="master-level-override" name="div"/>
        <!-- this element shows up in head, right before the end tag of head -->
        <element id="page-level-override" name="div"/>
        <!-- these are zones defined in the default format -->
        <element id="zone1" name="div"/><!-- between header and site nav -->
        <element id="zone2" name="div"/><!-- between site nav and breadcrumbs -->
        <element id="zone3" name="div"/><!-- between breadcrumbs and page contents -->
        <element id="zone4" name="div"/><!-- below footer -->
    </xsl:variable>
    <!-- used by Angular.js -->
    <xsl:template match="html">
        <xsl:variable name="html-ng-app">
            <xsl:value-of select="//div[@id='hide-html-ng-app']"/>
        </xsl:variable>
        <xsl:choose>
            <xsl:when test="not($html-ng-app='')">
                <xsl:processing-instruction name="php">require_once('cascade/cascade_global.php');$responsive = true;echo $doctype;</xsl:processing-instruction>
                <html data-ng-app="{$html-ng-app}" lang="en">
                    <xsl:apply-templates select="node()"/>
                </html>
            </xsl:when>
            <xsl:otherwise>
                <xsl:processing-instruction name="php">require_once('cascade/cascade_global.php');$responsive = true;echo $doctype;</xsl:processing-instruction>
                <html lang="en">
                    <xsl:apply-templates select="node()"/>
                </html>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="body">
        <xsl:variable name="body-ng-controller">
            <xsl:value-of select="//div[@id='hide-body-ng-controller']"/>
        </xsl:variable>
        <xsl:choose>
            <xsl:when test="not($body-ng-controller='')">
                <body data-ng-controller="{$body-ng-controller}">
                    <xsl:apply-templates select="node()"/>
                </body>
            </xsl:when>
            <xsl:otherwise>
                <body>
                    <xsl:apply-templates select="node()"/>
                </body>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <!-- hide/show mechanism -->
    <xsl:template match="@*|node()" priority="-1">  
        <xsl:variable name="name" select="name(.)"/>
        <xsl:variable name="id" select="@id"/>
        <!-- hide-whatever -->
        <xsl:variable name="hideid" select="concat('hide-', substring-after(@id, 'show-'))"/>
        <!-- content of hide-whatever -->
        <xsl:variable name="hidden" select="//node()[name(.)=$name and @id=$hideid]/node()"/>               
        
        <xsl:choose>
            <!-- remove hide-whatever -->
            <xsl:when test="xalan:nodeset($hide-elements)/element[@name=$name and $id=concat('hide-', @id)]"/>
            <!-- show the content of hide-whatever in the show-whatever area -->
            <xsl:when test="xalan:nodeset($hide-elements)/element[@name=$name and $id=concat('show-', @id)]">
                <xsl:apply-templates select="$hidden"/>
            </xsl:when>
            <!-- other nodes and attributes -->
            <xsl:otherwise>
                <xsl:copy>
                    <xsl:apply-templates select="@*|node()"/>
                </xsl:copy>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <!-- used to remove excessive whitespaces -->
    <xsl:template match="head//text()">
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
    <xsl:template match="body//text()[not(ancestor::pre)]">
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
    <!-- process the a tag and add icons -->
    <xsl:template match="//a[ancestor::div[@id='page-content-div']][not(img) and not(div)][not(following-sibling::img)]">
        <xsl:choose>
            <xsl:when test="//text()">
                <xsl:call-template name="node:process-a">
                    <xsl:with-param name="node" select="."/>
                </xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <a><xsl:apply-templates select="@*|node()"/></a>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>