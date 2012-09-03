<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="html"
            indent="yes"
            encoding="utf-8"
            media-type="text/html"
            doctype-public="-//W3C//DTD HTML 4.0//EN"/>

<xsl:template match="/">
    here!
    <xsl:value-of select="//foo" />
    <xsl:value-of select="//test" />
</xsl:template>

</xsl:stylesheet>

